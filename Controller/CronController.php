<?php

namespace Dywee\CoreBundle\Controller;

use Dywee\NotificationBundle\Entity\Notification;
use Dywee\OrderBundle\Entity\Shipment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;

class CronController extends Controller
{
    public function cronTask()
    {
        return $this->mainAction();
    }

    public function mainAction()
    {
        $response = '<html><body><p>--> Cron 0.1</p>';
        $response .= '<p>----------------------------------------------------------------------</p>';

        $response .= '<p>Nettoyage des commandes annulées</p>';


        $em = $this->getDoctrine()->getManager();
        $or = $em->getRepository('DyweeOrderBundle:BaseOrder');

        $os = $or->findBy(
            array(
                'state' => 0)
        );

        foreach($os as $o)
            $em->remove($o);
        $em->flush();

        $response .= '<p>----------------------------------------------------------------------</p>';

        $os = $or->findBy(
            array(
                'state' => 1
            )
        );

        $newOrderNotificationCounter = 0;

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->container->getParameter('paypal.clientID'),
                $this->container->getParameter('paypal.clientSecret')
            )
        );

        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration

        $apiContext->setConfig(
            array(
                'mode' => $this->container->getParameter('paypal.mode'),
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => $this->container->getParameter('paypal.logLevel'), // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS, DEBUG for testing
                'validation.level' => 'log',
                'cache.enabled' => true,
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
            )
        );

        foreach($os as $order)
        {
            $response .= '<p>Gestion de la commande #'.$order->getId();
            if($order->getPayementMethod() == 3)
            {
                $response .= '<br>Paypal détecté';
                $paymentId = $order->getPayementInfos();

                try {
                    $payment = Payment::get($paymentId, $apiContext);
                } catch (PayPalConnectionException $ex) {
                    $data = json_decode($ex->getData());
                    if($data->name == 'PAYMENT_APPROVAL_EXPIRED')
                    {
                        $response .= '<br>Paiement annulé par l\'utilisateur<br>';
                        $order->setPayementState(4);
                        $order->setState(0);
                        $em->persist($order);
                        $em->flush();
                    }
                }

                if(isset($payment) && $payment->getState() == 'approved')
                {
                    $response .= '<br>Paypal validé, mise à jour de la commande';
                    $order->setState(2);
                    $order->setPayementState(2);
                    $order->setDeliveryState(1);

                    $em->persist($order);
                    $em->flush();


                    $bill = $this->renderView('DyweeOrderBundle:Order:invoice.html.twig', array(
                        'order'  => $order
                    ));

                    /*$this->get('knp_snappy.pdf')->generateFromHtml(
                        $bill,
                        'files/invoices/'.str_replace(' ', '_', $order->getInvoiceReference()).'.pdf'
                    );//*/

                    //$pdfGenerator = $this->get('spraed.pdf.generator');

                    //$response .= '<br>Envoi du mail de confirmation';

                    $message = \Swift_Message::newInstance()
                        ->setSubject('Confirmation de votre paiement')
                        ->setFrom('info@labelgiqueunefois.com')
                        ->setTo($order->getBillingAddress()->getEmail())
                        ->setBody($this->renderView('DyweeOrderBundle:Email:mail-step2.html.twig', array('order' => $order)))
                        //->attach(Swift_Attachment::fromPath($pdfGenerator->generatePDF($bill, 'UTF-8')))
                    ;
                    $message->setContentType("text/html");
                    $this->get('mailer')->send($message);

                    $newOrderNotificationCounter++;
                }
            }
            $response .= '<br>Fin de la gestion de la commande #'.$order->getId().'</p>';

            if($newOrderNotificationCounter > 0)
            {
                $notification = new Notification();
                $notification->setContent($newOrderNotificationCounter . ' nouvelles commandes');
                $notification->setType(1);

                $em->persist($notification);
                $em->flush();
            }
        }

        $response .= '<p>----------------------------------------------------------------------</p>';
        $response .= '<p>Suppression des vieilles commandes en session (> 1 semaine)</p>';

        $lastWeek = new \DateTime('last week');

        $os = $or->findBy(
            array(
                'state' => -1,
                'totalPrice' => 0
            ),
            array('creationDate' => 'asc'),
            200
        );

        foreach($os as $order)
        {
            if($order->getCreationDate() < $lastWeek)
            {
                $response .= '<p>Essai de suppression de la commande #'.$order->getId();
                $em->remove($order);
                $em->flush();
                $response .= '<br>Suppression réussie</p>';
            }
        }

        //*/

        $response .= '<p>Fin de la gestion des commandes en session</p>';

        $response .= '<p>----------------------------------------------------------------------</p>';
        $response .= '<p>Suppression des vieilles commandes en attente (> 1 mois)</p>';

        /*$lastMonth = new \DateTime('last month');

        $os = $or->findBy(
            array(
                'state' => 1,
            )
        );

        foreach($os as $order)
        {
            if($order->getCreationDate() < $lastMonth)
            {
                $response .= '<p>Essai de suppression de la commande #'.$order->getId();
                $em->remove($order);
                $em->flush();
                $response .= '<br>Suppression réussie</p>';
            }
        }*/

        $response .= '<p>----------------------------------------------------------------------</p>';
        $response .= '<p>Gestion des envois</p>';

        $sr = $em->getRepository(Shipment::class);
        $ss = $sr->findByActive();

        $client = new \nusoap_client("http://www.mondialrelay.fr/WebService/Web_Services.asmx?WSDL", true);
        $client->soap_defencoding = 'utf-8';

        foreach($ss as $shipment)
        {
            $response .= '<p>Tracing de l\'envoi #'.$shipment->getId().'<br>';

            $shipment->setUpdateDate(new \DateTime());

            $params = array(
                'Enseigne' => "BEBLCBLC",
                'Expedition' => $shipment->getTracingInfos(),
                'Langue' => 'FR'
            );
            $security = '';
            foreach($params as $param)
                $security .= $param;
            $security .= 'xgG1mpth';
            $params['Security'] = strtoupper(md5($security));

            $result = $client->call(
                'WSI2_TracingColisDetaille',
                $params,
                'http://www.mondialrelay.fr/webservice/',
                'http://www.mondialrelay.fr/webservice/WSI2_CreationEtiquette'
            );

            if(isset($result['WSI2_TracingColisDetailleResult']['STAT']) && is_numeric($result['WSI2_TracingColisDetailleResult']['STAT'])){
                if($result['WSI2_TracingColisDetailleResult']['STAT'] == 80) {
                    if ($shipment->getState() != 6)
                    {
                        $shipment->setState(6);
                    }
                }


                else if($result['WSI2_TracingColisDetailleResult']['STAT'] == 81)
                {
                    $shipment->setState(2);

                }
                else if($result['WSI2_TracingColisDetailleResult']['STAT'] == 82)
                {
                    if($shipment->getState() != 9)
                    {
                        $shipment->setState(9);
                        if(!$shipment->getMailSended()) {
                            if ($shipment->getOrder()->isGift() == 1) {
                                $message = \Swift_Message::newInstance()
                                    ->setSubject('La Belgique une fois - Le colis a été réceptionné')
                                    ->setFrom('info@labelgiqueunefois.com')
                                    ->setTo($shipment->getOrder()->getBillingAddress()->getEmail())
                                    ->setBody($this->renderView('DyweeOrderBundle:Email:mail-step5.html.twig', array('order' => $shipment->getOrder())));
                                $message->setContentType("text/html");
                                $this->get('mailer')->send($message);
                            }
                            $shipment->setMailSended(true);
                        }
                    }
                }
            }
            $response .= 'Statut: '.$result['WSI2_TracingColisDetailleResult']['STAT'].'<br>';
            $em->persist($shipment);
            $em->flush();
        }

        $response .= 'Fin de la gestion de l\'envoi</p>';

        $response .= '<p>----------------------------------------------------------------------</p>'; //*/

        $response .= '<p>----------------------------------------------------------------------</p>';
        $response .= '<p>Check des commandes finies</p>';

        $orderList = $or->findBy(array('state' => 2));

        foreach($orderList as $order)
        {
            $response .= '<p>Test de la commande #'.$order->getId().'<br>';
            $check = $order->checkIfIsDone();
            if($check == 0) {
                $em->persist($order);
                $response .= 'Commande cloturée</p>';
            }
            else $response .= 'Commande encore active ('.$check.' envois restants)</p>';

            $em->flush();

        }

        $response .= '<p>/check</p>';

        $response .= '<p>--> /cron</p></body></html>';
        return New Response($response);
    }

}

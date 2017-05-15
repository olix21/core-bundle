<?php

namespace Dywee\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Controller\UserController;


trait Referer {
    private function getRefererParams() {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
        return $this->get('router')->getMatcher()->match($lastPath);
    }
}


abstract class ParentController extends Controller
{
    use Referer;
    protected $repositoryName;
    protected $entityClassNameWithNamespace;
    protected $entityClassName;
    protected $entityClassNameUnderscored;
    protected $listName;
    protected $bundleName;
    protected $tableViewName;

    public function __construct()
    {
        $this->getObjectNames();
    }

    //Rewrite this to erase some properties
    public function redefine()
    {
        return false;
    }

    public function getObjectNames($object = null)
    {
        $this->entityClassNameWithNamespace = str_replace(array('Controller', '\\\\'), array('', '\Entity\\'), get_class($object ?? $this));

        $reflection = new \ReflectionClass($this->entityClassNameWithNamespace);

        $this->entityClassName = $reflection->getShortName();
        $this->bundleName = str_replace(array('\\Entity', '\\'), '', $reflection->getNamespaceName());
        $this->repositoryName = $this->bundleName . ':' . $this->entityClassName;

        //To underscore
        $split = str_split($this->entityClassName);
        $return = '';
        foreach($split as $letter){
            if(ctype_upper($letter) && strlen($return) > 1){
                $return .= '_';
            }
            $return .= $letter;
        }
        $this->entityClassNameUnderscored = strtolower($return);

        $this->listName = lcfirst($this->entityClassName);
        if (substr($this->listName,-1) === "y"){
            $this->listName = substr($this->listName,0,-1)."ies";
        }
        elseif(substr($this->listName, -1) !== 's'){
            $this->listName .= 's';
        }

        $this->tableViewName = strtolower($this->entityClassNameUnderscored.'_table');

        $this->redefine();
    }

    public function getEntityNameSpace()
    {
        return $this->entityClassNameWithNamespace;
    }

    public function viewAction($object, $parameters = null)
    {
        if(is_numeric($object))
            $object = $this->getFromId($object, $parameters);

        return $this->handleView(array('view' => 'view', 'data' => array(lcfirst($this->entityClassName) => $object)), $parameters);
    }

    public function tableAction($parameters = null)
    {
        return $this->handleView(array(
            'view' => 'table',
            'data' => array(
                $this->listName => $this->getList($parameters)
            )),
            $parameters
        );
    }

    public function dashboardAction($parameters = null)
    {
        return $this->handleView(array(
            'view' => 'dashboard',
            'data' => array(
                $this->listName => $this->getList($parameters)
            )),
            $parameters
        );
    }

    private function getList($parameters)
    {
        $repositoryMethod = isset($parameters['repository_method']) ? $parameters['repository_method'] : 'findAll';

        $repository = $this->getDoctrine()->getRepository($this->repositoryName);

        return (isset($parameters['repository_argument'])) ? $repository->$repositoryMethod($parameters['repository_argument']): $repository->$repositoryMethod();
    }

    public function addAction(Request $request, $parameters = null)
    {
        return $this->handleForm(new $this->entityClassNameWithNamespace(), $request, $parameters);
    }

    public function updateAction($object, Request $request, $parameters = null)
    {
        return $this->handleForm(is_numeric($object) ? $this->getFromId($object) : $object, $request, $parameters);
    }

    //Créer/gère le formulaire + ajout/modif dans la BDD
    public function handleForm($object, Request $request, $parameters = null)
    {
        $new = $object->getId() === null;

        $type = str_replace('Entity', 'Form', $this->entityClassNameWithNamespace.'Type');

        if(isset($parameters['bundleFormName']) || isset($parameters['entityFormName']))
        {
            $bundleName = isset($parameters['bundleFormName']) ? $parameters['bundleFormName'] : $this->bundleName;
            $entityName = isset($parameters['entityFormName']) ? $parameters['entityFormName'] : $this->entityClassName;
            $type = $bundleName.'\Form\\'.$entityName.'Type';
        }

        $formBuilder = isset($parameters['form']) ? $parameters['form'] : $this->get('form.factory')->createBuilder($type, $object);

        if (isset($parameters["formAction"])){
            $formBuilder->setAction($parameters['formAction']);
        }

        $form = $formBuilder->getForm();
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Méthode d'execution automatique de PrePersist
            //if(method_exists($object, 'prePersist'))
            //    $object->prePersist();

            $em->persist($object);
            $em->flush();

            if ($request->isXmlHttpRequest())
                return new JsonResponse();

            $request->getSession()->getFlashBag()->set('success', $this->entityClassName ?? 'Objet' . ' correctement ' . ($new ? 'ajouté' : 'modifié'));

            return $this->handleRedirection($parameters, $request, $object);
        }
        
        $view = $new ? 'add' : 'edit';
        if (isset($parameters['viewName']))
        {
            $view = $parameters['viewName'];
        }

        return $this->handleView([
            'view' => $view,
            'data' => [
                'form' => $form->createView()
            ]
        ], $parameters);
    }

    public function handleRedirection($parameters, $request, $object = null)
    {
        if(array_key_exists('redirectTo', $parameters))
        {
            if($parameters['redirectTo'] === 'referer'){
                return $this->redirect($this->getPreviousRoute($request));
            }
            if(isset($parameters['routingArgs'], $parameters['routingArgs']['id']) && $parameters['routingArgs']['id'] === 'object_id'){
                $parameters['routingArgs']['id'] = $object->getId();
            }

            return $this->redirect($this->generateUrl($parameters['redirectTo'], array_key_exists('routingArgs', $parameters) ? $parameters['routingArgs'] : array()));
        }
        elseif(array_key_exists('return', $parameters) && $parameters['return'] === 'bool'){
            return true;
        }

        elseif (method_exists($object, 'getParentEntity') && $object->getParentEntity()->getId()){
            return $this->redirect($this->generateUrl($this->tableViewName, array('id' => $object->getParentEntity()->getId())));
        }
        else{
            return $this->redirect($this->generateUrl($this->tableViewName));
        }

        return false;
    }

    public function tableFromParentAction($id, $parameters = null)
    {
        $entity = new $this->entityClassNameWithNamespace();

        $parentEntity = $entity->getParentEntity();
        $reflection = new \ReflectionClass($parentEntity);

        //On récupère l'entité parente
        $parentEntity = $this->getDoctrine()->getRepository(explode(':', $this->repositoryName)[0].':'.$reflection->getShortName())->findOneById($id);


        //On récupère la liste des entités enfants à partir de l'entité parente
        $repository = $this->getDoctrine()->getRepository($this->repositoryName);

        if($this->entityClassName === $reflection->getShortName())
            $methodName = 'findByParent';
        else $methodName = 'findBy'.$reflection->getShortName();

        return $this->handleView(array(
            'view' => 'table',
            'data' => array(
                $reflection->getShortName() => $parentEntity,
                $this->listName => $repository->$methodName($parentEntity)
            )),
            $parameters
        );
    }

    public function addFromParentAction($id, Request $request, $parameters = null)
    {
        //On résupère l'entité et l'entité parent
        $entity = new $this->entityClassNameWithNamespace();
        $parentEntity = $entity->getParentEntity();

        $reflection = new \ReflectionClass($parentEntity);

        //Get the parent entity namespace TestBundle\Entity and explode by "\", get [0] element
        $parentRepositoryName = explode('\\', $reflection->getNamespaceName())[0].':'.$reflection->getShortName();
        $parentEntity = $this->getDoctrine()->getRepository($parentRepositoryName)->findOneById($id);

        //On set l'entité parente dans l'entité à ajouter
        if($this->entityClassName === $reflection->getShortName())
            $methodParentName = 'setParent';
        else $methodParentName = 'set'.$reflection->getShortName();

        $entity->$methodParentName($parentEntity);

        $parameters['redirectUrlParameters'] = array('id' => $parentEntity->getId());

        return $this->handleForm($entity, $request, $parameters);
    }

    public function deleteAction($object, Request $request, $parameters = null)
    {
        if(is_numeric($object))
            $object = $this->getFromId($object);

        $em = $this->getDoctrine()->getManager();
        $em->remove($object);
        $em->flush();

        $message = 'Element bien supprimé';

        if($request->isXmlHttpRequest())
            return new Response(json_encode(array('type' => 'success', 'content' => $message)));

        $this->get('session')->getFlashBag()->set('success', $message);

        return $this->handleRedirection($parameters, $request);
    }

    public function handleView($mainParameters, $parameters = null)
    {
        $parentPath = isset($parameters['viewFolder']) ? $this->bundleName.':'.$parameters['viewFolder'] : str_replace('\\', '', $this->repositoryName);
        $fileName = isset($mainParameters['view']) ? $mainParameters['view'] : 'dashboard';

        if(isset($parameters['viewName']))
            $fileName = $parameters['viewName'];

        //TODO $parameters['add_data'] deprecated

        $data =
            array_merge(
                isset($mainParameters['data']) ? $mainParameters['data'] : array(),
                isset($parameters['add_data']) ? $parameters['add_data'] : array(),
                isset($parameters['data']) ? $parameters['data'] : array()
            )
        ;

        //TODO: AJOUTER un renderView from $parameters !!!!!!!!!!!!!!!!!!!
        if (isset($parameters['renderView']) && $parameters['renderView'])
            return $this->renderView($parentPath.':'.$fileName.'.html.twig', $data);
        else
            return $this->render($parentPath.':'.$fileName.'.html.twig', $data);
    }

    public function getPreviousRoute($request)
    {
        return $request->server->get('HTTP_REFERER');
    }

    public function getFromId($id, $parameters = null)
    {
        $repository = $this->getDoctrine()->getRepository($this->repositoryName);

        $method = (isset($parameters["repository_method"])) ? $parameters["repository_method"] : 'findOneById';
        $object = $repository->$method($id);

        if(!$object)
            throw $this->createNotFoundException('Objet non trouvé');

        return $object;
    }
}

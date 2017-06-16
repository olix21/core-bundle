<?php
// Dywee/CoreBundle/Form/DateRangeType.php
namespace Dywee\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DateRangeType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}
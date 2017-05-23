<?php
// Dywee/CoreBundle/Form/DateRangeType.php
namespace Dywee\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DateRangeType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}

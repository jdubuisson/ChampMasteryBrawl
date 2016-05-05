<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterOpponentsType extends AbstractType
{
    private $regions;

    public function __construct(array $regions)
    {
        $this->regions = array('any' => 'any') + $regions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('nameFilter', TextType::class, array('required' => false))
            ->add('region', ChoiceType::class, array(
                'choices' => $this->regions,))
            ->add('filter', SubmitType::class, array(
                'attr' => array('class' => 'btn-primary')));
    }
}
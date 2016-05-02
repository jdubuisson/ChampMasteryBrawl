<?php
namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkSummonerType extends AbstractType
{
    private $regions;

    public function __construct(array $regions)
    {
        $this->regions = $regions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('region', ChoiceType::class, array(
                'choices' => $this->regions,))
            ->add('linkaccount', SubmitType::class, array(
                'attr' => array('class' => 'btn-default')));
    }
}
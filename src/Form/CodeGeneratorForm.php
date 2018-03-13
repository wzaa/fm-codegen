<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CodeGeneratorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberOfCodes', NumberType::class, [
                'label' => 'How many codes to generate'
            ])
            ->add('lengthOfCode', NumberType::class, [
                'label' => 'How long the codes should be'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Generate!'
            ])
        ;
    }
}

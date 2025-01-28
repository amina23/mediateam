<?php

namespace App\Form;

use App\DTO\ItemDTO;
use App\DTO\SubItemDTO;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubItemForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('description', TextType::class);
        $builder->add('item', EntityType::class, ['class' => Item::class, 'choice_label' => 'title']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => SubItemDTO::class, 'csrf_protection' => false]);
    }

}

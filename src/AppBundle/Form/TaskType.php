<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'id',
            'hidden'
        );
        if (isset($options['validation_groups'])
            && count($options['validation_groups'])
            && !in_array('task-delete', $options['validation_groups'])
        ) {
            $builder->add(
                'name',
                'text',
                array(
                    'label'       => 'Task Name',
                    'required'    => true,
                    'max_length'  => 128
                )
            );
            $builder->add(
                'description',
                'textarea',
                array(
                    'label'       => 'Task Description',
                    'required'    => false,
                    'max_length'  => 256
                )
            );
            $builder->add(
                'users',
                'entity',
                array(
                    'multiple' => true,
                    'expanded' => true,
                    'property' => 'username',
                    'class'    => 'AppBundle:User'
                )
            );
      }
        $builder->add(
            'save',
            'submit',
            array(
                'label' => 'Save'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Task',
                'validation_groups' => 'tasks-add',
              )
        );
    }

    public function getName()
    {
        return 'task';
    }
}

<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

// use Symfony\Component\Form\CsrfProvider\CsrfProviderInterface;
// use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider as CsrfProvider;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, ['label' => 'pseudo']);
        $builder->add('password', PasswordType::class, ['label' => 'mot de passe']);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            // 'csrf_protection' => true,
            // 'csrf_field_name' => '_token',
            // 'intention' => 'registerCheck'
        ));
    }

    public function getName()
    {
        return 'tdn_login';
    }
}

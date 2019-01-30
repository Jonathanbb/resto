<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\LoginType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function loginAction (Request $request) {
          $session = $request->getSession();

          $form = $this->createForm(LoginType::class, new User());

          // get the login error if there is one
          // if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
          //   $error = $request->attributes->get(
          //     SecurityContext::AUTHENTICATION_ERROR
          //   );
          // } else {
          //   $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
          //   $session->remove(SecurityContext::AUTHENTICATION_ERROR);
          // }

          return $this->render('user/login.html.twig',
          array(
            // last username entered by the user
            'last_username' => null,
            'error'         => null,
            'form'          => $form->createView(),
            'redirect_url'  => $this->generateURL('homepage'),
            'redirect_params' => array()
          )
        );
      }
      public function registerCheckAction(Request $request)	{

          $em = $this->getDoctrine()->getManager();
          $session = $this->container->get('session');
          $factory = $this->container->get('security.encoder_factory');
          $URLmanager = $this->get('tdn.document.url');

          $form = $this->createForm(new InscriptionType(), new Inscription);
          $form->bind($request);
          // L'inscription suit-elle un abonnement à la newsletter ?
          $pathNewsletter = $request->get('nslFollowing');
          if ($pathNewsletter == 1) {
            $referer = $request->get('referer');
            $callback = $request->get('callback');
            $_isValide = ($callback = base64_encode($referer));
          } else {
            $_isValide = $form->isValid();
          }
          if ($_isValide) {
            // Recherche de rôle
            $registration = $form->getData();
            $user = $form->getData()->getUser();
            $rep = $repository = $em->getRepository('AppBundle:User');
            $rep_roles = $em->getRepository('Bundle:Role');
            $role = $rep_roles->find('ROLE_USER');

            $user->addRole($role);
            $nakedPassword = $user->getPassword();
            $user->setSalt(uniqid());
            $encoder = $factory->getEncoder($user);
            $pwd = $encoder->encodePassword($nakedPassword, $user->getSalt());
            $user->setPassword($pwd);
            // Valeurs par defaut
            // Enregistrment
            $em->persist($nana);
            $em->flush();


            $this->authenticateUser($nana);
            // $key = '_security.general.target_path';
            // if ($session->has($key)) {
            //     $url = $session->get($key);
            //     $session->remove($key);
            // } else {
            //     $url = $this->container->get('router')->generate('homepage');
            // }

            // $this->get('session')->getFlashBag()->add('success', 'Merci. Ton compte est créé, tu peux te connecter');
            // return $this->redirectToroute($url);
          } else {
            $errors = array();
            foreach ($form->getErrors() as $key => $error) {
              $errors[] = $error->getMessage();
            }
            print_r($errors);
            // $report = implode(', ', $errors);
            // $this->get('session')->getFlashBag()->add('fail', 'Tu as fait une erreur dans tes données d’inscription : '.$report);
          }

        }

}

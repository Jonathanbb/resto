<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller
{
    /**
     * Lists all menu entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('AppBundle:Menu')->findAll();

        return $this->render('menu/index.html.twig', array(
            'menus' => $menus,
        ));
    }


    public function indexClientAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('AppBundle:Menu')->findAll();

        return $this->render('menu/public.index.html.twig', array(
            'menus' => $menus,
        ));
    }


    public function indexClientCategoryAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('AppBundle:Menu')->findBy(['categorie' => $id]);

        return $this->render('menu/public.index.html.twig', array(
            'menus' => $menus,
        ));
    }


    public function addCartAction(int $id)
    {
        $_SESSION['panier'][$id] = 1;

        // return $this->render('menu/public.index.html.twig', array(
        //     'id' => $id,
        // ));

        return $this->redirectToRoute('menu_index_public');
    }


    public function checkCartAction()
    {
      $em = $this->getDoctrine()->getManager();
      $rep = $em->getRepository('AppBundle:Menu');
      $panier = [];
      foreach ($_SESSION['panier'] as $plat_id => $quantite) {
        $panier [] = $rep->find($plat_id);
      }

        // return $this->render('menu/public.index.html.twig', array(
        //     'id' => $id,
        // ));

        return $this->render('menu/panier.html.twig', array (
          'cartes' => $panier
        ));
    }


    public function cleanCartAction()
    {
      $_SESSION['panier'] = [];
      return $this->redirectToRoute('carte_panier_check');
    }



    /**
     * Creates a new menu entity.
     *
     */
     public function newAction(Request $request)
     {
       $menu = new Menu();
       $form = $this->createForm('AppBundle\Form\MenuType', $menu);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {

         // Traitemùent de l'image
         $file = $menu->getProductImage();
         // $fileName = 'test.'.$file->guessExtension();
         // $fileName = $file->getClientOriginalName().'.'.$file->guessExtension();
         $fileName = $file->getClientOriginalName();

         try {
           $file->move(
             $this->getParameter('images_directory'),
             $fileName
           );
         } catch (FileException $e) {
           // ... handle exception if something happens during file upload
         }

         $menu->setProductImage($fileName);
         // Fin de traitement de l'image

         $em = $this->getDoctrine()->getManager();
         $em->persist($menu);
         $em->flush();

         return $this->redirectToRoute('menu_show', array('id' => $menu->getId()));
       }

       return $this->render('menu/new.html.twig', array(
         'menu' => $menu,
         'form' => $form->createView(),
       ));
     }

    /**
     * Finds and displays a menu entity.
     *
     */
    public function showAction(Menu $menu)
    {
        $deleteForm = $this->createDeleteForm($menu);

        return $this->render('menu/show.html.twig', array(
            'menu' => $menu,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing menu entity.
     *
     */
    public function editAction(Request $request, Menu $menu)
    {
        $deleteForm = $this->createDeleteForm($menu);
        $editForm = $this->createForm('AppBundle\Form\MenuType', $menu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menu_edit', array('id' => $menu->getId()));
        }

        return $this->render('menu/edit.html.twig', array(
            'menu' => $menu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a menu entity.
     *
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        $form = $this->createDeleteForm($menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menu);
            $em->flush();
        }

        return $this->redirectToRoute('menu_index');
    }

    /**
     * Creates a form to delete a menu entity.
     *
     * @param Menu $menu The menu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Menu $menu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menu_delete', array('id' => $menu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

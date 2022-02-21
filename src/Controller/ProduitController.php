<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $rep): Response
    {
        $p = $rep->findAll();
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'data' => $p
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/produit_add" , name="produit_add")
     */
    public function create(Request $request , EntityManagerInterface $em){
        $prod = new Produit();
        $form = $this->createForm(ProduitType::class, $prod);
        //$form->add('Envoyer' , SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
           // $file = $prod->getImage();
            //$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
           // $file->move($this->getParameter('brochures_directory'), $fileName);
           // $prod->setImage($fileName);
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/add.html.twig' , ['prod' => $prod,'fadd'=>$form->createView()]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/produit_delete/{id}" , name ="produit_d")
     */

    public function delete($id,ProduitRepository  $rep , EntityManagerInterface $em)
    {
        $rec = $rep->find($id);
        $em->remove($rec);
        $em->flush();
        return $this->redirectToRoute('produit');
    }

    /**
     * @Route("produit_update/{id}", name="produit_u")
     * @param int $id
     * @param Request $request
     * @param ProduitRepository $Rep
     * @return Response
     */
    public function update(int $id, Request $request, ProduitRepository $Rep): Response
    {
        $prod = $Rep->find($id);
        $form = $this->createForm(ProduitType::class, $prod);
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('produit');
        }
        return $this->render('produit/add.html.twig', [
            'fadd' => $form->createView(),
        ]);
    }


}

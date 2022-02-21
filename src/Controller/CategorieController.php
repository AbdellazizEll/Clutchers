<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategorieType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CategoriesRepository $rep): Response
    {
        $cat = $rep->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'cat' => $cat
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManager $entityManager
     * @Route("/categorie_add", name="categorie_add")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function  Create_Category(Request $request , EntityManagerInterface $entityManager){
        $cat = new Categories();
        $form = $this->createForm(CategorieType::class, $cat);
        //$form->add('Envoyer' , SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('categorie');
        }

        return $this->render('categorie/add.html.twig' , [
            'fadd'=>$form->createView()
        ]);
    }

    /**
     * @param $id
     * @param CategoriesRepository $rep
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/categorie_del/{id}", name="categorie_del")
     */
    public function DeleteCategory($id , CategoriesRepository $rep , EntityManagerInterface $em){
        $cat = $rep->find($id);
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute('categorie');
    }
}

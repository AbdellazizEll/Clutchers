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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\Entity\Urlizer;



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
            'Prod' => $p
        ]);
    }

    /**
     * @Route("/affichage_Prod", name="affichage_Prod")
     */

    public function affichageProd() {
        $Prod = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll(); // select * from product


        return $this->render("produit/index.html.twig",array("Prod"=>$Prod));
    }

    /**
     * @Route("/produit_add" , name="produit_add")
     */
    public function create(Request $request){
        $prod = new Produit();
        $form = $this->createForm(ProduitType::class, $prod);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $prod->setImage($newFilename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('affichage_Prod');
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
     * @Route("produit_update_{id}", name="produit_u")

     * @return Response
     */
    public function update(int $id, Request $request, ProduitRepository $Rep): Response
    {
        $prod = $Rep->find($id);
        $form = $this->createForm(ProduitType::class, $prod);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $prod->setImage($newFilename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('affichage_Prod');
        }


        return $this->render('produit/update.html.twig' , ['prod' => $prod,'fadd'=>$form->createView()]);
    }

    /**
     * @param ProduitRepository $rep
     * @return Response
     * @Route ("/shop", name="shop")
     */
    public function Display(ProduitRepository $rep){
        $prod = $rep->findAll();
        return $this->render('shop.html.twig', ['prod'=>$prod ]);
    }

}

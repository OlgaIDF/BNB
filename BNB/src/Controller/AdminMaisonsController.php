<?php

namespace App\Controller;

use App\Entity\Maisons;
use App\Form\MaisonType;
use App\Repository\MaisonsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMaisonsController extends AbstractController
{
    /**
     * @Route("/admin/maisons", name="admin_maisons")
     */
    public function index(MaisonsRepository $maisonsRepository)
    {
        $maisons = $maisonsRepository->findAll();
        return $this->render('admin/adminMaisons.html.twig', [
            'maisons' => $maisons,
        ]);
    }
    /**
     * @Route("/admin/maisons/create", name="maison_create")
     */
    public function createMaison(Request $request)
    {
        $maison = new Maisons();
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager=$this->getDoctrine()->getManager();
            $manager->persist($maison);
            $manager->flush();
            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/adminMaisonForm.html.twig', [
            'formulaireMaison' => $form->createView()
        ]);
    }
}

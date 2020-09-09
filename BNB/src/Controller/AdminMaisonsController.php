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

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($maison);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La maison a bien été ajoutée'
                );
            } else {

                $this->addFlash(
                    'danger',
                    'Erreur'
                );
            }
            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/adminMaisonForm.html.twig', [
            'formulaireMaison' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/maisons/update-{id}", name="maison_update")
     */
    public function updateMaison(MaisonsRepository $maisonsRepository, $id, Request $request)
    {
        $maison = $maisonsRepository->find($id);

        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($maison);
            $manager->flush();

            $this->addFlash(
                'success',
                'La maison a bien été editée'
            );
            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/adminMaisonForm.html.twig', [
            'formulaireMaison' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/maisons/delete-{id}", name="maison_delete")
     */
    public function deleteMaison(MaisonsRepository $maisonsRepository, $id)
    {
        $maison = $maisonsRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($maison);
        $manager->flush();

       

        return $this->redirectToRoute('admin_maisons');
    }
}

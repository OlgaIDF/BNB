<?php

namespace App\Controller;

use App\Repository\MaisonsRepository;
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
}

<?php

namespace App\Controller;

use App\Repository\MaisonsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MaisonsRepository $maisonsRepository)
    {

        $maisons = $maisonsRepository->findSix();

        return $this->render('home/index.html.twig', [
            'maisons' => $maisons,
        ]);
    }
}

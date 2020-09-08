<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminMaisonsController extends AbstractController
{
    /**
     * @Route("/admin/maisons", name="admin_maisons")
     */
    public function index()
    {
        return $this->render('admin/adminMaisons.html.twig', [
            'controller_name' => 'AdminMaisonsController',
        ]);
    }
}

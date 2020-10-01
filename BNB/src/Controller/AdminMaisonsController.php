<?php

namespace App\Controller;

use App\Entity\Maisons;
use App\Form\MaisonType;
use App\Repository\MaisonsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

function convertirImage($image, $largeur, $hauteur, $chemin){ // fonction pour le traitement des images

    // récupérer la taille de l'image
    $tailleImage = getimagesize($image);
    $largeurImage = $tailleImage[0];
    $hauteurImage = $tailleImage[1];

    // calculer le ratio largeur / hauteur
    $ratio = $largeurImage / $hauteurImage;
    $source = imagecreatefromjpeg($image);

    if($ratio > 1){
        // redimensionner
        $nouvelleLargeur = $largeurImage / $ratio;
        $img = imagecrop($source, [
            'x' => '25%',
            'y' => 0,
            'width' => $nouvelleLargeur,
            'height' => $hauteurImage
        ]);
    }
    else{
        $img = $image;
    }

    // création du nouveau fichier
    $imageFinale = imagecreate($largeur, $hauteur); // on donne la taille de l'image voulue
    $final = imagecopyresized($imageFinale, $img, 0, 0, 0, 0, $largeur, $hauteur, $tailleImage[0], $tailleImage[1]); // copier et redimensionner img
    imagejpeg($img, $chemin);

}

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

        // récupèrer les informations de l'img
        $img1 = $form['img1']->getData();

        if($form->isSubmitted()){
            
            if($form->isValid()){

                $nomImg1 = md5(uniqid()); // nom unique
                $extensionImg1 = $img1->guessExtension(); // récupérer l'extension de l'img
                $newNomImg1 = $nomImg1.'.'.$extensionImg1; // recomposer un nom d'img

                try{ // on tente d'importer l'image
                    $chemin = $this->getParameter('dossier_photos_maisons').'/'.$newNomImg1;
                    convertirImage($img1, 500, 500, $chemin);
                    // $img1->move(
                    //     $this->getParameter('dossier_photos_maisons'),
                    //     $newNomImg1
                    // );
                }
                catch(FileException $e){
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation de l\'image'
                    );
                }

                $maison->setImg1($newNomImg1); // nom pour la base de données

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($maison);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La maison a bien été ajoutée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }

            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/adminMaisonsForm.html.twig', [
            'formulaireMaison' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/maisons/update-{id}", name="maison_update")
     */
    public function updateMaison(MaisonsRepository $maisonsRepository, $id, Request $request)
    {
        $maison = $maisonsRepository->find($id);

        // récupérer nom et chemin img1
        $oldNomImg1 = $maison->getImg1();
        $oldCheminImg1 = $this->getParameter('dossier_photos_maisons').'/'.$oldNomImg1;

        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        $img1 = $form['img1']->getData();

        if($form->isSubmitted() && $form->isValid()){

            // supprimer ancienne img1
            if($oldNomImg1 != null){
                unlink($oldCheminImg1);
            }

            $nomImg1 = md5(uniqid()); // nom unique
            $extensionImg1 = $img1->guessExtension(); // récupérer l'extension de l'img
            $newNomImg1 = $nomImg1.'.'.$extensionImg1; // recomposer un nom d'img

            try{ // on tente d'importer l'image
                $chemin = $this->getParameter('dossier_photos_maisons').'/'.$newNomImg1;
                convertirImage($img1, 500, 500, $chemin);
                // $img1->move(
                //     $this->getParameter('dossier_photos_maisons'),
                //     $newNomImg1
                // );
            }
            catch(FileException $e){
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'importation de l\'image'
                );
            }

            // donner un nom pour la bdd
            $maison->setImg1($newNomImg1);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($maison);
            $manager->flush();
            $this->addFlash(
                'success',
                'La maison a bien été modifiée'
            );
            return $this->redirectToRoute('admin_maisons');
        }

        return $this->render('admin/adminMaisonsForm.html.twig', [
            'formulaireMaison' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/maisons/delete-{id}", name="maison_delete")
     */
    public function deleteMaison(MaisonsRepository $maisonsRepository, $id)
    {
        $maison = $maisonsRepository->find($id);

        // récupérer le nom et le chemin de l'image à supprimer
        $nomImg1 = $maison->getImg1();
        $cheminImg1 = $this->getParameter('dossier_photos_maisons').'/'.$nomImg1;

        // supprimer img1
        if($nomImg1 != null){
            unlink($cheminImg1);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($maison);
        $manager->flush();

        $this->addFlash(
            'success',
            'La maison a bien été supprimée'
        );

        return $this->redirectToRoute('admin_maisons');
    }
}
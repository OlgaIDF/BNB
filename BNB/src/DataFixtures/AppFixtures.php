<?php

namespace App\DataFixtures;

use App\Entity\Maisons;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //$maison = new Maisons();
       // $maison->setTitre('Maison de campagne');
        //$maison->setDescription('Maison de charme en bordure de rivière');
       // $maison->setChambres('4');
        //$maison->setPrix('79');
        //$maison->setNote('4');
        //$maison->setSuperficie('120');
        //$maison->setImg1('maison1-1.png');
        //$maison->setImg2('maison1-2.png');
        //$maison->setImg3('maison1-3.png');

        for($i =1; $i<=10; $i++){
        $maison = new Maisons();

        $maison->setTitre('Maison N '.$i);
        $maison->setDescription('Description de la maison N '.$i);
        $maison->setChambres(random_int(1,6));
        $maison->setPrix(random_int(29,99));
        
        $maison->setSuperficie(random_int(29,149));
        $maison->setImg1('maison'.$i.'-1.png');
        $maison->setImg2('maison'.$i.'-2.png');
        $maison->setImg3('maison'.$i.'-3.png');
        

        $manager->persist($maison);
        $manager->flush();
    }
    }
}

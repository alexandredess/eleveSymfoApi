<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Eleve;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void


    
        
   

    {
        //Todo : implement load() method
        for($i=0;$i<10;$i++){
            $user = (new User())
            ->setEmail("user".$i."@domain.fr")
            ->setPassword("0000");

        $manager->persist($user);
        }


        
        $listNote=[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        // Création d'une vingtaine d'élèves'ayant pour nom
for ($i = 0; $i < 20; $i++) {
    $livre = new Eleve;
    $livre->setNom('Nom'. $i);
    $livre->setPrenom('Prenom:'. $i);
    $livre->setNote($listNote[array_rand($listNote)]);
    $livre->setCitation('Citation'.$i);
    $manager->persist($livre);
    }
        $manager->flush();
    }
}

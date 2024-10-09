<?php

namespace App\DataFixtures;

use App\Entity\Arrangement;
use App\Entity\Ergonomy;
use App\Entity\Hall;
use App\Entity\Material;
use App\Entity\Software;
use App\Entity\FrontUser;
use App\Entity\BackUser;
use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  
  public function load(ObjectManager $manager): void
    {

        $backuser= new BackUser;
        $backuser->setEmail('admin@gmail.com');
        $backuser->setPassword('$2y$13$DbkAtOoymFAfQrMA6H87IOK0ZjKuYuoSxXKmFEs6nqiVTp3tHEgja');
        $backuser->setRoles(['ROLE_BACK_ADMIN']);
        $manager->persist($backuser);

        $frontuser1= new FrontUser;
        $frontuser1->setLastname('Basara');
        $frontuser1->setFirstname('Dolma');
        $frontuser1->setEmail('dolma@gmail.com');
        $frontuser1->setPassword('$2y$13$u11Om0y3a.rvHgW2P.34d.W2rM5zGc8MRUoAuD9hONrkb5B.ugoRW');
        $frontuser1->setRoles(['ROLE_USER']);
        $manager->persist($frontuser1);

        $frontuser2= new FrontUser;
        $frontuser2->setLastname('Tenzin');
        $frontuser2->setFirstname('yega');
        $frontuser2->setEmail('yega@gmail.com');
        $frontuser2->setPassword('$2y$13$Ll8jA4Tp9RkMLJN2reSS1uCIolWRtx3YvPBXZiE389kGqceok5iYO');
        $frontuser2->setRoles(['ROLE_USER']);
        $manager->persist($frontuser2);


        $ergonomy1 = new Ergonomy();
        $ergonomy1->setName('Lumiere du jour');
        $manager->persist($ergonomy1);

        $ergonomy2 = new Ergonomy();
        $ergonomy2->setName('Lumiere artificiel');
        $manager->persist($ergonomy2);
        
        $ergonomy3 = new Ergonomy();
        $ergonomy3->setName('Accés PMR');
        $manager->persist($ergonomy3);

        $ergonomys=[
          $ergonomy1,
          $ergonomy2,
          $ergonomy3,
        ];

        $material1= new Material();
        $material1->setName('Telephone');
        $manager->persist($material1);
        
        $material2= new Material();
        $material2->setName('Ordinateur');
        $manager->persist($material2);
        
        $material3= new Material();
        $material3->setName('Projecteur');
        $manager->persist($material3); 
        
        $material4= new Material();
        $material4->setName('Tableau a roulette');
        $manager->persist($material4);
        
        $material5= new Material();
        $material5->setName('Table');
        $manager->persist($material5); 
        
        $material6= new Material();
        $material6->setName('Chaise');
        $manager->persist($material6);
        
        $material7= new Material();
        $material7->setName('Pouf');
        $manager->persist($material7);   

        $materials= [
          $material1,
          $material2,
          $material3,
          $material4,
          $material5,
          $material6,
          $material7
        ];


        $arrangement1= new Arrangement();
        $arrangement1->setName('U');
        $manager->persist($arrangement1);
        
        $arrangement2= new Arrangement();
        $arrangement2->setName('L');
        $manager->persist($arrangement2);
        
        $arrangement3= new Arrangement();
        $arrangement3->setName('W');
        $manager->persist($arrangement3);

        $arrangements= [
          $arrangement1,
          $arrangement2,
          $arrangement3,
        ];

        $software1= new Software();
        $software1->setName('MS Word');
        $manager->persist($software1);
        
        $software2= new Software();
        $software2->setName('Zoom');
        $manager->persist($software2);
        
        $software3= new Software();
        $software3->setName('MS Powerpoint');
        $manager->persist($software3);

        $softwares= [
          $software1,
          $software2,
          $software3,
        ];

        $ergonomyKey= array_rand($ergonomys);
        $ergonomy=$ergonomys[$ergonomyKey];

        $materialKey= array_rand($materials);
        $material=$materials[$materialKey];

        $arrangementKey= array_rand($arrangements);
        $arrangement=$arrangements[$arrangementKey];

        $softwareKey= array_rand($softwares);
        $software=$softwares[$softwareKey];


        $hall= new Hall();
        $hall->setName('Meeting Point');
        $hall->setLocation('Sartrouville');
        $hall->setCapacity('110');
        $hall->addErgonomy($ergonomy);
        $hall->addMaterial($material);
        $hall->addSoftware($software);
        $hall->setArrangement($arrangement);
        $manager->persist($hall);

        $reservation= new Reservation();
        $reservation->setStartdate( new DateTime('01/01/2022'));
        $reservation->setEnddate(new DateTime('01/01/2022'));
        $reservation->setStatus(Reservation::STATUS_VALIDER);
        $reservation->setHall($hall);
        $reservation->setFrontUser($frontuser1);
        $manager->persist($reservation);


        $ergonomyKey= array_rand($ergonomys);
        $ergonomy=$ergonomys[$ergonomyKey];

        $materialKey= array_rand($materials);
        $material=$materials[$materialKey];

        $arrangementKey= array_rand($arrangements);
        $arrangement=$arrangements[$arrangementKey];

        $softwareKey= array_rand($softwares);
        $software=$softwares[$softwareKey];

        $hall= new Hall();
        $hall->setName('Welcome Hall');
        $hall->setLocation('Paris 15');
        $hall->setCapacity('150');
        $hall->addErgonomy($ergonomy);
        $hall->addMaterial($material);
        $hall->addSoftware($software);
        $hall->setArrangement($arrangement);
        $manager->persist($hall);

        $reservation= new Reservation();
        $reservation->setStartdate( new DateTime('12/19/2021'));
        $reservation->setEnddate(new DateTime('12/19/2021'));
        $reservation->setStatus(Reservation::STATUS_PENDING);
        $reservation->setHall($hall);
        $reservation->setFrontUser($frontuser2);
        $manager->persist($reservation);


        $ergonomyKey= array_rand($ergonomys);
        $ergonomy=$ergonomys[$ergonomyKey];
        $hall= new Hall();
        $hall->setName('Business Hall');
        $hall->setLocation('Paris 10');
        $hall->setCapacity('110');
        $hall->addErgonomy($ergonomy);
        $hall->addMaterial($material);
        $hall->addSoftware($software);
        $hall->setArrangement($arrangement);
        $manager->persist($hall);

       
        $reservation= new Reservation();
        $reservation->setStartdate( new DateTime('01/01/2021'));
        $reservation->setEnddate(new DateTime('02/01/2021'));
        $reservation->setStatus(Reservation::STATUS_PENDING);
        $reservation->setHall($hall);
        $reservation->setFrontUser($frontuser1);
        $manager->persist($reservation);
        

        $reservation= new Reservation();
        $reservation->setStartdate( new DateTime('12/20/2021'));
        $reservation->setEnddate(new DateTime('12/20/2021'));
        $reservation->setStatus(Reservation::STATUS_ANNULER);
        $reservation->setHall($hall);
        $reservation->setFrontUser($frontuser2);
        $manager->persist($reservation);


        $ergonomyKey= array_rand($ergonomys);
        $ergonomy=$ergonomys[$ergonomyKey];

        $materialKey= array_rand($materials);
        $material=$materials[$materialKey];

        $arrangementKey= array_rand($arrangements);
        $arrangement=$arrangements[$arrangementKey];

        $softwareKey= array_rand($softwares);
        $software=$softwares[$softwareKey];

        $hall= new Hall();
        $hall->setName('Hall Point');
        $hall->setLocation('Marly Roi');
        $hall->setCapacity('90');
        $hall->addErgonomy($ergonomy);
        $hall->addMaterial($material);
        $hall->addSoftware($software);
        $hall->setArrangement($arrangement);
        $manager->persist($hall);

        $ergonomyKey= array_rand($ergonomys);
        $ergonomy=$ergonomys[$ergonomyKey];

        $materialKey= array_rand($materials);
        $material=$materials[$materialKey];

        $arrangementKey= array_rand($arrangements);
        $arrangement=$arrangements[$arrangementKey];

        $softwareKey= array_rand($softwares);
        $software=$softwares[$softwareKey];
        $hall= new Hall();
        $hall->setName('Some Point');
        $hall->setLocation('Nanterre');
        $hall->setCapacity('550');
        $hall->addErgonomy($ergonomy);
        $hall->addMaterial($material);
        $hall->addSoftware($software);
        $hall->setArrangement($arrangement);
        $manager->persist($hall);

        $manager->flush();
    }
}
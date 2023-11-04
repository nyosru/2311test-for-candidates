<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Nalogi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);




        $new_nalog = [
            ['Германия', 19, 'DE', '{.*}'],
            ['Италия', 22, 'IT', '{.*}'],
            ['Греция', 24, 'GE', '{.*}'],
            ['Франция', 20, 'FR', '{.*}']
        ];
        foreach ($new_nalog as $k) {
            $entity = new Nalogi();
            $entity->setCountry($k[0]);
            $entity->setProcent($k[1]);
            $entity->setCoKey($k[2]);
            $entity->setFilter($k[3]);
            $manager->persist($entity);
//            dd($entity);
            $manager->flush();
        }
//        $manager->flush();




        for ($e = 1; $e <= 10; $e++) {
            $entity = new Coupon();
            $entity->setKod('a' . $e);

            if (rand(1, 2) == 1) {
                $entity->setSkFix(rand(100, 5000));
            } else {
                $entity->setSkProc(rand(10, 50));
            }
            $manager->persist($entity);
            $manager->flush();
        }



    }
}

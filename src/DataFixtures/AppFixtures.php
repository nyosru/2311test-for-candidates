<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($e = 1; $e <= 10; $e++) {
            $entity = new Coupon();
            $entity->setKod('a' . $e);

            if (rand(1, 2) == 1) {
                $entity->setSkFix(rand(100, 5000));
            } else {
                $entity->setSkProc(rand(10, 50));
            }
            $manager->persist($entity);
        }

        $manager->flush();
    }
}

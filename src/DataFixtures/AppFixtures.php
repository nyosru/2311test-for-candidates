<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Nalogi;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->fixNalog($manager);
        $this->fixCupon($manager);
        $this->fixProduct($manager);

    }

    /**
     * Добавляем продукты
     * @param ObjectManager $manager
     * @return void
     */
    function fixProduct(ObjectManager $manager): void
    {
        for ($e = 1; $e <= 10; $e++) {
            $entity = new Product();
            $entity->setName('product' . $e);
            $entity->setPrice(rand(10, 5000));
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    function fixNalog(ObjectManager $manager): void
    {
        //DE XXX XXX XXX - для жителей Германии,
        //IT XXX XXX XXX XX - для жителей Италии,
        //GR XXX XXX XXX - для жителей Греции,
        //FR YY XXX XXX XXX - для жителей Франции
        $new_nalog = [
            ['Германия', 19, 'DE', '^([a-zA-Z]{2})(\d{9})$'],
            ['Италия', 22, 'IT', '^([a-zA-Z]{2})(\d{11})$'],
            ['Греция', 24, 'GE', '^([a-zA-Z]{2})(\d{9})$'],
            ['Франция', 20, 'FR', '^([a-zA-Z]{4})(\d{9})$']
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

    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    function fixCupon(ObjectManager $manager): void
    {

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

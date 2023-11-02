<?php

namespace App\Controller;

use App\Entity\PriceCalculate;
use Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class PriceCalculatorController extends AbstractController
{
    #[Route('/price/calculator', name: 'app_price_calculator')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceCalculatorController.php',
        ]);
    }

    #[Route('/calculate-price', methods: ['POST'])]
    public function priceCals( Request $request , ValidatorInterface $validator, EntityManagerInterface $entityManager ): JsonResponse
    {
        // Создайте объект YourEntity и установите значения полей
        $yourEntity = new PriceCalculate();
        $yourEntity->setProduct( $request->query->get('product'));
        $yourEntity->setTaxNumber($request->query->get('taxNumber'));
        $yourEntity->setCouponCode($request->query->get('couponCode'));

        // Выполните валидацию объекта
        $errors = $validator->validate($yourEntity);

        if (count($errors) > 0) {
            // Возвращайте ошибки в случае неверных данных
            return $this->json(['errors' => (string) $errors], 500);
        }

//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager = $yourEntity->getDoctrine()->getManager();

        $entityManager->persist($yourEntity); // Помечаем сущность как "готовую к сохранению"
        $entityManager->flush(); // Сохраняем сущность в базу данных




        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceCalculatorController.php',
        ]);
    }
}

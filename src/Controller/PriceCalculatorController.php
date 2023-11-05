<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\PriceCalculate;
use App\Entity\Product;
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
    public function priceCals(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {

        // тащим продукт
        $product = $entityManager->getRepository(Product::class)->find($request->query->get('product'));
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $request->query->get('product'));

        // тащим купон если есть
        if ($request->query->get('couponCode')) {
            $coupon = $entityManager->getRepository(Coupon::class)->findOneBy(['kod' => $request->query->get('couponCode')]);
            if (!$coupon)
                throw $this->createNotFoundException('No cupon found');
        }
        // создаём обькект заказа и валидируем остальное

        // Создайте объект YourEntity и установите значения полей
        $yourEntity = new PriceCalculate();
        $yourEntity->setProduct($product);
        $yourEntity->setTaxNumber($request->query->get('taxNumber'));
//        $yourEntity->setCouponCode($request->query->get('couponCode'));
        if (!empty($coupon))
            $yourEntity->setCupon($coupon);

        // Выполните валидацию объекта
        $errors = $validator->validate($yourEntity);

        if (count($errors) > 0) {
            // Возвращайте ошибки в случае неверных данных
            return $this->json(['errors' => (string)$errors], 500);
        }

        $entityManager->persist($yourEntity); // Помечаем сущность как "готовую к сохранению"
        $entityManager->flush(); // Сохраняем сущность в базу данных
        // созданная моделька
        //dd($yourEntity);

        $res = $this->orderCalculatePrice($yourEntity);

        return $this->json([
            'res' => $res,
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceCalculatorController.php',
        ]);

    }

    function orderCalculatePrice(PriceCalculate $order): JsonResponse
    {


        dd([1, $order->coupon]);
        dd([1, $order]);

    }

}

<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Nalogi;
use App\Entity\PriceCalculate;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PriceCalculatorController extends AbstractController
{
    #[Route('/', name: 'a')]
    public function index2(): Response
    {
        return $this->render('index.html.twig', [
//            'articles' => $articles
        ]);
//        return $this->renderView('');
    }

    #[Route('/price/calculator', name: 'app_price_calculator')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceCalculatorController.php',
        ]);
    }

    #[Route('/calculate-price', methods: ['POST'])]
    public function priceCalc(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager, $returnType = 'json'): JsonResponse|Array
    {

        try {

            // тащим продукт
            $product = $entityManager->getRepository(Product::class)->find($request->query->get('product'));
            if (!$product)
                throw $this->createNotFoundException('No product found for id ' . $request->query->get('product'));

            // создаём обькект заказа и валидируем остальное

            // Создайте объект YourEntity и установите значения полей
            $yourEntity = new PriceCalculate();
            $yourEntity->setProduct($product);
            $yourEntity->setTaxNumber($request->query->get('taxNumber'));

            // тащим купон если есть
            if ($request->query->get('couponCode')) {

                $coupon = $entityManager->getRepository(Coupon::class)->findOneBy(['kod' => $request->query->get('couponCode')]);
                if (!$coupon)
                    throw $this->createNotFoundException('No cupon found');

                $yourEntity->setCupon($coupon);

            }

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

            $res = $this->orderCalculatePrice($yourEntity, $entityManager);

            if ($returnType == 'json') {
                return $this->json([
                    'price' => $res,
                    'product' => $yourEntity->getProduct()->getName()
                ]);
            } else {
                return [
                    'price' => $res,
                    'product' => $yourEntity->getProduct()->getName()
                ];
            }

        } catch (\Exception $ex) {
            return $this->json([
                'error' => $ex->getMessage()
            ], 400);
        }
    }


    /**
     * использовать для проведения платежа PaypalPaymentProcessor::pay() или StripePaymentProcessor::processPayment()
     * Эти классы представлены в этом проекте, использовать следует именно их. В методах оплаты они принимают цену как в разных юнитах (как в центах, так и в долларах).
     *
     * ИЛИ скопируйте их себе в проект. Для простоты представьте, что эти два класса входят в два разных сторонних SDK, и у вас нет возможности править эти классы или какую-либо логику внутри них.
     * ИЛИ добавьте systemeio/test-for-candidates как зависимость через Composer.
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {

        try {

            // считаем цену заказа
            $order = $this->priceCalc($request, $validator, $entityManager, 'array');

            // покупаем
            $gogo = new PaypalPaymentProcessor();
            $gogo->pay($order['price']);

            return $this->json([
                'e' => $e
//                'price' => $res,
//                'product' => $yourEntity->getProduct()->getName()
            ]);

        } catch (\Exception $ex) {
            return $this->json([
                'error' => $ex->getMessage()
            ], 400);
        }

    }


    /**
     * // В итоге для покупателя Iphone из Греции
     * // цена составляет 124 евро (цена продукта 100 евро + налог 24%).
     * // Если у покупателя есть купон на 6% скидку на покупку,
     * // то цена будет 116.56 евро
     * // (цена продукта 100 евро - 6% скидка + налог 24%).
     * @param PriceCalculate $yourEntity
     * @param EntityManagerInterface $entityManager
     * @return float
     */
    function orderCalculatePrice(PriceCalculate $yourEntity, EntityManagerInterface $entityManager): float
    {

        $price_blank =
            (
                // цена
                $yourEntity->getProduct()->getPrice() -
                // минус фикс скидка если есть
                ($yourEntity->getCupon()->getSkFix() > 0 ? $yourEntity->getCupon()->getSkFix() : 0) -
                // минус скидка в проценте от цены если есть
                ($yourEntity->getCupon()->getSkProc() ? ($yourEntity->getProduct()->getPrice() / 100 * $yourEntity->getCupon()->getSkFix()) : 0)
            );

        $nalog = $this->orderNalogCalc($yourEntity, $entityManager);

        // + налог
        $price = $price_blank / 100 * $nalog;

        return round($price, 2);

    }


    /**
     * тащим какой налог в текущем заказе
     * //Формат налогового номера
     * //DEXXXXXXXXX - для жителей Германии,
     * //ITXXXXXXXXXXX - для жителей Италии,
     * //GRXXXXXXXXX - для жителей Греции,
     * //FRYYXXXXXXXXX - для жителей Франции
     * //
     * //где:
     * //первые два символа - это код страны,
     * //X - любая цифра от 0 до 9,
     * //Y - любая буква
     * //
     * //Обратите внимание, что длина налогового номера разная для разных стран.
     * //Форматы налоговых номеров могут меняться, что случается редко. (Это зависит от законодательства.)
     * @param $orderEntity
     * @return void
     */
    public function orderNalogCalc(PriceCalculate $entity, EntityManagerInterface $entityManager): ?int
    {

        $key_for_search = strtoupper(substr($entity->getTaxNumber(), 0, 2));
        $nalog = $entityManager->getRepository(Nalogi::class)->findOneBy(['co_key' => $key_for_search]);

        if (!$nalog)
            throw $this->createNotFoundException('No $nalog found');

        // не найден по шаблону
        if (!preg_match('/' . $nalog->getFilter() . '/m', $entity->getTaxNumber())) {
            throw $this->createNotFoundException('No $nalog found');
        }

        return $nalog->getProcent();

    }


}

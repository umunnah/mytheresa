<?php

namespace App\Controller\Api\V1;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products',name: 'list-products',methods: 'GET')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Product::class);
        $result =  $repository->getAll($request->query->all());

        $products = [];
        foreach ($result as $product) {
            $data = [];
            $price =  $product->getPrice();
            $sku =  $product->getSku();
            $category = $product->getCategory()->getName();
            $discountPercentage = null;
            $discount = false;
            $skuDiscount = 0;
            $categoryDiscount = 0;
            $finalPrice =  $price;
            if ($category == "boots") {
                $discount = true;
                $categoryDiscount = 30;
            }
            if ($sku == "000003") {
                $discount = true;
                $skuDiscount = 15;
            }
            if($discount) {
                $max = max($skuDiscount,$categoryDiscount);
                $finalPrice = $price - (($max/100) * $price);
                $discountPercentage = "$max%";
            }

            $data['sku'] = $sku;
            $data['name'] = $product->getName();
            $data['category'] = $category;
            $data['price'] = [
                'original' => $price,
                'final' => $finalPrice,
                'discount_percentage' => $discountPercentage,
                'currency' => "EUR",
            ];
            array_push($products,$data);
        }
        return $this->json($products,200);
    }

}
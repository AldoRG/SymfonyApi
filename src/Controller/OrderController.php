<?php

namespace App\Controller;

use App\Entity\Order;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractFOSRestController
{
    /**
     * @Route("/order", name="order")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    public function getOrders()
    {
        $repository = $this->getDoctrine()->getRepository(Order::class);
    }
}

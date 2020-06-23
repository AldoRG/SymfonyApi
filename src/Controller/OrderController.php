<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Pizza;
use App\Entity\Topping;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class OrderController extends AbstractFOSRestController
{
    /**
     *
     * @Rest\Get("/test")
     *
     * @return Response
     */
    public function test()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    /**
     * Lists all Orders.
     * @Rest\Get("/orders")
     *
     * @return Response
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Order::class);
        $orders = $repository->findall();
        return $this->handleView($this->view($orders));
    }

    /**
     * @Rest\Post("/orders")
     */
    public function create(Request $request)
    {
        $order = new Order();
        $order->setOrderNumber('order-'.rand(1, 500000));
        $subtotal = 0;
        $pizzaRepository = $this->getDoctrine()->getRepository(Pizza::class);
        foreach ($request->get('pizzas') as $piz) {
            $pizza = $pizzaRepository->findOneBy(['name' => $piz]);
            $order->addPizza($pizza);
            $subtotal += $pizza->getPrice();
        }
        $toppingRepository = $this->getDoctrine()->getRepository(Topping::class);
        if (count($request->get('toppings')) > 0) {
            $notes = 'Add extra toppings:';
            foreach ($request->get('toppings') as $top) {
                $topping = $toppingRepository->findOneBy(['name' => $top]);
                $notes .= ' '.$top;
                $subtotal += $topping->getExtraPrice();
            }
            $order->setNotes($notes);
        }
        $order->setSubtotal($subtotal);
        // if taxes
        $order->setTotal($subtotal*1.16);
        $order->setStatus(Order::STATUSES['ordered']);

        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($order);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Order Created'
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Rest\Get("/orders/{id}")
     */
    public function show(Order $order)
    {
        $details = [];
        $status = array_flip(Order::STATUSES);
        try {
            $details['total'] = $order->getTotal();
            $details['status'] = $status[$order->getStatus()];
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => $details
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Rest\Put("/orders/{id}")
     */
    public function update(Order $order, Request $request)
    {
        try {
            $order->setStatus(Order::STATUSES[$request->get('status')]);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Order Status Updated'
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Rest\Delete("/orders/{id}")
     */
    public function delete(Order $order)
    {
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($order);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Order Status Updated'
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\Topping;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class PizzaController extends AbstractFOSRestController
{
    /**
     * Lists all Pizzas.
     * @Rest\Get("/pizzas")
     *
     * @return Response
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Pizza::class);
        $pizzas = $repository->findall();
        return $this->handleView($this->view($pizzas));
    }

    /**
     * @Rest\Post("/pizzas")
     */
    public function create(Request $request)
    {
        $pizza = new Pizza();
        $pizza->setName($request->get('name'));
        $pizza->setPrice($request->get('price'));

        $toppingRepository = $this->getDoctrine()->getRepository(Topping::class);
        foreach ($request->get('toppings') as $top) {
            $topping = $toppingRepository->findOneBy(['name' => $top]);
            $pizza->addTopping($topping);
        }

        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($pizza);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Pizza Created'
        ]);
    }
}

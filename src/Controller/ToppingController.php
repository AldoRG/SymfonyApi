<?php

namespace App\Controller;

use App\Entity\Topping;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ToppingController extends AbstractFOSRestController
{
    /**
     * Lists all Toppings.
     * @Rest\Get("/toppings")
     *
     * @return Response
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Topping::class);
        $toppings = $repository->findall();
        return $this->handleView($this->view($toppings));
    }

    /**
     * @Rest\Post("/toppings")
     */
    public function create(Request $request)
    {
        $topping = new Topping();
        $topping->setName($request->get('name'));
        $topping->setExtraPrice(2.00);

        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($topping);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 'error',
                'message' => 'Something went wrong '.$exception->getMessage()
            ]);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Topping Created'
        ]);
    }
}

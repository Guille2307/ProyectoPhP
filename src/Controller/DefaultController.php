<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route("/apartment")]
    public function getApartment()
    {
        $apartment = [
            "name" => "Piso Calle Oporto, Vigo.",
            "address" => "Calle Oporto, Vigo. Pontevedra.",
            "description" => "Piso de 3 habitaciones y dos Baños 105 mt2.",
            "price" => "850,00 €",
            "image" => "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1080&q=80"
        ];
        return $this->render("apartment/showapartment.html.twig", ['apartment' => $apartment]);
    }


    #[Route("/apartments")]
    public function getApartments()
    {
        $apartments = [
            [
                "name" => "Piso Calle Oporto, Vigo.",
                "address" => "Calle Oporto Numero 1 5to Derecha, Vigo. Pontevedra.",
                "description" => "Piso de 3 habitaciones y dos Baños 105 mt2.",
                "price" => "850,00 €",
                "image" => "https://images.unsplash.com/photo-1597047084897-51e81819a499?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80"
            ],
            [
                "name" => "Casa Calle Gran vía, Vigo.",
                "address" => "Calle Gran vía, Vigo.",
                "description" => "Casa de 3 habitaciones y dos Baños 280 mt2.",
                "price" => "2800,00 €",
                "image" => "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1475&q=80"
            ],
            [
                "name" => "Piso Calle Placer, Vigo.",
                "address" => "Calle Placer, Vigo. Pontevedra.",
                "description" => "Piso de 3 habitaciones y dos Baños 150 mt2.",
                "price" => "950,00 €",
                "image" => "https://www.inmoserver.com/fotos/0487/wm/2072_o_1f381hfug13u09ib6l01fme6t1g.jpg"
            ]

        ];
        return $this->render("apartment/apartmentList.html.twig", ["apartments" => $apartments]);
    }

    #[Route("/home")]
    public function getHome()
    {
        return $this->render("home/home.html.twig");
    }
}

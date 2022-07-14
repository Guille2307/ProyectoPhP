<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    #[Route("/apartment/{id}", name: "showApartment")]
    public function getApartment($id, EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Apartment::class);
        $apartment = $repository->find($id);
        return $this->render("apartment/showapartment.html.twig", ['apartment' => $apartment]);
    }


    #[Route("/apartments", name: "getApartments")]
    public function getApartments(EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Apartment::class);
        $apartments = $repository->findAll();
        return $this->render("apartment/apartmentList.html.twig", ["apartments" => $apartments]);
    }

    #[Route("/home", name: "home")]
    public function getHome()
    {
        return $this->render("home/home.html.twig");
    }

    #[Route("/insert/apartment")]
    public function insertApartment(EntityManagerInterface $doctrine)
    {
        $apartment1 = new Apartment();
        $apartment1->setName("Piso Calle Oporto, Vigo.");
        $apartment1->setAddress("Calle Oporto Numero 1 5to Derecha, Vigo. Pontevedra.");
        $apartment1->setDescription("Piso de 3 habitaciones y dos Baños 105 mt2.");
        $apartment1->setPrice("850,00 €");
        $apartment1->setImage("https://images.unsplash.com/photo-1597047084897-51e81819a499?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80");

        $apartment2 = new Apartment();
        $apartment2->setName("Casa Calle Gran vía, Vigo.");
        $apartment2->setAddress("Calle Gran vía, Vigo.");
        $apartment2->setDescription("Casa de 5 habitaciones y 3 Baños 280 mt2.");
        $apartment2->setPrice("2800,00 €");
        $apartment2->setImage("https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1475&q=80");

        $apartment3 = new Apartment();
        $apartment3->setName("Piso Calle Placer, Vigo.");
        $apartment3->setAddress("Calle Placer, Vigo. Pontevedra.");
        $apartment3->setDescription("Piso de 3 habitaciones y dos Baños 150 mt2.");
        $apartment3->setPrice("950,00 €");
        $apartment3->setImage("https://www.inmoserver.com/fotos/0487/wm/2072_o_1f381hfug13u09ib6l01fme6t1g.jpg");

        $doctrine->persist($apartment1);
        $doctrine->persist($apartment2);
        $doctrine->persist($apartment3);
        $doctrine->flush();
        return new Response("Vivienda insertada correctamente");
    }
    #[Route("/new/apartment", name: "newApartment")]
    public function newApartment(Request $request, EntityManagerInterface $doctrine)
    {
        $form = $this->createForm(ApartmentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apartment = $form->getData();
            $doctrine->persist($apartment);
            $doctrine->flush();
            $this->addFlash("ok", "Vivienda insertada correctamente");
            return $this->redirectToRoute("getApartments");
        }
        return $this->renderForm('apartment/newApartment.html.twig', ["apartmentForm" => $form]);
    }

    #[Route("/edit/aparment/{id}", name: "editApartment")]
    #[IsGranted("ROLE_ADMIN")]
    public function editApartment(Request $request, EntityManagerInterface $doctrine, $id)
    {
        $repository = $doctrine->getRepository(Apartment::class);
        $apartment = $repository->find($id);
        $form = $this->createForm(ApartmentType::class, $apartment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $apartment = $form->getData();
            $doctrine->persist($apartment);
            $doctrine->flush();
            $this->addFlash("ok", "Vivienda insertada correctamente");
            return $this->redirectToRoute("getApartments");
        }
        return $this->renderForm('apartment/newApartment.html.twig', ["apartmentForm" => $form]);
    }
    #[Route("/remove/aparment/{id}", name: "removeApartment")]
    #[IsGranted("ROLE_ADMIN")]
    public function removeApartment($id, EntityManagerInterface $doctrine)
    {
        $repository = $doctrine->getRepository(Apartment::class);
        $apartment = $repository->find($id);

        $doctrine->remove($apartment);
        $doctrine->flush();

        $this->addFlash("ok", "Vivienda Eliminada correctamente");
        return $this->redirectToRoute("getApartments");
    }
}

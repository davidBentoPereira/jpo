<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    public function page()
    {
        return $this->render('admin/page.html.twig');
    }

    public function event()
    {
        $repository = $this->getDoctrine()->getRepository(Event::class);;
        $events = $repository->findAll();
        return $this->render('admin/event.html.twig',
            ["events" => $events]);
    }

    public function survey()
    {
        return $this->render('admin/survey.html.twig');
    }

    public function addEvent(Request $request)
    {
        $form = $this->createForm(EventType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('event');
        }

        return $this->render('admin/formEvent.html.twig',
            ['form' => $form->createView(),
                'type' => 'add']);
    }

    public function editEvent(Request $request)
    {
        $form = $this->createForm(EventType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('event');
        }

        return $this->render('admin/formEvent.html.twig',
            ['form' => $form->createView(),
                'type' => 'edit']);
    }

    public function deleteEvent()
    {
        return $this->render('admin/event.html.twig');
    }
}

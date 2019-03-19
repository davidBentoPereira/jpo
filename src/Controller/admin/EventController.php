<?php

namespace App\Controller\admin;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{

    public function event()
    {
        $repository = $this->getDoctrine()->getRepository(Event::class);
        $events = $repository->findAll();
        return $this->render('admin/event.html.twig',
            ["events" => $events]);
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

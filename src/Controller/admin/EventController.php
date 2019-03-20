<?php

namespace App\Controller\admin;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
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
            if($request->getMethod() == 'POST')
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();
                $title = $data['title'];
                $dateOfOpening = new \DateTimeImmutable('now');
                $dateOfClosure = $data['dateOfClosure'];
                $event = new Event($title, $dateOfOpening, $dateOfClosure);
                $event->setDescription($data['description']);
                $entityManager->persist($event);
                $entityManager->flush();
            }
            return $this->redirectToRoute('event');
        }

        return $this->render('admin/formEvent.html.twig',
            ['form' => $form->createView(),
                'type' => 'add']);
    }

    public function editEvent($id, Request $request, EventRepository $repository)
    {
        $event = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->getMethod() == 'POST') {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $form->getData();
                $event->setTitle( $data['title']);
                $event->setDateOfClosure($data['dateOfClosure']);
                $event->setDescription($data['description']);
                $entityManager->persist($event);
                $entityManager->flush();
            }
            return $this->redirectToRoute('event');
        }

        return $this->render('admin/formEvent.html.twig',
            ['form' => $form->createView(),
                'type' => 'edit',
                'event' => $event]);
    }

    public function deleteEvent()
    {
        return $this->render('admin/event.html.twig');
    }
}

<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QRCodeController extends AbstractController
{
    public function index(FiliereRepository $repo)
    {
        return $this->render('admin/qrcodes/list.html.twig', ['filieres' => $repo->findAll()]);
    }

    public function rendering(Request $request)
    {
        $protocol = $request->isSecure() ? "https" : "http";
        $fullUrl =
            $protocol
            ."://"
            .$request->getHost()
            .":".$request->getPort()
            .$request->query->get('url');

        return $this->render('admin/qrcodes/rendering.html.twig', [
            'url' => $fullUrl
        ]);
    }
}

<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class QRCodeController extends AbstractController
{
    public function index(FiliereRepository $repo)
    {
        return $this->render('admin/qrcodes/list.html.twig', ['filieres' => $repo->findAll()]);
    }

    public function rendering(Request $request)
    {
        $protocol = $request->isSecure() ? "https" : "http";
        $port = $request->getPort() != 8000 ? "" : ":".$request->getPort();
        $domain = $protocol."://".$request->getHost().$port;

        $fullUrl = $domain.$request->query->get('url');

        $qrCode = new QrCode($fullUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');

        return new QrCodeResponse($qrCode);

        // $fileSystem = new Filesystem();
        // $fileSystem->touch($domain.'/img/qrcode/test.png');
        // $fileSystem

        // $qrCode->writeFile($domain.'/img/qrcode/test.png');

        return $this->render('admin/qrcodes/rendering.html.twig', [
            'url' => $fullUrl
        ]);
    }
}

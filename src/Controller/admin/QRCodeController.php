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
use App\Service\SlugGeneratorService;

class QRCodeController extends AbstractController
{
    public function index(FiliereRepository $repo)
    {
        return $this->render('admin/qrcodes/list.html.twig', ['filieres' => $repo->findAll()]);
    }

    public function rendering(Request $request)
    {
        $protocol = $request->isSecure() ? "https" : "http";

        $host = $protocol.'://'.$_SERVER['HTTP_HOST'];

        $pageUrl = $host.$request->query->get('url');

        $qrCode = new QrCode($pageUrl);

        $fileType = 'png';

        $qrCode->setWriterByName($fileType);

        $qrCode->setSize(300);

        $qrCode->setMargin(10); 

        $qrCode->setEncoding('UTF-8');

        $fileName = new SlugGeneratorService($request->query->get('slug'));

        $filePath = '/img/qrcode/'.$fileName->getSlug().'.'.$fileType;

        $qrCode->writeFile(__DIR__.'/../../../public'.$filePath);

        return $this->render('admin/qrcodes/rendering.html.twig', [
            'pageUrl' => $pageUrl,
            'fileUrl' => $host.$filePath
        ]);
    }
}

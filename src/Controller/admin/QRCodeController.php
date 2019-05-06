<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use App\Repository\SurveyRepository;
use App\Repository\EventRepository;
use Endroid\QrCode\QrCode;
use App\Service\SlugGeneratorService;
use Dompdf\Dompdf;
use Dompdf\Options as DompdfOptions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class QRCodeContext {
    public $title;
    public $link;
    public $qrcode;
}

class QRCodeController extends AbstractController
{

    /* public function index(
        FiliereRepository $filiereRepo,
        EventRepository $eventRepo,
        SurveyRepository $surveyRepo
    )
    {
        $pdfOptions = new DompdfOptions();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('admin/qrcodes.html.twig', [
            'filieres' => $filiereRepo->findAll(),
            'events' => $eventRepo->findAll(),
            'surveys' => $surveyRepo->findAll()
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('a5', 'portrait');

        $dompdf->render();

        return new Response($dompdf->stream("qrcodes.pdf", [
            "Attachment" => false
        ]));
    }

    public function rendering(Request $request)
    {
        $protocol = $request->isSecure() ? "https" : "http";

        $host = $protocol.'://'.($_SERVER['HTTP_HOST'] == 'jpo' ? 'jpo/public' : $_SERVER['HTTP_HOST']);

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
    } */

    public function displaySingleQRCode(
        FiliereRepository $filiereRepo,
        Request $request,
        RequestStack $requestStack
    ){
        $pdfOptions = new DompdfOptions();
        $pdfOptions->set('defaultFont', 'Arial');

        $item = $request->query->get('item');
        $id = $request->query->get('id');
        $url = $request->query->get('url');

        $qrCodeContext = new QRCodeContext();

        $errorMessage = 'Erreur dans la génération du QRCode.';

        if(empty($item) || empty($id) || empty($url)) {
            $html = $errorMessage;
        }
        else{
            $basicUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
            switch ($item) {
                case 'filiere':
                    $filiere = $filiereRepo->find($id);

                    $qrCodeContext->title = $filiere->getTitle();
                    $qrCodeContext->link = $basicUrl.$url;
                    break;
            }

            $qrCode = new QrCode($qrCodeContext->link);
            $fileType = 'png';
            $qrCode->setWriterByName($fileType);
            $qrCode->setSize(300);
            $qrCode->setMargin(0);
            $qrCode->setEncoding('UTF-8');
            $qrCodeContext->qrcode = $qrCode;

            $html = $this->renderView('admin/qrcodes/single_qrcode.html.twig', [
                'qrCodeContext' => $qrCodeContext
            ]);
        }

        $dompdf = new Dompdf($pdfOptions);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A7', 'portrait');

        $dompdf->render();

        $qrCodeDocumentTitle = $qrCodeContext->title ? $qrCodeContext->title." - QR Code" : $errorMessage;

        return new Response($dompdf->stream($qrCodeDocumentTitle, [
            "Attachment" => false
        ]));
    }

}

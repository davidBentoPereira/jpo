<?php

namespace App\Controller\admin;

use App\Classes\QRCodeContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FiliereRepository;
use App\Repository\SurveyRepository;
use Endroid\QrCode\QrCode;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class QRCodeController extends AbstractController
{

    public function displaySingleQRCode(
        FiliereRepository $filiereRepo,
        SurveyRepository $surveyRepo,
        Request $request,
        RequestStack $requestStack
    ){
        $item = $request->query->get('item');
        $id = $request->query->get('id');
        $url = $request->query->get('url');

        if(empty($item) || empty($id) || empty($url)) {
            return new Response('Erreur dans la génération du QRCode.');
        }

        $qrCodeContext = new QRCodeContext();
        $basicUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $qrCodeContext->link = $basicUrl.$url;

        switch ($item) {
            case 'filiere':
                $filiere = $filiereRepo->find($id);
                $qrCodeContext->title = $filiere->getTitle();
                break;
            case 'survey':
                $survey = $surveyRepo->find($id);
                $qrCodeContext->title = $survey->getTitle();
                break;
            case 'homepage':
                $qrCodeContext->title = 'Page d\'accueil';
                break;
            default:
                return new Response('Erreur dans la génération du QRCode.');
        }

        $fileType = 'png';
        $fileName = $item.'-'.$id.'.'.$fileType;
        $filePath = '/img/qrcodes/'.$fileName;
        $fullFilePath = __DIR__.'/../../../public/'.$filePath;
        $qrCodeContext->qrcode = $fullFilePath;

        $qrCode = new QrCode($qrCodeContext->link);
        $qrCode->setWriterByName($fileType);
        $qrCode->setSize(655);
        $qrCode->setMargin(0);
        $qrCode->setEncoding('UTF-8');
        $qrCode->writeFile($fullFilePath);

        $html = $this->renderView('admin/qrcode_rendering.html.twig', [
            'qrCodeContext' => $qrCodeContext
        ]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $qrCodeDocumentTitle = $qrCodeContext->title." - QR Code";

        return new Response($dompdf->stream($qrCodeDocumentTitle, [
            "Attachment" => false
        ]));
    }

}

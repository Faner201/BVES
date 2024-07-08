<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataAcceptanceController extends AbstractController
{
    /**
     * @Route("/processing", name="app_processing", methods={"GET", "POST"})
     */
    public function processing(Request $request): Response
    {
        $data = json_decode($request->getContent());
        return new Response(
            '<html><body>Информация принята!</body></html>',
            Response::HTTP_OK
        );
    }
}
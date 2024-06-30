<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataAcceptanceController extends AbstractController
{
    /**
     * @Route("/processing", name="app_processing", methods={"GET"})
     */
    public function processing(Request $request): Response
    {
        $data = $request->getContentType();
        var_dump($data);
        return new Response(
            '<html><body>Информация принята</body></html>',
            Response::HTTP_OK
        );
    }
}
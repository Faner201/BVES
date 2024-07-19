<?php
namespace App\Controller;

use App\Producer\Producer;
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

//        $data = json_decode(json_decode($request->getContent()), true);
        $data = $request->getContent();
        $queue = 'task';

        $producer = new Producer();

        $producer->sending($data, $queue);
        $producer->closure();

        return new Response(
            '<html><body>Информация принята!</body></html>',
            Response::HTTP_OK
        );
    }

}
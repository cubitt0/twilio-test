<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class TwilioController extends AbstractController
{

    /**
     * @var Client
     */
    private $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * @Route(path="/")
     */
    public function index(Client $client): Response
    {
        return $this->render('twilio/index.html.twig');
    }

    /**
     * @Route(path="/call/{number}",methods={"GET"})
     */
    public function call(string $number):JsonResponse
    {
        $result = $this->twilio->calls->create($number,$this->getParameter('twilio.number.from'),[
            'url'=>''
        ]);
        dump($result);
        return new JsonResponse([
            'number'=>$number
        ]);
    }

    /**
     * @Route(path="callback/status")
     */
    public function statusCallback(Request $request)
    {
        dump($_REQUEST);
    }
}

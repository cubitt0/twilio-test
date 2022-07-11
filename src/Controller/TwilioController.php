<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route(path="/call/{number}",methods={"POST"})
     */
    public function call(string $number): JsonResponse
    {
        $result = $this->twilio->calls->create($number, $this->getParameter('twilio.number.from'), [
            'url'            => $this->getParameter('ngrok.domain') . '/twiml/call',
            'statusCallback' => $this->getParameter('ngrok.domain') . '/callback/status'
        ]);

        return new JsonResponse([
            'properties' => $result->toArray()
        ]);
    }

    /**
     * @Route(path="/endcall/{sid}")
     */
    public function end(string $sid)
    {
        $result = $this->twilio->calls($sid)->update([
            'twiml' => $this->renderView('twiml/hangup.xml.twig')
        ]);

        return new JsonResponse([
            'properties' => $result->toArray()
        ]);
    }

    /**
     * @Route(path="/music-start/{sid}")
     */
    public function startMusic(string $sid)
    {
        $result = $this->twilio->calls($sid)->update([
            'twiml' => $this->renderView('twiml/music.xml.twig')
        ]);
        return new JsonResponse([
            'properties' => $result->toArray()
        ]);
    }

    /**
     * @Route(path="callback/status")
     */
    public function statusCallback(LoggerInterface $logger)
    {
        $logger->critical(var_export($_REQUEST, true));
        return new Response('OK');
    }
}

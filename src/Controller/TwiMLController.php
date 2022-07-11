<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TwiMLController extends AbstractController
{
    /**
     * @Route(path="/twiml/{template}")
     */
    public function index(string $template)
    {
        $response = $this->render('twiml/' . $template . '.xml.twig');
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function list(): Response
    {
        $clubs = [ ["name" => "AIESEC", "inscriptionDate"=> "09/09/2022", "openSpots" => '50'], 
            ["name" => "ENACTUS", "inscriptionDate"=> "30/09/2022", "openSpots" => '0'],  
            ["name" => "AUTO CLUB", "inscriptionDate"=> "12/09/2022", "openSpots" => '30']       
        ];
        return $this->render('club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }
}

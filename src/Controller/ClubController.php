<?php

namespace App\Controller;

use App\Entity\Club;
use App\Repository\ClubRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function list(): Response
    {
        $clubs = [
            ["name" => "AIESEC", "inscriptionDate" => "09/09/2022", "openSpots" => '50'],
            ["name" => "ENACTUS", "inscriptionDate" => "30/09/2022", "openSpots" => '0'],
            ["name" => "AUTO CLUB", "inscriptionDate" => "12/09/2022", "openSpots" => '30']
        ];
        return $this->render('club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }

    #[Route('/listClub', name: 'listClub')]
    public function listClub(ManagerRegistry $doctrine): Response
    {

        $clubs = $doctrine->getRepository(Club::class)->findAll();
        return $this->render('club/listClub.html.twig', [
            'clubs' => $clubs
        ]);
    }

    #[Route('/listClub2', name: 'listClub2')]
    public function listClub2(ClubRepository $repo): Response
    {

        $clubs = $repo->findAll();
        return $this->render('club/listClub.html.twig', [
            'clubs' => $clubs
        ]);
    }

    #[Route('/show/{id}', name: "clubDetails")]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $club = $doctrine->getRepository(Club::class)->find($id);
        return $this->render('club/showClub.html.twig', [
            'club' => $club
        ]);
    }

    #[Route('/show1/{id}', name: "clubDetails1")]
    public function show1(ClubRepository $repo, $id): Response
    {
        $club = $repo->find($id);
        return $this->render('club/showClub.html.twig', [
            'club' => $club
        ]);
    }

    #[Route('/show2/{id}', name: "clubDetails2")]
    public function show2(Club $club): Response
    {

        return $this->render('club/showClub.html.twig', [
            'club' => $club
        ]);
    }

    #[Route('/delete/{id}', name: 'clubDelete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $club = $doctrine->getRepository(Club::class)->find($id);

        $entityManger = $doctrine->getManager();
        $entityManger->remove($club);
        $entityManger->flush();

        return new Response('Deleted');
    }
}

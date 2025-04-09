<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\JobOfferRepository;
use App\Repository\CompanyRepository;


final class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/joboffers', name: 'app_joboffers')]
    public function jobOffers(JobOfferRepository $jobOfferRepository): Response
    {
        // Récupérer toutes les offres d'emploi depuis la base de données
        $jobOffers = $jobOfferRepository->findAll();

        // Passer les offres d'emploi à la vue
        return $this->render('index/joboffers.html.twig', [
            'jobOffers' => $jobOffers,
        ]);
    }

    #[Route('/partners', name: 'app_partners')]
    public function partners(CompanyRepository $companyRepository): Response
    {
        $companies = $companyRepository->findAll();

        return $this->render('index/partners.html.twig', [
            'companies' => $companies,
        ]);
    }


}

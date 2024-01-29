<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UrlRepository;
use App\Repository\UrlStatisticRepository;
use App\Service\UrlService;
use App\Service\UrlStatisticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{

    private UrlService $urlService;


    public function __construct(UrlService $urlService){
       $this->urlService = $urlService;
    }
    /**
     * @Route("/url", name="app_url")
     */
    public function index(): Response
    {
        return $this->render('url/index.html.twig', [
            'controller_name' => 'UrlController',
        ]);
    }

 /**
     * @Route("/ajax/shorten", name="url_add")
     */
    public function add(Request $request): Response
    {
        $longUrl = $request->request->get('url');

        if (!$longUrl) {
            return  $this->json([
                'statusCode' => 400,
                'statusText' => 'MISSING_ARG_URL'
            ]);
        }

        $domain = $this->urlService->parseUrl($longUrl);

        if (!$domain) {
            return $this->json([
                'statusCode' => 500,
                'statusText' => 'INVALID_ARG_URL'
            ]);
        }

        $url = $this->urlService->addUrl($longUrl, $domain);

        return $this->json([
            'link' => $url->getLink(),
            'longUrl' => $url->getLongUrl()
        ]);
    }
 /**
     * @Route("/{hash}", name="url_view")
     */
    public function view(string $hash, UrlRepository $urlRepo): Response
    {
        $url = $urlRepo->findOneBy(['hash' => $hash]);

        if (!$url) {
            return $this->redirectToRoute('app_homepage');
        }

        
    
        return $this->redirect($url->getLongUrl());
    }
}

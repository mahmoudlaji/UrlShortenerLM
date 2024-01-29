<?php

namespace App\Service;

use App\Entity\Url;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UrlService {
    private EntityManagerInterface $em;

   public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
   }
   public function addUrl(string $longUrl): Url {
    $url = new Url();
    return $url;
   }
}
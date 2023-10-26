<?php
namespace AccueilController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author selsa
 */
class AccueilController {
  /**
   * @Route("/", name="accueil")
   * @return Response
   */  
  public function index(): Response {
      return new Response('Hello World!');
     }
    }

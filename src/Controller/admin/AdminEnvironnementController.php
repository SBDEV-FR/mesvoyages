<?php
namespace App\Controller\admin;

use App\Entity\Enivronnement; 
use App\Repository\EnivronnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminEnvironnementController
 *
 * @author selsa
 */

class AdminEnvironnementController extends AbstractController {
    
    private $repository;

    public function __construct(EnivronnementRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/environnements", name="admin.environnements")
     * @return Response
     */
    public function index(): Response {
        $environnements = $this->repository->findAll();
        return $this->render("admin/admin.environnements.html.twig", [
            'environnements' => $environnements
        ]);
    }

    /**
     * @Route("/admin/environnement/suppr/{id}", name="admin.environnement.suppr")
     * @param int $id
     * @return Response
     */
    public function suppr(int $id): Response {
        $environnement = $this->repository->find($id);

        if (!$environnement) {
            // Handle the case where the entity with the given ID is not found (e.g., show an error message).
            // You can redirect or return a response as needed.
        } else {
            $this->repository->remove($environnement, true);
        }

        return $this->redirectToRoute('admin.environnements');
    }

    
    /**
     * @Route("/admin/environnement/ajout", name="admin.environnement.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $nomEnvironnement = $request->get("nom");
        $environnement = new Enivronnement();
        $environnement->setNom($nomEnvironnement);
        $this->repository->add($environnement, true);
        return $this->redirectToRoute('admin.environnements');       
    }        
}

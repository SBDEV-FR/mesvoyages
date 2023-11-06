<?php
namespace App\Controller\admin;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminVoyagesController
 *
 * @author selsa
 */
class AdminVoyagesController extends AbstractController {

    /**
     * 
     * @var VisiteRepository
     */
    private $repository;

    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(EntityManagerInterface $entityManager, VisiteRepository $repository) {
    $this->entityManager = $entityManager;
    $this->repository = $repository;
}

    /**
     * @Route("/admin", name="admin.voyages")
     * @return Response
     */
    public function index(): Response{
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("admin/admin.voyages.html.twig", [
            'visites' => $visites
        ]);
    }

      /**
      * @Route("/admin/suppr/{id}", name="admin.voyage.suppr")
      * @param int $id
      * @return Response
      */
    public function suppr(int $id) : Response {
         $visite = $this->repository->find($id);
         $this->repository->remove($visite, true);
         return $this->redirectToRoute('admin.voyages');
     }
     
     /**
      * @Route("/admin/edit/{id}", name="admin.voyage.edit")
      * @param int $id
      * @return Response
      */
    public function edit(int $id, Request $request): Response {
    // Récupérez l'entité Visite depuis la base de données
    $visite = $this->repository->find($id);

    if (!$visite) {
        throw $this->createNotFoundException('Visite not found');
    }

    // Créez le formulaire en utilisant l'entité Visite
    $formVisite = $this->createForm(VisiteType::class, $visite);

    // Gérez la soumission du formulaire
    $formVisite->handleRequest($request);

    if ($formVisite->isSubmitted() && $formVisite->isValid()) {
        // L'entité Visite a été mise à jour par le formulaire
        // Vous n'avez pas besoin d'appeler $this->repository->add() ici

        // Enregistrez les changements en base de données
        $this->entityManager->flush();

        // Redirigez l'utilisateur vers une autre page ou renvoyez une réponse appropriée
        return $this->redirectToRoute('admin.voyages');
    }

    return $this->render("admin/admin.voyage.edit.html.twig", [
        'visite' => $visite,
        'formvisite' => $formVisite->createView()
    ]);
}
        /**
         * @Route("/admin/ajout", name="admin.voyage.ajout")
         * @param Request $request
         * @return Response
         */
        public function ajout (Request $request):Response {
           $visite = new Visite ();
           $formVisite = $this->createForm(VisiteType ::class, $visite);
           
           $formVisite->handleRequest($request);
           if($formVisite->isSubmitted()&& $formVisite->isValid()){
               $this->repository->add($visite, true); 
               return $this->redirectToRoute('admin.voyages');
           }
           return $this->render("admin/admin.voyage.ajout.html.twig", [
               'visite' => $visite,
               'formvisite' => $formVisite->createView()
           ]);
       }

}
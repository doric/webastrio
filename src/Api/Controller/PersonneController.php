<?php

namespace App\Api\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class PersonneController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/personne", name="post_personne", methods={"POST"})
     *
     * @OA\Post(
     *     path="/personne",
     *     summary="Créer une nouvelle personne",
     *     tags={"Personne"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(ref="#/components/schemas/PersonneCreateRequest")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="La personne a été créée avec succès",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Personne")
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="La date de naissance est invalide ou la personne a plus de 150 ans",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="La date de naissance est invalide ou la personne a plus de 150 ans")
     *         )
     *     )
     * )
     *
     * @throws \Exception
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $dateNaissance = $data['dateNaissance'] ?? null;

        if (!$nom || !$prenom || !$dateNaissance) {
            return new JsonResponse(['error' => 'Champs manquants'], Response::HTTP_BAD_REQUEST);
        }

        $dateNaissance = new \DateTime($dateNaissance);
        $now = new \DateTime();
        $age = $now->diff($dateNaissance)->y;

        if ($age >= 150) {
            return new JsonResponse(['error' => 'Age maximum dépassé'], Response::HTTP_BAD_REQUEST);
        }

        $personne = new Personne();
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $personne->setDateNaissance($dateNaissance);

        $this->entityManager->persist($personne);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true], Response::HTTP_CREATED);
    }

    /**
     * @Route("/personnes", name="api_get_all_personnes", methods={"GET"})
     *
     * @OA\Get(
     *     path="/persons",
     *     summary="Renvoie toutes les personnes enregistrées par ordre alphabétique, avec leur âge actuel.",
     *     operationId="getAllPersons",
     *     tags={"Personnes"},
     *
     *     @OA\Response(
     *         response="200",
     *         description="Liste de toutes les personnes enregistrées.",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Person")
     *         )
     *     ),
     *     security={
     *         {"BearerAuth": {}}
     *     }
     * )
     */
    public function getAll(PersonneRepository $personneRepository): JsonResponse
    {
        $personnes = $personneRepository->findAllOrderedByName();

        $data = [];
        foreach ($personnes as $personne) {
            $now = new \DateTime();
            $age = $now->diff($personne->getDateNaissance())->y;

            $data[] = [
                'id' => $personne->getId(),
                'nom' => $personne->getNom(),
                'prenom' => $personne->getPrenom(),
                'dateNaissance' => $personne->getDateNaissance()->format('Y-m-d'),
                'age' => $age,
            ];
        }

        return new JsonResponse($data);
    }
}

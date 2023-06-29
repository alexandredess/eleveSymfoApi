<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController
{
    #[Route('/api/eleves', name: 'app_eleve',methods:'GET')]
    public function index(EleveRepository $eleveRepository,SerializerInterface $serializer,): JsonResponse
    {
        $elevesList=$eleveRepository->findAll();
        $jsonEleveList = $serializer->serialize($elevesList, 'json');
        
        return new JsonResponse($jsonEleveList, Response::HTTP_OK,[], true);

    }

    #[Route('/api/eleve/{id}', name: 'app_detail_eleve', methods: ['GET'])]
    public function getDetailEleve(SerializerInterface $serializer,Eleve $eleve): JsonResponse {

        $jsonEleve = $serializer->serialize($eleve, 'json');
        return new JsonResponse($jsonEleve, Response::HTTP_NOT_FOUND);
   }

   #[Route('/api/eleve/{id}', name: 'app_delete_eleve', methods: ['DELETE'])]
    public function deleteElve(Eleve $eleve, EntityManagerInterface $em,EleveRepository $eleveRepository,SerializerInterface $serializer): JsonResponse 
    {
        $em->remove($eleve);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/eleves', name:"app_create_eleve", methods: ['POST'])]
    public function createEleve(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse 
    {

        $eleve = $serializer->deserialize($request->getContent(), Eleve::class, 'json');
        $em->persist($eleve);
        $em->flush();

        $jsonEleve = $serializer->serialize($eleve, 'json');
        
        $location = $urlGenerator->generate('app_detail_eleve', ['id' => $eleve->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonEleve, Response::HTTP_CREATED, ["Location" => $location], true);
   }

   #[Route('/api/eleve/{id}', name:"app_update_eleve", methods:['PUT'])]

   public function updateEleve(Request $request, SerializerInterface $serializer, Eleve $currentEleve, EntityManagerInterface $em): JsonResponse 
   {
       $updatedEleve = $serializer->deserialize($request->getContent(), 
               Eleve::class, 
               'json', 
               [AbstractNormalizer::OBJECT_TO_POPULATE => $currentEleve]);
       
       $em->persist($updatedEleve);
       $em->flush();
       return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
  }
}

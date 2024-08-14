<?php

namespace App\Http\Controllers;

use App\Entities\Author;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return new JsonResponse("Here are some authors");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $author = $this->serializer->deserialize($request->getContent(), Author::class, 'json');

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return new JsonResponse("Author created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $id]);
        if (!$author) {
            return new JsonResponse(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonAuthor = $this->serializer->serialize($author, 'json');

        return new JsonResponse($jsonAuthor, Response::HTTP_OK, [], true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $id]);
        if (!$author) {
            return new JsonResponse(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($author);
        $this->entityManager->flush();

        return new JsonResponse("Athor with $id is deleted", Response::HTTP_NO_CONTENT);
    }

}

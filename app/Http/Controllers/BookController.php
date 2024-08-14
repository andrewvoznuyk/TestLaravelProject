<?php

namespace App\Http\Controllers;

use App\Entities\Author;
use App\Entities\Book;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(int $page = 1, int $limit = 10): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Book::class);
        $totalBooks = $repository->count([]);
        $offset = ($page - 1) * $limit;

        $books = $repository->findBy([], null, $limit, $offset);

        $jsonBooks = $this->serializer->serialize($books, 'json');

        return new JsonResponse([
            'total' => $totalBooks,
            'page' => $page,
            'limit' => $limit,
            'books' => $jsonBooks
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = $this->serializer->deserialize($request->getContent(), Book::class, 'json');

        $authorId = $request->request->get("author_id");
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['id' => $authorId]);

        if (!$author){
            return new JsonResponse(['error' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        $book->setAuthor($author);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return new JsonResponse("Book created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);
        if (!$book) {
            return new JsonResponse(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonBook = $this->serializer->serialize($book, 'json');

        return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['id' => $id]);
        if (!$book) {
            return new JsonResponse(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return new JsonResponse("Book with $id is deleted", Response::HTTP_NO_CONTENT);
    }
}

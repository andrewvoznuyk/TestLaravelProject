<?php

namespace App\Console\Commands;

use App\Entities\Book;
use App\Entities\PublishHouse;
use App\Entities\PublishHouseBook;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreatePublishHouseBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish-house-book:create
                            {bookId : The ID of the book}
                            {publishHouseId : The ID of the publish house}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PublishHouseBook record';

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(protected EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $bookId = $this->argument('bookId');
        $publishHouseId = $this->argument('publishHouseId');

        $book = $this->entityManager->find(Book::class, $bookId);
        if (!$book) {
            $this->error("Book with ID $bookId not found.");
            return;
        }

        $publishHouse = $this->entityManager->find(PublishHouse::class, $publishHouseId);
        if (!$publishHouse) {
            $this->error("PublishHouse with ID $publishHouseId not found.");
            return;
        }

        $publishHouseBook = new PublishHouseBook();
        $publishHouseBook->setBook($book);
        $publishHouseBook->setPublishHouse($publishHouse);

        $this->entityManager->persist($publishHouseBook);
        $this->entityManager->flush();

        $this->info('PublishHouseBook created successfully.');
    }
}

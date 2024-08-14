<?php

namespace App\Console\Commands;

use App\Entities\Author;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;

class CreateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:create
                            {name : The name of the author}
                            {surname : The surname of the author}
                            {email : The email address of the author}
                            {birthDay? : The birthdate of the author (format: YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new author record';

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
        $name = $this->argument('name');
        $surname = $this->argument('surname');
        $email = $this->argument('email');
        $birthDayString = $this->argument('birthDay');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address.');
            return;
        }

        try {
            $birthDay = $birthDayString ? new DateTimeImmutable($birthDayString) : null;
        } catch (Exception $e) {
            $this->error('Invalid date format. Please use YYYY-MM-DD.');
            return;
        }

        $author = new Author();
        $author->setName($name);
        $author->setSurname($surname);
        $author->setEmail($email);
        $author->setBirthDay($birthDay);

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        $this->info('Author created successfully.');
    }
}

<?php

namespace App\Console\Commands;

use App\Entities\PublishHouse;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;

class CreatePublishHouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish-house:create
                            {name : The name of the publish house}
                            {description : The description of the publish house}
                            {foundedAt : The founding date of the publish house (format: YYYY-MM-DD)}
                            {owner : The owner of the publish house}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new publish house record';

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
        $description = $this->argument('description');
        $foundedAtString = $this->argument('foundedAt');
        $owner = $this->argument('owner');

        try {
            $foundedAt = new DateTimeImmutable($foundedAtString);
        } catch (Exception $e) {
            $this->error('Invalid date format. Please use YYYY-MM-DD.');
            return;
        }

        $publishHouse = new PublishHouse();
        $publishHouse->setName($name);
        $publishHouse->setDescription($description);
        $publishHouse->setFoundedAt($foundedAt);
        $publishHouse->setOwner($owner);

        $this->entityManager->persist($publishHouse);
        $this->entityManager->flush();

        $this->info('PublishHouse created successfully.');
    }
}

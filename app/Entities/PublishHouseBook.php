<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'publishHouseBook')]
class PublishHouseBook
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Book|null
     */
    #[ORM\ManyToOne(inversedBy: 'publishHouseBooks')]
    private ?Book $book = null;

    /**
     * @var PublishHouse|null
     */
    #[ORM\ManyToOne(inversedBy: 'publishHouseBooks')]
    private ?PublishHouse $publishHouse = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Book|null $book
     * @return $this
     */
    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * @param PublishHouse|null $publishHouse
     * @return $this
     */
    public function setPublishHouse(?PublishHouse $publishHouse): static
    {
        $this->publishHouse = $publishHouse;

        return $this;
    }

    /**
     * @return PublishHouse|null
     */
    public function getPublishHouse(): ?PublishHouse
    {
        return $this->publishHouse;
    }
}

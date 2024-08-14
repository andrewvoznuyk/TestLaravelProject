<?php

namespace App\Entities;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'book')]
class Book
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Author|null
     */
    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Author $author = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $wroteAt = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $filePath = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    /**
     * @var Collection<int, PublishHouseBook>
     */
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: PublishHouseBook::class)]
    private Collection $publishHouseBooks;

    /**
     *
     */
    public function __construct()
    {
        $this->publishHouseBooks = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Author|null
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * @param Author|null $author
     * @return $this
     */
    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getWroteAt(): ?DateTimeInterface
    {
        return $this->wroteAt;
    }

    /**
     * @param DateTimeInterface $wroteAt
     * @return $this
     */
    public function setWroteAt(DateTimeInterface $wroteAt): static
    {
        $this->wroteAt = $wroteAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return $this
     */
    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return $this
     */
    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, PublishHouseBook>
     */
    public function getPublishHouseBooks(): Collection
    {
        return $this->publishHouseBooks;
    }

    /**
     * @param PublishHouseBook $publishHouseBook
     * @return $this
     */
    public function addPublishHouseBook(PublishHouseBook $publishHouseBook): static
    {
        if (!$this->publishHouseBooks->contains($publishHouseBook)) {
            $this->publishHouseBooks->add($publishHouseBook);
            $publishHouseBook->setBook($this);
        }

        return $this;
    }

    /**
     * @param PublishHouseBook $publishHouseBook
     * @return $this
     */
    public function removePublishHouseBook(PublishHouseBook $publishHouseBook): static
    {
        if ($this->publishHouseBooks->removeElement($publishHouseBook)) {
            if ($publishHouseBook->getBook() === $this) {
                $publishHouseBook->setBook(null);
            }
        }

        return $this;
    }
}

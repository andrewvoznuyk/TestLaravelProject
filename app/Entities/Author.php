<?php

namespace App\Entities;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity]
#[ORM\Table(name: 'author')]
class Author
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
    #[NotBlank]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[Email]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $birthDay = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class)]
    private Collection $books;

    /**
     *
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthDay(): ?DateTimeInterface
    {
        return $this->birthDay;
    }

    /**
     * @param DateTimeInterface|null $birthDay
     */
    public function setBirthDay(?DateTimeInterface $birthDay): void
    {
        $this->birthDay = $birthDay;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }

        return $this;
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}

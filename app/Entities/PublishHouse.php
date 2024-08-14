<?php

namespace App\Entities;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'publishHouse')]
class PublishHouse
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
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?DateTimeImmutable $foundedAt = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    /**
     * @var Collection<int, PublishHouseBook>
     */
    #[ORM\OneToMany(mappedBy: 'publishHouse', targetEntity: PublishHouseBook::class)]
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getFoundedAt(): ?\DateTimeImmutable
    {
        return $this->foundedAt;
    }

    /**
     * @param DateTimeImmutable $foundedAt
     * @return $this
     */
    public function setFoundedAt(\DateTimeImmutable $foundedAt): static
    {
        $this->foundedAt = $foundedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     * @return $this
     */
    public function setOwner(string $owner): static
    {
        $this->owner = $owner;

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
            $publishHouseBook->setPublishHouse($this);
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
            if ($publishHouseBook->getPublishHouse() === $this) {
                $publishHouseBook->setPublishHouse(null);
            }
        }

        return $this;
    }
}

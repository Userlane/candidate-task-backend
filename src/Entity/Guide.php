<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuideRepository::class)]
class Guide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?string $original_language = null;

    #[ORM\Column(length: 4)]
    private ?string $language = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'data')]
    private Collection $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->original_language;
    }

    public function setOriginalLanguage(string $original_language): static
    {
        $this->original_language = $original_language;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(Step $data): static
    {
        if (!$this->data->contains($data)) {
            $this->data->add($data);
            $data->setData($this);
        }

        return $this;
    }

    public function removeData(Step $data): static
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getData() === $this) {
                $data->setData(null);
            }
        }

        return $this;
    }
}

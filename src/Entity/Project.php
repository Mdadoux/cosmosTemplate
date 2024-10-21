<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[UniqueEntity('title', message: 'Un projet portant le même nom existe déjà !')]
#[UniqueEntity('slug', message: 'Slug déjà prit')]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: 'Slug invalide !')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?Client $idClient = null;

    #[ORM\ManyToMany(targetEntity: Technology::class, mappedBy: 'projects')]
    private Collection $technologies;

    /**
     * @var Collection<int, ImgProject>
     */

    /* #[ORM\OneToMany(targetEntity: ImgProject::class, mappedBy: 'project_id')] */
    #[ORM\OneToMany(targetEntity: ImgProject::class, mappedBy: 'project', cascade: ['persist'], orphanRemoval: true)]
    private Collection $imgProjects;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->imgProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getcreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getupdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setupdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): static
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies->add($technology);
            $technology->addProject($this);
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): static
    {
        if ($this->technologies->removeElement($technology)) {
            $technology->removeProject($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, ImgProject>
     */
    public function getImgProjects(): Collection
    {
        return $this->imgProjects;
    }

    public function addImgProject(ImgProject $imgProject): static
    {
        if (!$this->imgProjects->contains($imgProject)) {
            $this->imgProjects->add($imgProject);
            $imgProject->setProjectId($this);
        }

        return $this;
    }

    public function removeImgProject(ImgProject $imgProject): static
    {
        if ($this->imgProjects->removeElement($imgProject)) {
            // set the owning side to null (unless already changed)
            if ($imgProject->getProjectId() === $this) {
                $imgProject->setProjectId(null);
            }
        }

        return $this;
    }

    public function getProjectImageFile(): ?File
    {
        return $this->projectImageFile;
    }

    public function setProjectImageFile(?File $projectImageFile): static
    {
        $this->projectImageFile = $projectImageFile;

        return $this;
    }
}

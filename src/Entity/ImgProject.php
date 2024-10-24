<?php

namespace App\Entity;

use App\Repository\ImgProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImgProjectRepository::class)]
#[Vich\Uploadable]
class ImgProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\Column]
    private ?bool $cover = false;

    #[ORM\ManyToOne(targetEntity: 'Project', inversedBy: 'imgProjects')]
    private ?Project $project = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Vich\UploadableField(mapping: 'projects', fileNameProperty: 'imageName')]
    private ?File $file = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    public function setFile(?File $imageFile = null): self
    {
        $this->file = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        $this->createdAt = new \DateTimeImmutable();
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isCover(): ?bool
    {
        return $this->cover;
    }

    public function setCover(bool $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getProjectId(): ?Project
    {
        return $this->project;
    }

    public function setProjectId(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function __toString()
    {
        return $this->imageName;
    }
}

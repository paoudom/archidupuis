<?php

namespace App\Entity;

use App\Repository\CarouselRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CarouselRepository::class)
 * @Vich\Uploadable()
 */
class Carousel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes={"image/jpeg", "image/png"},
     * )
     * @Vich\UploadableField(mapping="chantier_carousel", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Chantier::class, inversedBy="carousel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chantier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get })
     *
     * @return  File|null
     */ 
    public function getImageFile() :?File
    {
        return $this->imageFile;
    }
 
    /**
     * Set })
     *
     * @param  File|null  $imageFile  })
     *
     * @return  self
     */ 
    public function setImageFile(?File $imageFile) :self
    {
        $this->imageFile = $imageFile;
 
        return $this;
    }

    public function getChantier(): ?Chantier
    {
        return $this->chantier;
    }

    public function setChantier(?Chantier $chantier): self
    {
        $this->chantier = $chantier;

        return $this;
    }
}

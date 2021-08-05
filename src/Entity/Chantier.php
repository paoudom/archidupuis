<?php

namespace App\Entity;

use App\Repository\ChantierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
 
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ChantierRepository::class)
 * @Vich\Uploadable()
 */
class Chantier
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $archi;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annee;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;
 
    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes={"image/jpeg", "image/png"},
     * )
     * @Vich\UploadableField(mapping="chantier_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Carousel::class, mappedBy="chantier", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $carousel;

     /**
     * @Assert\All({
     *    @Assert\Image(mimeTypes={"image/jpeg", "image/png"},)
     * })
     */   
    private $carouselFiles;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->carousel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getArchi(): ?string
    {
        return $this->archi;
    }

    public function setArchi(string $archi): self
    {
        $this->archi = $archi;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     * @return Chantier
     */
    public function setImageFile(?File $imageFile): Chantier
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Carousel[]
     */
    public function getCarousel(): Collection
    {
        return $this->carousel;
    }

    public function addCarousel(Carousel $carousel): self
    {
        if (!$this->carousel->contains($carousel)) {
            $this->carousel[] = $carousel;
            $carousel->setChantier($this);
        }

        return $this;
    }

    public function removeCarousel(?Carousel $carousel): self
    {
        if ($this->carousel->removeElement($carousel)) {
            // set the owning side to null (unless already changed)
            if ($carousel->getChantier() === $this) {
                $carousel->setChantier(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of carouselFiles
     */ 
    public function getCarouselFiles()
    {
        return $this->carouselFiles;
    }

    /**
     * Set the value of carouselFiles
     *
     * @return  self
     */ 
    public function setCarouselFiles($carouselFiles)
    {
        foreach($carouselFiles as $carouselFile) {
            $carousel = new Carousel();
            $carousel->setImageFile($carouselFile);
            $this->addCarousel($carousel);
        }
        $this->carouselFiles = $carouselFiles;
        return $this;

    }
}

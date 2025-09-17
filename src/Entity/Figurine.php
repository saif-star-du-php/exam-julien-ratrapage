<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:'App\\Repository\\FigurineRepository')]
class Figurine
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:100)]
    #[Assert\NotBlank]
    #[Assert\Length(min:3)]
    private string $title;

    #[ORM\Column(type:"text", nullable:true)]
    private ?string $description = null;

    #[ORM\Column(type:"string", length:500)]
    #[Assert\NotBlank]
    private string $imageName;

    #[ORM\Column(type:"float", options:["default"=>0])]
    private float $price = 0.0;

    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class, inversedBy:"figurines")]
    #[ORM\JoinColumn(nullable:false)]
    private User $author;

    public function __construct()
    {
        $this->initializeTimestamps();
    }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $t): self { $this->title = $t; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $d): self { $this->description = $d; return $this; }

    public function getImageName(): string { return $this->imageName; }
    public function setImageName(string $name): self { $this->imageName = $name; return $this; }

    public function getPrice(): float { return $this->price; }
    public function setPrice(float $p): self { $this->price = $p; return $this; }

    public function getAuthor(): User { return $this->author; }
    public function setAuthor(User $u): self { $this->author = $u; return $this; }
}

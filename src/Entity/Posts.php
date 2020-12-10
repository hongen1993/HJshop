<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostsRepository::class)
 */
class Posts
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
    private $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $likes;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $foto;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $fotoB;


    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaPublicacion;

    /**
     * @ORM\Column(type="string", length=80000)
     */
    private $contenido;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $precio;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2,nullable=true)
     */
    private $precioAntes;

    /**
     * @ORM\Column(type="string")
     */

    private $sku;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    private $stock;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentarios", mappedBy="posts")
     */

    private $comentarios;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */

    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */

    private $category;

    /**
     * Posts constructor.
     */

     public function __construct()
     {
         $this->likes='';
         $this->fechaPublicacion = new \DateTime();
     }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLikes(): ?string
    {
        return $this->likes;
    }

    public function setLikes(?string $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }
    public function getFotoB(): ?string
    {
        return $this->fotoB;
    }

    public function setFotoB(string $fotoB): self
    {
        $this->fotoB = $fotoB;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fechaPublicacion): self
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getPrecioAntes(): ?string
    {
        return $this->precioAntes;
    }

    public function setPrecioAntes(string $precioAntes): self
    {
        $this->precioAntes = $precioAntes;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return mixed
     */

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */

    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */

    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */

    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
    }
    
    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}

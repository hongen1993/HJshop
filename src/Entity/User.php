<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $baneado;

    /**
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     */
    private $apellidos;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $numerotelefono;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechanacimiento;

    /**
     * @ORM\Column(type="string")
     */

    private $provincia;

        /**
     * @ORM\Column(type="integer")
     */

    private $codigopostal;

        /**
     * @ORM\Column(type="string")
     */

    private $direccion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentarios", mappedBy="user")
     */

    private $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="user")
     */
    private $posts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */

    public function getBaneado()
    {
        return $this->baneado;
    }

    /**
     * @param mixed $baneado
     */

    public function setBaneado($baneado): void
    {
        $this->baneado = $baneado;
    }

    /**
     * @return mixed
     */

    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    
    /**
     * @return mixed
     */

    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */

    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }


    /**
     * @return mixed
     */

    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /**
     * @param mixed $fechanacimiento
     */

    public function setFechanacimiento($fechanacimiento): void
    {
        $this->fechanacimiento = $fechanacimiento;
    }

    
    /**
     * @return mixed
     */

    public function getNumerotelefono()
    {
        return $this->numerotelefono;
    }

    /**
     * @param mixed $numerotelefono
     */

    public function setNumerotelefono($numerotelefono): void
    {
        $this->numerotelefono = $numerotelefono;
    }

    
    /**
     * @return mixed
     */

    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param mixed $provincia
     */

    public function setProvincia($provincia): void
    {
        $this->provincia = $provincia;
    }

        /**
     * @return mixed
     */

    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * @param mixed $codigoPostal
     */

    public function setCodigopostal($codigopostal): void
    {
        $this->codigopostal = $codigopostal;
    }
            /**
     * @return mixed
     */

    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */

    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }
}

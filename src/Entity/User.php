<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

class User extends Entity
{

    /**
     * @desc The model class name
     *
     * @var string
     */
    protected string $model = "users";

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $hidden = [];

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $fillable = ['name', 'username', 'email', 'phone', 'website'];

    /**
     * @desc The relationships that should be loaded by default
     *
     * @var array
     */
    protected array $with = [];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column(length: 255)]
    protected ?string $username = null;

    #[ORM\Column(length: 255)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    protected ?string $phone = null;

    #[ORM\Column(length: 255)]
    protected ?string $website = null;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }
}

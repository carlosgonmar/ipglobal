<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Post extends Entity
{

    /**
     * @desc The model class name
     *
     * @var string
     */
    protected string $model = "posts";

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $hidden = ['userId'];

    /**
     * @desc The attributes that aren't visible in the model
     *
     * @var array
     */
    protected array $fillable = ['userId', 'title', 'body'];

    /**
     * @desc The relationships that should be loaded by default
     *
     * @var array
     */
    protected array $with = [];


    protected ?int $id = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\GreaterThan(0)
     */
    protected ?int $userId = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=3, max=255)
     */
    protected ?string $title = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=3)
     */
    protected ?string $body = null;

    /*
     * @desc Returns the user associated with the post
     *
     * @return User|null
     */
    public function user(): ?User
    {
        if($this->userId){
            $userRepository = new UserRepository();
            return $userRepository->find($this->userId);
        }
        return null;

    }

    /*
     * @desc Returns the post id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /*
     * @desc Returns the user id associated with the post
     *
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /*
     * @desc Sets the user id associated with the post
     *
     * @param int|null $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /*
     * @desc Returns the post title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /*
     * @desc Sets the post title
     *
     * @param string|null $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /*
     * @desc Returns the post body
     *
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /*
     * @desc Sets the post body
     *
     * @param string|null $body
     *
     * @return self
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

}

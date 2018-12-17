<?php

namespace App\Entity;

use App\Dto\UserDto;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $telephoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getTelephoneNumber(): ?string
    {
        return $this->telephoneNumber;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param UserDto $userDto
     * @return User
     */
    public static function createFromDto(UserDto $userDto) : User
    {
        $user = new static();
        self::fillFromDto($userDto, $user);

        return $user;
    }

    public function updateFromDto(UserDto $userDto): void
    {
        self::fillFromDto($userDto, $this);
    }

    /**
     * @param UserDto $userDto
     * @param $user
     */
    protected static function fillFromDto(UserDto $userDto, $user): void
    {
        $user->name = $userDto->getName();
        $user->surname = $userDto->getSurname();
        $user->telephoneNumber = $userDto->getTelephoneNumber();
        $user->address = $userDto->getAddress();
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "surname" => $this->getSurname(),
            "telephoneNumber" => $this->getTelephoneNumber(),
            "address" => $this->getAddress()
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Dto;


class UserDto
{
    private $name;
    private $surname;
    private $telephoneNumber;
    private $address;

    /**
     * @param array $data
     * @return UserDto
     */
    public static function createFromData(array $data): UserDto
    {
        $dto = new static();

        self::fillWithData($data, $dto);

        return $dto;
    }

    /**
     * @param \App\Entity\User $user
     * @return UserDto
     */
    public static function createFromUser(\App\Entity\User $user): UserDto
    {
        $dto = new static();

        $dto->name = $user->getName();
        $dto->surname = $user->getSurname();
        $dto->telephoneNumber = $user->getTelephoneNumber();
        $dto->address = $user->getAddress();

        return $dto;
    }

    /**
     * @param array $data
     */
    public function updateFromArray(array $data): void
    {
        self::fillWithData($data, $this);
    }

    /**
     * @param array $data
     * @param $dto
     */
    private static function fillWithData(array $data, UserDto $dto): void
    {
        foreach (get_class_vars(static::class) as $field => $value) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $dto->{$field} = $data[$field];
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getTelephoneNumber(): string
    {
        return $this->telephoneNumber;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}

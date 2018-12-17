<?php
declare(strict_types=1);

namespace App\Dto;


class UserDto
{
    private $name;
    private $surname;
    private $telephoneNumber;
    private $address;

    public static function createFromData(array $data): UserDto
    {
        $dto = new static();

        foreach (get_class_vars(static::class) as $field => $value) {
            if (isset($data[$field])) {
                $dto->{$field} = $data[$field];
            }
        }

        return $dto;
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

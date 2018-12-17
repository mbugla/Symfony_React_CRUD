<?php

namespace Test\App\Entity\User;


use App\Dto\UserDto;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedFromDtoObject()
    {
        $data = ['name'=> 'name', 'surname' => 'surname', 'telephoneNumber' => '+48123123123', 'address'=> 'address'];
        $dto = UserDto::createFromData($data);

        $user = User::createFromDto($dto);

        $this->assertEquals('name', $user->getName());
        $this->assertEquals('surname', $user->getSurname());
        $this->assertEquals('+48123123123', $user->getTelephoneNumber());
        $this->assertEquals('address', $user->getAddress());
    }
}

<?php

namespace Test\App\Dto;


use App\Dto\UserDto;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedFromData()
    {
        $data = ['name' => 'john', 'surname'=>'doe', 'telephoneNumber'=>'1223', 'address'=> 'Ny'];

        $dto = UserDto::createFromData($data);

        $this->assertInstanceOf(UserDto::class, $dto);
        $this->assertEquals('john', $dto->getName());
    }

    /**
     * @test
     */
    public function canBeCreatedFromUser()
    {
        $user = $this->prophesize(User::class);
        $user->getName()->willReturn('john');
        $user->getSurname()->willReturn('doe');
        $user->getTelephoneNumber()->willReturn('123');
        $user->getAddress()->willReturn('Ny');

        $dto = UserDto::createFromUser($user->reveal());

        $this->assertInstanceOf(UserDto::class, $dto);
        $this->assertEquals('john', $dto->getName());
    }

    /**
     * @test
     */
    public function canBeUpdatedWithData()
    {
        $user = $this->prophesize(User::class);
        $user->getName()->willReturn('john');
        $user->getSurname()->willReturn('doe');
        $user->getTelephoneNumber()->willReturn('123');
        $user->getAddress()->willReturn('Ny');

        $dto = UserDto::createFromUser($user->reveal());
        $data = ['name' => 'Jason'];

        $dto->updateFromArray($data);

        $this->assertEquals('Jason', $dto->getName());
    }
}

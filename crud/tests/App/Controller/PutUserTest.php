<?php

namespace Test\App\Controller;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Test\Support\PositiveValidator;


class PutUserTest extends ApiControllerTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function allowsToUpdateUser()
    {
        $controller = $this->createUserController(new PositiveValidator());

        $user = new UserAccessor(1, 'Ned', 'Stark', '000', 'Winterfell');

        $this->userRepository->store($user);

        $request = $this->prophesize(Request::class);

        $request->getContent()->willReturn('{"name": "Neddart", "address": "Grave"}');

        $updatedUser = $this->getResponseContent( $controller->putUserAction($request->reveal(), 1));

        $this->assertEquals('Neddart', $updatedUser['name']);

    }
}

class UserAccessor extends User
{
    public function __construct($id, $name, $surname, $telephoneNumber, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->telephoneNumber = $telephoneNumber;
        $this->address = $address;
    }
}

<?php

namespace Test\App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Test\Support\FailingValidator;
use Test\Support\PositiveValidator;

class CreateUserTest extends ApiControllerTest
{
    /**
     * @test
     */
    public function userCanBeCreatedWithValidDataAndStored()
    {
        $controller = $this->createUserController(new PositiveValidator());
        $request = $this->prophesize(Request::class);
        $request->getContent()->willReturn('{"name": "john", "surname":"doe", "telephoneNumber": "233123123", "address": "Manhatan"}');

        $result = $controller->postUsersAction($request->reveal());
        $responseContent = json_decode($result->getContent(), true);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $this->assertEquals("john", $responseContent['name']);
        $this->assertEquals("doe", $responseContent['surname']);
        $this->assertEquals("233123123", $responseContent['telephoneNumber']);
        $this->assertEquals("Manhatan", $responseContent['address']);

        $this->assertCount(1, $this->userRepository->getAll(20, 0));
    }

    /**
     * @test
     */
    public function userIsNotCreatedFromInvalidData()
    {
        $controller = $this->createUserController(new FailingValidator());

        $request = $this->prophesize(Request::class);
        $request->getContent()->willReturn('{}');

        $result = $controller->postUsersAction($request->reveal());
        $responseContent = json_decode($result->getContent(), true);

        $this->assertInstanceOf(JsonResponse::class, $result);

        $this->assertEquals(['value' => '""', 'property' => "name"], $responseContent[0]);
    }

}

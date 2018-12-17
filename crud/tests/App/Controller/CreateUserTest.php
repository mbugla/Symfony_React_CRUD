<?php


namespace Test\App\Controller;

use App\Controller\UsersController;
use App\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Test\Support\FailingValidator;
use Test\Support\PositiveValidator;
use Test\Support\UsersInMemoryRepository;

class CreateUserTest extends TestCase
{
    /** @var UsersController */
    private $controller;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new UsersInMemoryRepository();
    }

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

    /**
     * @param ValidatorInterface $validator
     * @return UsersController
     */
    protected function createUserController(ValidatorInterface $validator): UsersController
    {
        return new UsersController($validator, $this->userRepository);
    }
}

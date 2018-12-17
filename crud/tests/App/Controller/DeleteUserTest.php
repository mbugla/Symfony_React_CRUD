<?php

namespace Test\App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Test\Support\PositiveValidator;

class DeleteUserTest extends ApiControllerTest
{
    public function setUp()
    {
        parent::setUp();
        $this->prepareData();
        $this->controller = $this->createUserController(new PositiveValidator());
    }

    /**
     * @test
     */
    public function allowsToDeleteUser()
    {
        $result = $this->controller->deleteUserAction(1);

        $this->assertCount(3, $this->userRepository->getAll(10, 0));
        $this->assertEquals(Response::HTTP_NO_CONTENT, $result->getStatusCode());
    }
}

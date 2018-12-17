<?php

namespace Test\App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Test\Support\PositiveValidator;

class GetUsersTest extends ApiControllerTest
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
    public function returnAllUsers()
    {
        $request = $this->prophesize(Request::class);
        $request->get('page', 1)->willReturn(1);
        $result = $this->controller->getUsersAction($request->reveal());
        $responseContent = $this->getResponseContent($result);
        $this->assertCount(4, $responseContent);
        $u1 = array_shift($responseContent);
        $this->assertEquals(1, $u1['id']);
    }
}

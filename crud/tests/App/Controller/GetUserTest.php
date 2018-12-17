<?php

namespace Test\App\Controller;


use Test\Support\PositiveValidator;

class GetUserTest extends ApiControllerTest
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
    public function canReturnUserByItsId()
    {
        $responseContent = $this->getResponseContent($this->controller->getUserAction(4));

        $this->assertEquals([
            'id' => '4',
            'name' => 'Arya',
            'surname' => 'Stark',
            'telephoneNumber' => '098',
            'address' => 'WF'
        ], $responseContent);
    }

    /**
     * @test
     */
    public function returns404OnNotFoundUser()
    {
        $result = $this->controller->getUserAction(43);

        $this->assertEquals(404, $result->getStatusCode());
    }
}

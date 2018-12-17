<?php

namespace Test\App\Controller;


use PHPUnit\Framework\TestCase;

class GetUserTest extends GetUsersTest
{
    public function setUp()
    {
        parent::setUp();
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

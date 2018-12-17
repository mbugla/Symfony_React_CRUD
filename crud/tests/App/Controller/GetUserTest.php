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

        $this->assertEquals(['name'=>'Arya','surname'=>'Stark','telephoneNumber'=>'098', 'address'=>'WF'], $responseContent);
    }
}

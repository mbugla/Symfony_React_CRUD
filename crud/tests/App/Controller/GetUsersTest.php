<?php


namespace Test\App\Controller;


use App\Controller\UsersController;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Test\Support\PositiveValidator;
use Test\Support\UsersInMemoryRepository;

class GetUsersTest extends TestCase
{
    /** @var UsersController */
    private $controller;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new UsersInMemoryRepository();
        $this->controller = new UsersController(new PositiveValidator(), $this->userRepository);
    }

    /**
     * @test
     */
    public function returnAllUsers()
    {
        $this->prepareData();
        $request = $this->prophesize(Request::class);
        $request->get('page', 1)->willReturn(1);
        $result = $this->controller->getUsersAction($request->reveal());
        $responseContent = json_decode($result->getContent(), true);
        $this->assertCount(4, $responseContent);
        $u1 = array_shift($responseContent);
        $this->assertEquals(1, $u1['id']);
    }

    protected function prepareData(): void
    {
        $u1 = new User();
        $u1->setId(1);

        $u2 = new User();
        $u2->setId(2);

        $u3 = new User();
        $u3->setId(3);

        $u4 = new User();
        $u4->setId(4);

        $this->userRepository->store($u1);
        $this->userRepository->store($u2);
        $this->userRepository->store($u3);
        $this->userRepository->store($u4);
    }
}

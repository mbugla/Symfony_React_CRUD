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
    protected $controller;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        $this->userRepository = new UsersInMemoryRepository();
        $this->controller = new UsersController(new PositiveValidator(), $this->userRepository);
        $this->prepareData();
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

    protected function prepareData(): void
    {
        $u1 = $this->prophesize(User::class);
        $u1->getId()->willReturn(1);
        $u1->getName()->willReturn('john');
        $u1->getSurname()->willReturn('doe');
        $u1->getTelephoneNumber()->willReturn('123');
        $u1->getAddress()->willReturn('Ny');

        $u2 = $this->prophesize(User::class);
        $u2->getId()->willReturn(2);
        $u2->getName()->willReturn('Jason');
        $u2->getSurname()->willReturn('Statam');
        $u2->getTelephoneNumber()->willReturn('456');
        $u2->getAddress()->willReturn('WA');

        $u3 = $this->prophesize(User::class);
        $u3->getId()->willReturn(3);
        $u3->getName()->willReturn('Rob');
        $u3->getSurname()->willReturn('Stark');
        $u3->getTelephoneNumber()->willReturn('789');
        $u3->getAddress()->willReturn('WF');

        $u4 = $this->prophesize(User::class);
        $u4->getId()->willReturn(4);
        $u4->getName()->willReturn('Arya');
        $u4->getSurname()->willReturn('Stark');
        $u4->getTelephoneNumber()->willReturn('098');
        $u4->getAddress()->willReturn('WF');


        $this->userRepository->store($u1->reveal());
        $this->userRepository->store($u2->reveal());
        $this->userRepository->store($u3->reveal());
        $this->userRepository->store($u4->reveal());
    }

    /**
     * @param $result
     * @return mixed
     */
    protected function getResponseContent($result): mixed
    {
        $responseContent = json_decode($result->getContent(), true);
        return $responseContent;
    }
}

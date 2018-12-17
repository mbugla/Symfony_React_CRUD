<?php

namespace Test\App\Controller;


use App\Controller\UsersController;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Test\Support\UsersInMemoryRepository;

abstract class ApiControllerTest extends TestCase
{
    /** @var UsersController */
    protected $controller;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function setUp()
    {
        $this->userRepository = new UsersInMemoryRepository();
    }

    /**
     * @param ValidatorInterface $validator
     * @return UsersController
     */
    protected function createUserController(ValidatorInterface $validator): UsersController
    {
        return new UsersController($validator, $this->userRepository);
    }

    protected function prepareData(): void
    {
        $u1 = $this->prophesize(User::class);
        $u1->getId()->willReturn(1);
        $u1->getName()->willReturn('john');
        $u1->getSurname()->willReturn('doe');
        $u1->getTelephoneNumber()->willReturn('123');
        $u1->getAddress()->willReturn('Ny');
        $u1->jsonSerialize()->willReturn([
            'id' => '1',
            'name' => 'john',
            'surname' => 'doe',
            'telephoneNumber' => '123',
            'address' => 'Ny'
        ]);

        $u2 = $this->prophesize(User::class);
        $u2->getId()->willReturn(2);
        $u2->getName()->willReturn('Jason');
        $u2->getSurname()->willReturn('Statam');
        $u2->getTelephoneNumber()->willReturn('456');
        $u2->getAddress()->willReturn('WA');
        $u2->jsonSerialize()->willReturn([
            'id' => '2',
            'name' => 'Jason',
            'surname' => 'Statam',
            'telephoneNumber' => '456',
            'address' => 'WA'
        ]);

        $u3 = $this->prophesize(User::class);
        $u3->getId()->willReturn(3);
        $u3->getName()->willReturn('Rob');
        $u3->getSurname()->willReturn('Stark');
        $u3->getTelephoneNumber()->willReturn('789');
        $u3->getAddress()->willReturn('WF');
        $u3->jsonSerialize()->willReturn([
            'id' => '3',
            'name' => 'Rob',
            'surname' => 'Stark',
            'telephoneNumber' => '789',
            'address' => 'WF'
        ]);

        $u4 = $this->prophesize(User::class);
        $u4->getId()->willReturn(4);
        $u4->getName()->willReturn('Arya');
        $u4->getSurname()->willReturn('Stark');
        $u4->getTelephoneNumber()->willReturn('098');
        $u4->getAddress()->willReturn('WF');
        $u4->jsonSerialize()->willReturn([
            'id' => '4',
            'name' => 'Arya',
            'surname' => 'Stark',
            'telephoneNumber' => '098',
            'address' => 'WF'
        ]);

        $this->userRepository->store($u1->reveal());
        $this->userRepository->store($u2->reveal());
        $this->userRepository->store($u3->reveal());
        $this->userRepository->store($u4->reveal());
    }

    /**
     * @param $result
     * @return array
     */
    protected function getResponseContent(JsonResponse $result): array
    {
        return json_decode($result->getContent(), true);
    }
}

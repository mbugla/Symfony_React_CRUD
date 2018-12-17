<?php

namespace Test\App\Controller;


use App\Entity\User;


class PutUserTest extends ApiControllerTest
{
    public function allowsToUpdateUser()
    {

    }
}

class UserAccessor extends User
{
    protected $id;
    protected $name;
    protected $surname;
    protected $telephoneNumber;
    protected $address;

    public function __construct($id, $name, $surname, $telephoneNumber, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->telephoneNumber = $telephoneNumber;
        $this->address = $address;
    }
}

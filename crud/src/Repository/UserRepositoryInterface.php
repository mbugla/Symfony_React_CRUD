<?php
/**
 * Created by PhpStorm.
 * User: mbugla
 * Date: 17.12.2018
 * Time: 13:17
 */

namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    public function store(User $user);

    public function delete(User $user);

    public function find($id);

    public function getAll($limit, $offset, $orderBy = null);
}

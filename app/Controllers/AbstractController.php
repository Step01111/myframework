<?php
namespace App\Controllers;

use App\Models\User\User;
use App\Services\User\AuthService;

abstract class AbstractController
{
    protected $user;

    public function __construct()
    {
        $this->user = AuthService::getUserByToken();
    }
}

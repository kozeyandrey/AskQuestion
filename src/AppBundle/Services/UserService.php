<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;

class UserService
{
    const INFO_USER = 'login';

    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function getInfo()
    {
        return $this->session->get(self::INFO_USER);
    }

    public function logout()
    {
        $this->session->clear();
    }

    public function login(User $user)
    {
        $this->session->set(self::INFO_USER, $user);
    }

}
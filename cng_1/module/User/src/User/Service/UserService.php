<?php

namespace User\Service;

use User\Entity\User;

interface UserService
{
    const GROUP_REGULAR = 1;

    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user);

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService();

    /**
     * @param string $email
     * @param string $password
     *
     * @return User|null
     */
    public function login($email, $password);
}
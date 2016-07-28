<?php

namespace User\Repository;

use Application\Repository\RepositoryInterface;
use User\Entity\User;

interface UserRepository extends RepositoryInterface
{
    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user);
    
    /**
     * @param User $user
     *
     * @return void
     */
    public function update(User $user);

    public function findById($userId);
    
    public function findByNickname($userId);
    
    /**
     * @param string $clearTextPassword
     *
     * @return string
     */
    public function generatePassword($clearTextPassword);

    /**
     * @return \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter
     */
    public function getAuthenticationAdapter();
}
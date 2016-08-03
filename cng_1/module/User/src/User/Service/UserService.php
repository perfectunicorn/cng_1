<?php

namespace User\Service;

use User\Entity\User;
use User\Entity\Career;

interface UserService
{
    const GROUP_REGULAR = 1;

    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user);
    
    public function update(User $user);
    
    public function findById($userId);
    
    public function findByNickname($userId);
    
    /*
     * Career services
     * 
     */
    
    public function addCareer(Career $career,$userId);
    
    public function updateCareer(Career $career);
     
    public function findCareerById($jobId);
    
    public function findCareerByUser($userId);
    
    public function fetchCareers($page);
    
    public function deleteCareer($careerId);
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
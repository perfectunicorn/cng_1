<?php

namespace User\Repository;

use Application\Repository\RepositoryInterface;
use User\Entity\User;
use User\Entity\Career;

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
    
    /*
     * Career repository
     * 
     */
    
    public function addCareer(Career $career,$userId);
    
    public function updateCareer(Career $career);
     
    public function findCareerById($jobId);
    
    public function findCareerByUser($userId);
    
    public function fetchCareers($page);
    
    public function deleteCareer($careerId);
    
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
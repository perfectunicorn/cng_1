<?php

namespace User\Service;

use User\Entity\Career;

interface CareerService
{
    const GROUP_REGULAR = 1;

  
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
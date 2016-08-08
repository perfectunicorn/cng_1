<?php

namespace User\Service;

use User\Entity\Career;
use User\Entity\Education;
use User\Entity\Project;
use User\Entity\User;

interface UserService
{
    const GROUP_REGULAR = 1;
    
    /*
     * Project services
     * 
     */
    
    public function addProject(Project $project,$authorId);
    
    public function updateProject(Project $project);
    
    public function findProjectById($projectId);
    
    public function findProjectByUser($authorId);
    
    public function fetchProjects($page);
    
    public function deleteProject($projectId);
    
    /*
     * Education services
     * 
     */
    
    public function addEducation(Education $education,$authorId);
    
    public function updateEducation(Education $education);
    
    public function findEducationById($educationId);
    
    public function findEducationByUser($authorId);
    
    public function fetchEducation($page);
    
    public function deleteEducation($educationId);

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
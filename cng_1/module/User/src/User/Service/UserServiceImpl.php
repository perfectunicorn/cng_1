<?php

namespace User\Service;

use User\Entity\User;
use User\Entity\Career;
use User\Entity\Education;
use User\Entity\Project;
use Zend\Authentication\AuthenticationService;

class UserServiceImpl implements UserService
{
    /**
     * @var \User\Repository\UserRepository $userRepository
     */
    protected $userRepository;


    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user)
    {
        $this->userRepository->add($user);
    }
    
     /**
     * @param User $user
     *
     * @return void
     */
    public function update(User $user)
    {
        $this->userRepository->update($user);
    }
    
    
     public function findById($userId)
    {
        return $this->userRepository->findById($userId);
    }
    
    public function findByNickname($userId)
    {
        return $this->userRepository->findByNickname($userId);
    }
    
    /*
     * Project services implementation
     * 
     */
    
    public function addProject(Project $project,$authorId)
    {
       $this->userRepository->addProject($project,$authorId); 
    }
    
    public function updateProject(Project $project)
    {
        $this->userRepository->updateProject($project); 
    }
     
    public function findProjectById($projectId)
    {
        return $this->userRepository->findProjectById($projectId); 
    }
    
    public function findProjectByUser($authorId)
    {
        return $this->userRepository->findProjectByUser($authorId);
    }
    
    public function fetchProjects($page)
    {
        $this->userRepository->fetchProjects($page);
    }
    
    public function deleteProject($projectId)
    {
        $this->userRepository->deleteProject($projectId);
    }
    
    
    
    /*
     * Education services' implementation
     * 
     */
    
    public function addEducation(Education $education,$authorId)
    {
       $this->userRepository->addEducation($education,$authorId); 
    }
    
    public function updateEducation(Education $education)
    {
        $this->userRepository->updateEducation($education); 
    }
     
    public function findEducationById($educationId)
    {
        return $this->userRepository->findEducationById($educationId); 
    }
    
    public function findEducationByUser($authorId)
    {
        return $this->userRepository->findEducationByUser($authorId);
    }
    
    public function fetchEducation($page)
    {
        $this->userRepository->fetchEducation($page);
    }
    
    public function deleteEducation($educationId)
    {
        $this->userRepository->deleteEducation($educationId);
    }
    
    /*
     * Career services' implementation
     * 
     */
    
    public function addCareer(Career $career,$userId)
    {
       $this->userRepository->addCareer($career,$userId); 
    }
    
    public function updateCareer(Career $career)
    {
        $this->userRepository->updateCareer($career); 
    }
     
    public function findCareerById($jobId)
    {
        return $this->userRepository->findCareerById($jobId); 
    }
    
    public function findCareerByUser($userId)
    {
        return $this->userRepository->findCareerByUser($userId);
    }
    
    public function fetchCareers($page)
    {
        $this->userRepository->fetchCareers($page);
    }
    
    public function deleteCareer($careerId)
    {
        $this->userRepository->deleteCareer($careerId);
    }
    
    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        $authenticationAdapter = $this->userRepository->getAuthenticationAdapter();
        return new AuthenticationService(null, $authenticationAdapter); // Storage defaults to session
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return boolean
     */
    public function login($email, $password)
    {
        $authenticationService = $this->getAuthenticationService();

        /**
         * @var \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter $authenticationAdapter
         */
        $authenticationAdapter = $authenticationService->getAdapter();
        $authenticationAdapter->setIdentity($email);
        $authenticationAdapter->setCredential($password);
        $result = $authenticationService->authenticate();
        

        if ($result->isValid()) {
            $identityObject = $authenticationAdapter->getResultRowObject(null, array('password'));
            $authenticationService->getStorage()->write($identityObject);
            

            return true;
        }

        return false;
    }

    /**
     * @param \User\Repository\UserRepository $userRepository
     */
    public function setUserRepository($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \User\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }
}
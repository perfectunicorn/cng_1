<?php

namespace User\Service;

use User\Entity\Career;
use Zend\Authentication\AuthenticationService;

class CareerServiceImpl implements CareerService
{
    /**
     * @var \User\Repository\UserRepository $userRepository
     */
    protected $careerRepository;
    
    /*
     * Career services' implementation
     * 
     */
    
    public function addCareer(Career $career,$userId)
    {
       $this->careerRepository->addCareer($career,$userId); 
    }
    
    public function updateCareer(Career $career)
    {
        $this->careerRepository->updateCareer($career); 
    }
     
    public function findCareerById($jobId)
    {
        $this->careerRepository->findCareerById($jobId); 
    }
    
    public function findCareerByUser($userId)
    {
        return $this->careerRepository->findCareerByUser($userId);
    }
    
    public function fetchCareers($page)
    {
        $this->careerRepository->fetchCareers($page);
    }
    
    public function deleteCareer($careerId)
    {
        $this->careerRepository->deleteCareer($careerId);
    }
    
    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        $authenticationAdapter = $this->careerRepository->getAuthenticationAdapter();
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
    public function setCareerRepository($careerRepository)
    {
        $this->careerRepository = $careerRepository;
    }

    /**
     * @return \User\Repository\UserRepository
     */
    public function getCareerRepository()
    {
        return $this->careerRepository;
    }
}
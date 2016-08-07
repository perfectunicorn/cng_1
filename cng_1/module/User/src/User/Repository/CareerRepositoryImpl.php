<?php

namespace User\Repository;


use User\Entity\Career;

use User\Entity\Hydrator\OwnerHydrator;
use User\Entity\Hydrator\CareerHydrator;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class CareerRepositoryImpl implements CareerRepository
{
    use AdapterAwareTrait;

    
    /*
     * Career repository's methods
     * 
     */
    
    public function addCareer(Career $career,$userId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'organization' => $career->getOrganization(),
                'position' => $career->getPosition(),
                'job_description' => $career->getJobDescription(),
                'job_achievement' => $career->getJobAchievement(),
                'start_date' => $career->getStartDate(),
                'end_date' => $career->getEndDate(),
                'created' => time(),
                'user_id' => $userId,
            ))
            ->into('career');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function updateCareer(Career $career)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('user')
            ->set(array(
                'organization' => $career->getOrganization(),
                'position' => $career->getPosition(),
                'job_description' => $career->getJobDescription(),
                'job_achievement' => $career->getJobAchievement(),
                'start_date' => $career->getStartDate(),
                'start_date' => $career->getEndDate(),
            ))
            ->where(array(
                'id' => $career->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute(); 
    }
     
    public function findCareerById($jobId)
    {
        
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'organization'=>'organization',
            'position'=>'position',
            'job_description'=>'job_description',
            'job_achievement'=>'job_achievement',
            'start_date'=>'start_date',
            'end_date'=>'end_date',
            'created',
            //'user_id'=>'user_id'
        ))
            ->from(array('p' => 'career'))
            ->join(
                array('a' => 'user'),
                'a.id = p.user_id',
                array(
                    'user_id' => 'id',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'email' => 'email',
                    'created' => 'created',
                    'user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $jobId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        $hydrator = new AggregateHydrator();
        $hydrator->add(new OwnerHydrator());
        $hydrator->add(new CareerHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Career());
        $resultSet->initialize($results);
        
        var_dump($resultSet->current());
        var_dump($resultSet->count());
        return ($resultSet->count() > 0 ? $resultSet->current() : null);
   
    }
    
    
        public function findCareerByUser($userId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'organization',
            'position',
            'job_description',
            'job_achievement',
            'start_date',
            'end_date',
        ))
            ->from(array('p' => 'career'))
            ->join(
                array('a' => 'user'),
                'a.id = p.user_id',
                array(
                    'user_id' => 'id',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'email' => 'email',
                    'created' => 'created',
                    'user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.user_id' => $userId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new OwnerHydrator());
        $hydrator->add(new CareerHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Career());
        $resultSet->initialize($results);
        
        return ($resultSet->count() > 0 ? $resultSet->toArray() : null);
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
     * @return \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter
     */
    public function getAuthenticationAdapter()
    {
        $callback = function($encryptedPassword, $clearTextPassword) {
            $encrypter = new Bcrypt();
            $encrypter->setCost(12);

            return $encrypter->verify($clearTextPassword, $encryptedPassword);
        };

        $authenticationAdapter = new \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter(
            $this->adapter,
            'user', // Table
            'email', // Identity column
            'password', // Credential column
            $callback
        );

        return $authenticationAdapter;
    }

    /**
     * @param string $clearTextPassword
     *
     * @return string
     */
    public function generatePassword($clearTextPassword)
    {
        $encrypter = new Bcrypt();
        $encrypter->setCost(12);

        return $encrypter->create($clearTextPassword);
    }
}
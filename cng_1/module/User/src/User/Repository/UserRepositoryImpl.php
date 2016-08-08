<?php

namespace User\Repository;

use User\Entity\User;
use User\Entity\Career;
use User\Entity\Education;
use User\Entity\Project;
use User\Entity\Hydrator\UserHydrator;
use User\Entity\Hydrator\ProjectHydrator;
use User\Entity\Hydrator\EducationHydrator;
use User\Entity\Hydrator\DegreeHydrator;
use User\Entity\Hydrator\AuthorHydrator;
use User\Entity\Hydrator\CareerHydrator;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class UserRepositoryImpl implements UserRepository
{
    use AdapterAwareTrait;

    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $this->generatePassword($user->getPassword()),
                'created' => time(),
                'user_group' => $user->getUserGroup(),
                'nickname' => $user->getNickname(),
                'gender' => $user->getGender(),
            ))
            ->into('user');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function update(User $user)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('user')
            ->set(array(
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'gender' => $user->getGender(),
                'age' => $user->getAge(),
                'bio' => $user->getBio(),
            ))
            ->where(array(
                'id' => $user->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function findById($userId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'first_name',
            'last_name',
            'email',
            'password',
            'created',
            'user_group',
            'nickname',
            'gender',
            'age',
            'bio'
        ))
            ->from(array('p' => 'user'))
            /*->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )*/
            ->where(array(
                'p.id' => $userId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new UserHydrator());

        $resultSet = new HydratingResultSet($hydrator, new User());
        $resultSet->initialize($results);
        
       

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    
    public function findByNickname($userId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'first_name',
            'last_name',
            'email',
            'password',
            'created',
            'user_group',
            'nickname',
            'gender',
            'age',
            'bio'
        ))
            ->from(array('p' => 'user'))
            /*->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )*/
            ->where(array(
                'p.nickname' => $userId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new UserHydrator());

        $resultSet = new HydratingResultSet($hydrator, new User());
        $resultSet->initialize($results);
        
         //var_dump($resultSet->current()); 
        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }
    
     /*
     * Project repository methods
     * 
     */
    
    public function addProject(Project $project,$authorId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'project_name' => $project->getProjectName(),
                'abstract' => $project->getAbstract(),
                'webpage' => $project->getWebpage(),
                'project_type' => $project->getProjectType(),
                'start_date' => $project->getStartDate(),
                'end_date' => $project->getEndDate(),
                'created' => time(),
                'author_id' => $authorId,
            ))
            ->into('project');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function updateProject(Project $project)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('project')
            ->set(array(
                'project_name' => $project->getProjectName(),
                'abstract' => $project->getAbstract(),
                'webpage' => $project->getWebpage(),
                'project_type' => $project->getProjectType(),
                'start_date' => $project->getStartDate(),
                'end_date' => $project->getEndDate(),
            ))
            ->where(array(
                'id' => $project->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute(); 
    }
     
    public function findProjectById($projectId)
    {
        
       $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'project_name',
            'abstract',
            'webpage',
            'project_type',
            'start_date',
            'end_date',
            'created',
        ))
            ->from(array('p' => 'project'))
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $projectId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
        $hydrator->add(new ProjectHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Project());
        $resultSet->initialize($results);
        var_dump($resultSet->current());

        
       return ($resultSet->count() > 0 ? $resultSet->current() : null);
        
    }
    
    
        public function findProjectByUser($authorId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'project_name',
            'abstract',
            'webpage',
            'project_type',
            'start_date',
            'end_date',
            'created',
        ))
            ->from(array('p' => 'project'))
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.author_id' => $authorId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
        $hydrator->add(new ProjectHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Project());
        $resultSet->initialize($results);
       // var_dump($resultSet->current());

        
       return ($resultSet->count() > 0 ? $resultSet->toArray() : null);
        
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
     * Education repository methods
     * 
     */
    
    public function addEducation(Education $education,$authorId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'organization' => $education->getOrganization(),
                'degree_id' => $education->getDegree()->getId(),
                'career' => $education->getCareer(),
                'academic_specialty' => $education->getAcademicSpecialty(),
                'academic_achievement' => $education->getAcademicAchievement(),
                'start_date' => $education->getStartDate(),
                'end_date' => $education->getEndDate(),
                'created' => time(),
                'author_id' => $authorId,
            ))
            ->into('education');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function updateEducation(Education $education)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('education')
            ->set(array(
                'organization' => $education->getOrganization(),
                'degree_id' => $education->getDegree()->getId(),
                'career' => $education->getCareer(),
                'academic_specialty' => $education->getAcademicSpecialty(),
                'academic_achievement' => $education->getAcademicAchievement(),
                'start_date' => $education->getStartDate(),
                'end_date' => $education->getEndDate(),
            ))
            ->where(array(
                'id' => $education->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute(); 
    }
     
    public function findEducationById($educationId)
    {
        
       $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'organization',
            'degree_id',
            'career',
            'academic_specialty',
            'academic_achievement',
            'start_date',
            'end_date',
            'created',
        ))
            ->from(array('p' => 'education'))
            ->join(
                array('c' => 'education_degree'), // Table name
                'c.id = p.degree_id', // Condition
                array('degree_id' => 'id', 'name' => 'degree'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $educationId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
        $hydrator->add(new DegreeHydrator());
        $hydrator->add(new EducationHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Education());
        $resultSet->initialize($results);
        var_dump($resultSet->current());

        
       return ($resultSet->count() > 0 ? $resultSet->current() : null);
        
    }
    
    
        public function findEducationByUser($authorId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'organization',
            'degree_id',
            'career',
            'academic_specialty',
            'academic_achievement',
            'start_date',
            'end_date',
            'created',
        ))
            ->from(array('p' => 'education'))
            ->join(
                array('c' => 'education_degree'), // Table name
                'c.id = p.degree_id', // Condition
                array('degree_id' => 'id', 'name' => 'degree'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.author_id' => $authorId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
        $hydrator->add(new DegreeHydrator());
        $hydrator->add(new EducationHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Education());
        $resultSet->initialize($results);
       // var_dump($resultSet->current());

        
       return ($resultSet->count() > 0 ? $resultSet->toArray() : null);
        
    }
    
    public function fetchEducation($page)
    {
        $this->userRepository->fetchCareers($page);
    }
    
    public function deleteEducation($careerId)
    {
        $this->userRepository->deleteCareer($educationId);
    }

    
    /*
     * Career repository's methods
     * 
     */
    
    public function addCareer(Career $career,$authorId)
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
                'author_id' => $authorId,
            ))
            ->into('career');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function updateCareer(Career $career)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('career')
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
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $jobId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
        $hydrator->add(new CareerHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Career());
        $resultSet->initialize($results);
        var_dump($resultSet->current());

        
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
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.author_id' => $userId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AuthorHydrator());
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
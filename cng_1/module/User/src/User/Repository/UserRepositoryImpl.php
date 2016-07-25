<?php

namespace User\Repository;

use User\Entity\User;
use User\Entity\Hydrator\UserHydrator;
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
            ))
            ->into('user');

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
            'user_group'
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
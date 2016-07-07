<?php

namespace User\Repository;

use User\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\AdapterAwareTrait;

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
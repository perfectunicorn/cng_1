<?php

namespace User\InputFilter;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\I18n\Validator\Alnum;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use Zend\Validator\ValidatorChain;

class AddUser extends InputFilter
{
    /**
     * @var \Zend\Db\Adapter\Adapter $dbAdapter
     */
    protected $dbAdapter;


    public function __construct(\Zend\Db\Adapter\Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

        $firstName = new Input('firstName');
        $firstName->setRequired(true);
        $firstName->setValidatorChain($this->getNameValidatorChain());
        $firstName->setFilterChain($this->getStringTrimFilterChain());

        $lastName = new Input('lastName');
        $lastName->setRequired(true);
        $lastName->setValidatorChain($this->getNameValidatorChain());
        $lastName->setFilterChain($this->getStringTrimFilterChain());

        $email = new Input('email');
        $email->setRequired(true);
        $email->setValidatorChain($this->getEmailValidatorChain());
        $email->setFilterChain($this->getStringTrimFilterChain());

        $password = new Input('password');
        $password->setRequired(true);
        $password->setValidatorChain($this->getPasswordValidatorChain());
        $password->setFilterChain($this->getStringTrimFilterChain());

        $repeatPassword = new Input('repeatPassword');
        $repeatPassword->setRequired(true);
        $repeatPassword->setValidatorChain($this->getRepeatPasswordValidatorChain());
        $repeatPassword->setFilterChain($this->getStringTrimFilterChain());
        
        $nickname = new Input('nickname');
        $nickname->setRequired(true);
        $nickname->setValidatorChain($this->getNicknameValidatorChain());
        $nickname->setFilterChain($this->getStringTrimFilterChain());

        $this->add($firstName);
        $this->add($lastName);
        $this->add($email);
        $this->add($password);
        $this->add($repeatPassword);
        $this->add($nickname);
    }

    /**
     * Gets the validation chain for the first name and last name inputs
     *
     * @return ValidatorChain
     */
    protected function getNameValidatorChain()
    {
        $stringLength = new Validator\StringLength();
        $stringLength->setMin(2);
        $stringLength->setMax(50);

        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new Alnum(true));
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }

    /**
     * Gets the validation chain for the email input
     *
     * @return ValidatorChain
     */
    protected function getEmailValidatorChain()
    {
        $stringLength = new Validator\StringLength();
        $stringLength->setMax(100);

        $emailDoesNotExist = new Validator\Db\NoRecordExists(array(
            'table' => 'user',
            'field' => 'email',
            'adapter' => $this->dbAdapter,
        ));
        $emailDoesNotExist->setMessage('Ya existe un usuario registrado con esta cuenta');

        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength, true);
        $validatorChain->attach(new Validator\EmailAddress(), true);
        $validatorChain->attach($emailDoesNotExist, true);

        return $validatorChain;
    }

    /**
     * Gets the validation chain for the password input
     *
     * @return ValidatorChain
     */
    protected function getPasswordValidatorChain()
    {
        $stringLength = new Validator\StringLength();
        $stringLength->setMin(6);
        $stringLength->setMax(50);
        //$stringLength->setMessage('La contraseña debe ser mayor a 6 caracteres');

        $oneNumber = new Validator\Regex('/\d/');
        $oneNumber->setMessage('La contraseña debe contener al menos un número');

        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength);
        $validatorChain->attach($oneNumber);

        return $validatorChain;
    }

    /**
     * Gets the validation chain for the repeatPassword input
     *
     * @return ValidatorChain
     */
    protected function getRepeatPasswordValidatorChain()
    {
        $identical = new Validator\Identical();
        $identical->setToken('password'); // Name of the input whose value to match
        $identical->setMessage('Las contraseñas deben coincidir');

        $validatorChain = new ValidatorChain();
        $validatorChain->attach($identical);

        return $validatorChain;
    }

    /**
     * @return FilterChain
     */
    protected function getStringTrimFilterChain()
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new StringTrim());

        return $filterChain;
    }
    
    /**
     * Gets the validation chain for the nickname input
     *
     * @return ValidatorChain
     */
    protected function getNicknameValidatorChain()
    {
        $stringLength = new Validator\StringLength();
        $stringLength->setMin(5);
        $stringLength->setMax(50);

        $nicknameDoesNotExist = new Validator\Db\NoRecordExists(array(
            'table' => 'user',
            'field' => 'nickname',
            'adapter' => $this->dbAdapter,
        ));
        $nicknameDoesNotExist->setMessage('Ya existe una cuenta con este nombre de usuario');

        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength, true);
        $validatorChain->attach($nicknameDoesNotExist, true);

        return $validatorChain;
    }
    
            /*
         * 
         * $validator = new Zend\Validator\Db\NoRecordExists(
    array(
        'table' => 'users',
        'field' => 'username',
        'exclude' => array(
            'field' => 'id',
            'value' => $user_id
        )
    )
);
         */

} 
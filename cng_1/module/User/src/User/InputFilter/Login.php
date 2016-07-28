<?php

namespace User\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class Login extends InputFilter
{
    public function __construct()
    {
        $email = new Input('email');
        $email->setRequired(true);
        $email->setValidatorChain($this->getEmailValidatorChain());
        $email->setFilterChain($this->getStringTrimFilterChain());

        $password = new Input('password');
        $password->setRequired(true);
        $password->setFilterChain($this->getStringTrimFilterChain());

        $this->add($email);
        $this->add($password);
    }

    /**
     * Gets the validation chain for the email input
     *
     * @return Validator\ValidatorChain
     */
    protected function getEmailValidatorChain()
    {
        $stringLength = new Validator\StringLength();
        $stringLength->setMax(100);

        $validatorChain = new Validator\ValidatorChain();
        $validatorChain->attach($stringLength, true);
        $validatorChain->attach(new Validator\EmailAddress(), true);

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
} 
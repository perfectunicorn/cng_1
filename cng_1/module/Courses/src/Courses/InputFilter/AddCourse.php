<?php

namespace Courses\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\I18n\Validator\Alnum;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;

class AddCourse extends InputFilter
{
    public function __construct()
    {
        $title = new Input('title');
        $title->setRequired(true);
        $title->setValidatorChain($this->getTitleValidatorChain());
        $title->setFilterChain($this->getStringTrimFilterChain());

        $goal = new Input('goal');
        $goal->setRequired(true);
        $goal->setValidatorChain($this->getGoalValidatorChain());
        $goal->setFilterChain($this->getStringTrimFilterChain());

        $description = new Input('description');
        $description->setRequired(true);
        $description->setValidatorChain($this->getDescriptionValidatorChain());
        $description->setFilterChain($this->getStringTrimFilterChain());

        $this->add($title);
        $this->add($goal);
        $this->add($description);
    }

    /**
     * @return ValidatorChain
     */
    protected function getDescriptionValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(10);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }

    /**
     * @return ValidatorChain
     */
      protected function getGoalValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(10);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }


    /**
     * @return ValidatorChain
     */
    protected function getTitleValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(5);

        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new Alnum(true));
        $validatorChain->attach($stringLength);

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
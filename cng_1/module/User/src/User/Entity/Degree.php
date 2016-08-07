<?php

namespace User\Entity;

class Degree
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    protected $degree;


    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $degree
     */
    public function setName($degree)
    {
        $this->degree = $degree;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->degree;
    }

}
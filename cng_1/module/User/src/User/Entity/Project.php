<?php

namespace User\Entity;

class Project
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    protected $project_name;

    /**
     * @var string
     */
    protected $abstract;

    /**
     * @var string
     */
    protected $webpage;
    
    /**
     * @var string
     */
    protected $project_type;
    
    /**
     * @var date
     */
    protected $start_date;
    
    /**
     * @var date
     */
    protected $end_date;

    /**
     * @var int
     */
    protected $created;

    /**
     * @var \User\Entity\User
     */
    protected $author;



    /**
     * @param string $project_name
     */
    public function setProjectName($project_name)
    {
        $this->project_name = $project_name;
    }

    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param string $webpage
     */
    public function setWebpage($webpage)
    {
        $this->webpage = $webpage;
    }
    /**
     * @return string
     */
    public function getWebpage()
    {
        return $this->webpage;
    }
    
     /**
     * @param string $project_type
     */
    public function setProjectType($project_type)
    {
        $this->project_type = $project_type;
    }

    /**
     * @return string
     */
    public function getProjectType()
    {
        return $this->project_type;
    }
    
     /**
     * @param date $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return date
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
    
      /**
     * @param date $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * @return date
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

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
     * @param int $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \User\Entity\User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \User\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
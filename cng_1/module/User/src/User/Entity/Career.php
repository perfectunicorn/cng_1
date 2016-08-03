<?php

namespace User\Entity;

class Career
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    protected $organization;

    /**
     * @var string
     */
    protected $position;

    /**
     * @var string
     */
    protected $job_description;

    /**
     * @var string
     */
    protected $job_achievement;

    /**
     * @var int
     */
    protected $start_date;
    
     /**
     * @var int
     */
    protected $end_date;

    /**
     * @var \User\Entity\User
     */
    protected $owner;

    /**
     * @var int
     */
    protected $created;


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
     * @param string $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string
     */
    public function setJobDescription($job_description)
    {
        $this->job_description = $job_description;
    }

    /**
     * @return string
     */
    public function getJobDescription()
    {
        return $this->job_description;
    }
    
      /**
     * @param string
     */
    public function setJobAchievement($job_achievement)
    {
        $this->job_achievement = $job_achievement;
    }

    /**
     * @return string
     */
    public function getJobAchievement()
    {
        return $this->job_achievement;
    }
    
    /**
     * @param int $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return int
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
    
     
    /**
     * @param int $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->end_date;
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
     * @param \User\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \User\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
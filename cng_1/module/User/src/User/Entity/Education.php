<?php

namespace User\Entity;

class Education
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
    protected $career;
    

    /**
     * @var string
     */
    protected $academic_specialty;

    /**
     * @var string
     */
    protected $academic_achievement;

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
     * @var \User\Entity\Degree
     */
    protected $degree;

    /**
     * @var \User\Entity\User
     */
    protected $author;



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
     * @param string $career
     */
    public function setCareer($career)
    {
        $this->career = $career;
    }

    /**
     * @return string
     */
    public function getCareer()
    {
        return $this->career;
    }

    /**
     * @param string $academic_specialty
     */
    public function setAcademicSpecialty($academic_specialty)
    {
        $this->academic_specialty = $academic_specialty;
    }

    /**
     * @return string
     */
    public function getAcademicSpecialty()
    {
        return $this->academic_specialty;
    }
    
     /**
     * @param string $academic_achievement
     */
    public function setAcademicAchievement($academic_achievement)
    {
        $this->academic_achievement = $academic_achievement;
    }

    /**
     * @return string
     */
    public function getAcademicAchievement()
    {
        return $this->academic_achievement;
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
     * @param \User\Entity\Degree $degree
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    /**
     * @return \User\Entity\Degree
     */
    public function getDegree()
    {
        return $this->degree;
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
<?php

namespace Courses\Entity;

class Topic
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $created;

    /**
     * @var \Courses\Entity\Category
     */
    protected $category;
    
     /**
     * @var \Courses\Entity\Course
     */
    protected $course;

    /**
     * @var \User\Entity\User
     */
    protected $author;
    

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param \Courses\Entity\Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \Courses\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
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
    
            /**
     * @param \Courses\Entity\Course $course
     */
    public function setCourse(Course $coursetitle)
    {
        $this->course = $coursetitle;
    }

    /**
     * @return \Courses\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}
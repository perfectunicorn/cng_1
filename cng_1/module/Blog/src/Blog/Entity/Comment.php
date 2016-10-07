<?php
//
namespace Blog\Entity;

class Comment
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var int
     */
    protected $created;
    
     /**
     * @var \User\Entity\Post
     */
    protected $post;

    /**
     * @var \User\Entity\User
     */
    protected $author;



    /**
     * @param string $content
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
     * @param \User\Entity\User $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return \User\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
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
<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\Comment;

class BlogServiceImpl implements BlogService
{
    
    protected $postRepository;


    /**
     * Saves a blog post
     *
     * @param Post $post
     * @param int $authorId
     *
     * @return Post
     */
    public function save(Post $post, $authorId)
    {
        $this->postRepository->save($post, $authorId);
    }

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page)
    {
        return $this->postRepository->fetch($page);
    }

    /**
     * @param $categorySlug string
     * @param $postSlug string
     *
     * @return Post|null
     */
    public function find($categorySlug, $postSlug)
    {
        return $this->postRepository->find($categorySlug, $postSlug);
    }

    /**
     * @param $postId int
     *
     * @return Post|null
     */
    public function findById($postId)
    {
        return $this->postRepository->findById($postId);
    }

    /**
     * @param Post $post
     *
     * @return void
     */
    public function update(Post $post)
    {
        $this->postRepository->update($post);
    }

    /**
     * @param $postId int
     *
     * @return void
     */
    public function delete($postId)
    {
        $this->postRepository->delete($postId);
    }
    
    
    /*
     * Comments service
     * 
     */
    
    public function saveComment(Comment $comment, $authorId,$postId)
    {
        $this->postRepository->saveComment($comment, $authorId,$postId);
    }
    
    public function deleteComment($commentId)
    {
        $this->postRepository->deleteComment($commentId);
    }
    
    public function findCommentById($commentId)
    {
        return $this->postRepository->findCommentById($commentId);
    }
    
    public function findCommentsByPost($postId,$page)
    {
        return $this->postRepository->findCommentsByPost($postId,$page);
    }
    

    /**
     * @param \Blog\Repository\PostRepository $postRepository
     */
    public function setBlogRepository($postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return \Blog\Repository\PostRepository
     */
    public function getBlogRepository()
    {
        return $this->postRepository;
    }
}
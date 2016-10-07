<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Entity\Comment;

interface BlogService
{
    
    public function save(Post $post, $authorId);

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page);

    /**
     * @param $categorySlug string
     * @param $postSlug string
     *
     * @return Post|null
     */
    public function find($categorySlug, $postSlug);

    /**
     * @param $postId int
     *
     * @return Post|null
     */
    public function findById($postId);

    /**
     * @param Post $post
     *
     * @return void
     */
    public function update(Post $post);

    /**
     * @param $postId int
     *
     * @return void
     */
    public function delete($postId);
    
    
    /*
     * Comments service
     * 
     */
    
    public function saveComment(Comment $comment, $authorId,$postId);
    
    public function deleteComment($commentId);
    
    public function findCommentById($commentId);
    
    public function findCommentsByPost($postId,$page);
    

} 
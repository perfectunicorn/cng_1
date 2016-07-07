<?php

namespace Blog\Repository;

use Application\Repository\RepositoryInterface;
use Blog\Entity\Post;

interface PostRepository extends RepositoryInterface
{
    /**
     * Saves a blog post
     *
     * @param Post $post
     * @param int $authorId
     *
     * @return void
     */
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
}
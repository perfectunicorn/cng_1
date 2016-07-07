<?php

namespace Blog\Service;

use Blog\Entity\Post;

class BlogServiceImpl implements BlogService
{
    /**
     * @var \Blog\Repository\PostRepository $postRepository
     */
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
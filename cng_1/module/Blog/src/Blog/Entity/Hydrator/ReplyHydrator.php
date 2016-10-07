<?php

namespace Blog\Entity\Hydrator;

use Blog\Entity\Post;
use Blog\Entity\Comment;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ReplyHydrator implements HydratorInterface
{
   
    public function extract($object)
    {
        if (!$object instanceof Comment || $object->getPost() == null) {
            return array();
        }

        $post = $object->getPost();

        return array(
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreated(),
        );
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof Comment || $data['post_id'] == null) {
            return $object;
        }

        $post = new Post();
        $post->setId(isset($data['post_id']) ? intval($data['post_id']) : null);
        $post->setTitle(isset($data['title']) ? $data['title'] : null);
        $post->setSlug(isset($data['slug']) ? $data['slug'] : null);
        $post->setContent(isset($data['content']) ? $data['content'] : null);
        $post->setCreated(isset($data['created']) ? $data['created'] : null);
        $object->setPost($post);

        return $object;
    }
}
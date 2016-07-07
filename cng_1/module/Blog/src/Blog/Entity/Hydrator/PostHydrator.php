<?php

namespace Blog\Entity\Hydrator;

use Blog\Entity\Post;
use Zend\Stdlib\Hydrator\HydratorInterface;

class PostHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     *
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof Post) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'slug' => $object->getSlug(),
            'content' => $object->getContent(),
            'created' => $object->getCreated(),
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
        if (!$object instanceof Post) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setTitle(isset($data['title']) ? $data['title'] : null);
        $object->setSlug(isset($data['slug']) ? $data['slug'] : null);
        $object->setContent(isset($data['content']) ? $data['content'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
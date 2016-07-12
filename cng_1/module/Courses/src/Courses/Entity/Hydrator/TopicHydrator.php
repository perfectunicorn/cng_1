<?php

namespace Courses\Entity\Hydrator;

use Courses\Entity\Topic;
use Zend\Stdlib\Hydrator\HydratorInterface;

class TopicHydrator implements HydratorInterface
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
        if (!$object instanceof Topic) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'topic_title' => $object->getTitle(),
            'topic_slug' => $object->getSlug(),
            'topic_content' => $object->getContent(),
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
        if (!$object instanceof Topic) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setTitle(isset($data['topic_title']) ? $data['topic_title'] : null);
        $object->setSlug(isset($data['topic_slug']) ? $data['topic_slug'] : null);
        $object->setContent(isset($data['topic_content']) ? $data['topic_content'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
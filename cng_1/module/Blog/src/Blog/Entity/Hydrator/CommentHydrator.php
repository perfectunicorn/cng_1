<?php

namespace Blog\Entity\Hydrator;

use Blog\Entity\Comment;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CommentHydrator implements HydratorInterface
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
        if (!$object instanceof Comment) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'comment' => $object->getComment(),
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
        if (!$object instanceof Comment) {
            return $object;
        }
        
        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setComment(isset($data['comment']) ? $data['comment'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
<?php

namespace Blog\Entity\Hydrator;

use Blog\Entity\Post;
use User\Entity\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AuthorHydrator implements HydratorInterface
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
        if (!$object instanceof Post || $object->getAuthor() == null) {
            return array();
        }

        $author = $object->getAuthor();

        return array(
            'id' => $author->getId(),
            'firstName' => $author->getFirstName(),
            'lastName' => $author->getLastName(),
            'email' => $author->getEmail(),
            'created' => $author->getCreated(),
            'userGroup' => $author->getUserGroup(),
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
        if (!$object instanceof Post || $data['author_id'] == null) {
            return $object;
        }

        $author = new User();
        $author->setId(isset($data['author_id']) ? intval($data['author_id']) : null);
        $author->setFirstName(isset($data['author_first_name']) ? $data['author_first_name'] : null);
        $author->setLastName(isset($data['author_last_name']) ? $data['author_last_name'] : null);
        $author->setEmail(isset($data['author_email']) ? $data['author_email'] : null);
        $author->setCreated(isset($data['author_created']) ? $data['author_created'] : null);
        $author->setUserGroup(isset($data['author_user_group']) ? $data['author_user_group'] : null);
        $object->setAuthor($author);

        return $object;
    }
}
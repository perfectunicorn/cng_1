<?php

namespace User\Entity\Hydrator;

use User\Entity\User;
use User\Entity\Uploads;
use User\Entity\Career;
use User\Entity\Education;
use Zend\Stdlib\Hydrator\HydratorInterface;

class OwnerHydrator implements HydratorInterface
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
        if (!$object instanceof Uploads || !$object instanceof Career || !$object instanceof Education || $object->getOwner() == null) {
            return array();
        }

        $owner = $object->getOwner();

        return array(
            'id' => $owner->getId(),
            'firstName' => $owner->getFirstName(),
            'lastName' => $owner->getLastName(),
            'email' => $owner->getEmail(),
            'created' => $owner->getCreated(),
            'userGroup' => $owner->getUserGroup(),
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
        if (!$object instanceof Uploads || !$object instanceof Career || $data['user_id'] == null) {
            return $object;
        }

        $owner = new User();
        $owner->setId(isset($data['user_id']) ? intval($data['user_id']) : null);
        $owner->setFirstName(isset($data['first_name']) ? $data['first_name'] : null);
        $owner->setLastName(isset($data['last_name']) ? $data['last_name'] : null);
        $owner->setEmail(isset($data['email']) ? $data['email'] : null);
        $owner->setCreated(isset($data['created']) ? $data['created'] : null);
        $owner->setUserGroup(isset($data['user_group']) ? $data['user_group'] : null);
        $object->setOwner($owner);

        return $object;
    }
}
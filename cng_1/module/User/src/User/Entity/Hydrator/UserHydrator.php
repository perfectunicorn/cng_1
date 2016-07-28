<?php

namespace User\Entity\Hydrator;

use User\Entity\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserHydrator implements HydratorInterface
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
        if (!$object instanceof User) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
            'email'=>$object->getEmail(),
            'password' => $object->getPassword(),
            'created' => $object->getCreated(),
            'user_group' => $object->getUserGroup(),
            'nickname' => $object->getNickname(),
            'gender' => $object->getGender(),
            'age' => $object->getAge(),
            'bio' => $object->getBio(),
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
        if (!$object instanceof User) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setFirstName(isset($data['first_name']) ? $data['first_name'] : null);
        $object->setLastName(isset($data['last_name']) ? $data['last_name'] : null);
        $object->setEmail(isset($data['email']) ? $data['email'] : null);
        $object->setPassword(isset($data['password']) ? $data['password'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);
        $object->setUserGroup(isset($data['user_group']) ? $data['user_group'] : null);
        $object->setNickname(isset($data['nickname']) ? $data['nickname'] : null);
        $object->setGender(isset($data['gender']) ? $data['gender'] : null);
        $object->setAge(isset($data['age']) ? $data['age'] : null);
        $object->setBio(isset($data['bio']) ? $data['bio'] : null);
        return $object;
    }
}
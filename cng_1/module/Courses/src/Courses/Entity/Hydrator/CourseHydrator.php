<?php

namespace Courses\Entity\Hydrator;

use Courses\Entity\Course;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CourseHydrator implements HydratorInterface
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
        if (!$object instanceof Course) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'goal' => $object->getGoal(),
            'description' => $object->getDescription(),
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
        if (!$object instanceof Course) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setTitle(isset($data['title']) ? $data['title'] : null);
        $object->setGoal(isset($data['goal']) ? $data['goal'] : null);
        $object->setDescription(isset($data['description']) ? $data['description'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
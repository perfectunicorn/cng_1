<?php

namespace User\Entity\Hydrator;

use User\Entity\Career;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CareerHydrator implements HydratorInterface
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
        if (!$object instanceof Career) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'organization' => $object->getOrganization(),
            'position' => $object->getPosition(),
            'job_description' => $object->getJobDescription(),
            'job_achievement' => $object->getJobAchievement(),
            'start_date' => $object->getStartDate(),
            'end_date' => $object->getEndDate(),
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
        if (!$object instanceof Career) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setOrganization(isset($data['organization']) ? $data['organization'] : null);
        $object->setPosition(isset($data['position']) ? $data['position'] : null);
        $object->setJobDescription(isset($data['job_description']) ? $data['job_description'] : null);
        $object->setJobAchievement(isset($data['job_achievement']) ? $data['job_achievement'] : null);
        $object->setStartDate(isset($data['start_date']) ? $data['start_date'] : null);
        $object->setEndDate(isset($data['end_date']) ? $data['end_date'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
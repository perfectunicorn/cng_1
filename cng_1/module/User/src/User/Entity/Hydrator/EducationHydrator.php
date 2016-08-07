<?php

namespace User\Entity\Hydrator;

use User\Entity\Education;
use Zend\Stdlib\Hydrator\HydratorInterface;

class EducationHydrator implements HydratorInterface
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
        if (!$object instanceof Education) {
            return array();
        }

        return array(
            'education_id' => $object->getId(), // OJO
            'organization' => $object->getOrganization(),
            'academic_specialty' => $object->getAcademicSpecialty(),
            'academic_achievement' => $object->getAcademicAchievement(),
            'career' => $object->getCareer(),
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
        if (!$object instanceof Education) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setOrganization(isset($data['organization']) ? $data['organization'] : null);
        $object->setAcademicSpecialty(isset($data['academic_specialty']) ? $data['academic_specialty'] : null);
        $object->setAcademicAchievement(isset($data['academic_achievement']) ? $data['academic_achievement'] : null);
        $object->setCareer(isset($data['career']) ? $data['career'] : null);
        $object->setStartDate(isset($data['start_date']) ? $data['start_date'] : null);
        $object->setEndDate(isset($data['end_date']) ? $data['end_date'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
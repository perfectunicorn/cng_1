<?php

namespace User\Entity\Hydrator;

use User\Entity\Project;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ProjectHydrator implements HydratorInterface
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
        if (!$object instanceof Project) {
            return array();
        }

        return array(
            'project_id' => $object->getId(), // OJO
            'project_name' => $object->getProjectName(),
            'abstract' => $object->getAbstract(),
            'webpage' => $object->getWebpage(),
            'project_type' => $object->getProjectType(),
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
        if (!$object instanceof Project) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setProjectName(isset($data['project_name']) ? $data['project_name'] : null);
        $object->setAbstract(isset($data['abstract']) ? $data['abstract'] : null);
        $object->setWebpage(isset($data['webpage']) ? $data['webpage'] : null);
        $object->setProjectType(isset($data['project_type']) ? $data['project_type'] : null);
        $object->setStartDate(isset($data['start_date']) ? $data['start_date'] : null);
        $object->setEndDate(isset($data['end_date']) ? $data['end_date'] : null);
        $object->setCreated(isset($data['created']) ? $data['created'] : null);

        return $object;
    }
}
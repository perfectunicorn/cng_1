<?php

namespace User\Entity\Hydrator;

use User\Entity\Degree;
use User\Entity\Education;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DegreeHydrator implements HydratorInterface
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
        if (!$object instanceof Education || $object->getDegree() == null) {
            return array();
        }

        $degree = $object->getDegree();

        return array(
            'id' => $degree->getId(),
            'degree' => $degree->getName(),
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

        $degree = new Degree();
        $degree ->setId(isset($data['degree_id']) ? intval($data['degree_id']) : null);
        $degree ->setName(isset($data['degree']) ? $data['degree'] : null);
        $object->setDegree($degree);

        return $object;
    }
} 
<?php

namespace User\Entity\Hydrator;

use User\Entity\Uploads;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UploadsHydrator implements HydratorInterface
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
        if (!$object instanceof Uploads) {
            return array();
        }

        return array(
            'id' => $object->getId(),
            'filename' => $object->getfileName(),
            'label' => $object->getLabel(),
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
        if (!$object instanceof Uploads) {
            return $object;
        }

        $object->setId(isset($data['id']) ? intval($data['id']) : null);
        $object->setfileName(isset($data['filename']) ? $data['filename'] : null);
        $object->setLabel(isset($data['label']) ? $data['label'] : null);

        return $object;
    }
}
<?php

namespace Courses\Entity\Hydrator;

use Courses\Entity\Category;
use Courses\Entity\Course;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CategoryHydrator implements HydratorInterface
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
        if (!$object instanceof Course || $object->getCategory() == null) {
            return array();
        }

        $category = $object->getCategory();

        return array(
            'id' => $category->getId(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
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

        $category = new Category();
        $category->setId(isset($data['category_id']) ? intval($data['category_id']) : null);
        $category->setName(isset($data['name']) ? $data['name'] : null);
        $category->setSlug(isset($data['category_slug']) ? $data['category_slug'] : null);
        $object->setCategory($category);

        return $object;
    }
} 
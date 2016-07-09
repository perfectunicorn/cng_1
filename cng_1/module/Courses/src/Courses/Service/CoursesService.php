<?php

namespace Courses\Service;

use Courses\Entity\Course;

interface CoursesService
{
    /**
     * Saves a course
     *
     * @param Course $course
     * @param int $authorId
     *
     * @return Course
     */
    public function save(Course $course, $authorId);

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page);

    /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
    public function find($categorySlug, $courseSlug);

    /**
     * @param $courseId int
     *
     * @return Post|null
     */
    public function findById($courseId);

    /**
     * @param Course $course
     *
     * @return void
     */
    public function update(Course $course);

    /**
     * @param $courseId int
     *
     * @return void
     */
    public function delete($courseId);
} 
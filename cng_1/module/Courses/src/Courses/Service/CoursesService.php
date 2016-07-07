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
     * @param $title string
     *
     * @return Course|null
     */
    public function find($categorySlug, $title);

    /**
     * @param $courseId int
     *
     * @return Course|null
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
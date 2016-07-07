<?php

namespace Courses\Service;

use Courses\Entity\Course;

class CoursesServiceImpl implements CoursesService
{
    /**
     * @var \Courses\Repository\CourseRepository $courseRepository
     */
    protected $courseRepository;


    /**
     * Saves a course
     *
     * @param Course $course
     * @param int $authorId
     *
     * @return Course
     */
    public function save(Course $course, $authorId)
    {
        $this->courseRepository->save($course, $authorId);
    }

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page)
    {
        return $this->courseRepository->fetch($page);
    }

    /**
     * @param $categorySlug string
     * @param $title string
     *
     * @return Course|null
     */
    public function find($categorySlug, $title)
    {
        return $this->courseRepository->find($categorySlug, $title);
    }

    /**
     * @param $courseId int
     *
     * @return Course|null
     */
    public function findById($courseId)
    {
        return $this->courseRepository->findById($courseId);
    }

    /**
     * @param Course $course
     *
     * @return void
     */
    public function update(Course $course)
    {
        $this->courseRepository->update($course);
    }

    /**
     * @param $courseId int
     *
     * @return void
     */
    public function delete($courseId)
    {
        $this->courseRepository->delete($courseId);
    }

    /**
     * @param \Courses\Repository\CourseRepository $courseRepository
     */
    public function setCoursesRepository($courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @return \Courses\Repository\CourseRepository
     */
    public function getCoursesRepository()
    {
        return $this->courseRepository;
    }
}
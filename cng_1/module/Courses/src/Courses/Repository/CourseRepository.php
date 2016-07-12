<?php

namespace Courses\Repository;

use Application\Repository\RepositoryInterface;
use Courses\Entity\Course;
use Courses\Entity\Topic;

interface CourseRepository extends RepositoryInterface
{
    /**
     * Saves a course
     *
     * @param Course $course
     * @param int $authorId
     *
     * @return void
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
    
    /*
     * Topic's actions
     * 
     */
    
    /**
     * Saves a topic
     *
     * @param Topic $topic
     * @param int $authorId
     *
     * @return void
     */
    public function saveTopic(Topic $topic, $authorId,$userId);
    
      /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
    public function findTopic($topicSlug);
    
       /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetchTopics();

     public function fetchTopicsByCourse($courseId,$page);
     
     public function findTopicById($topicId);

    /**
     * @param Course $course
     *
     * @return void
     */
    public function updateTopic(Topic $topic);

    /**
     * @param $courseId int
     *
     * @return void
     */
    public function deleteTopic($topicId);
    


}
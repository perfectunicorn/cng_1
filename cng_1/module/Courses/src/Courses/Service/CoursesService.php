<?php

namespace Courses\Service;

use Courses\Entity\Course;
use Courses\Entity\Topic;

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
     * @param $userId int
     *
     * @return Post|null
     */
    public function findByUser($userId);

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
     * Topics actions
     * 
     */
    
    /**
     * Saves a topic
     *
     * @param Topic $topic
     * @param int $authorId
     *
     * @return Topic
     */
    public function saveTopic(Topic $topic, $authorId,$courseId);
    
    /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
   
    
      /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetchTopics();
    
    public function fetchTopicsByCourse($courseId,$page);
    
     /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
     public function findTopic($topicSlug);

    /**
     * @param $courseId int
     *
     * @return Post|null
     */
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
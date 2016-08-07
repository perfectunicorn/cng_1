<?php

namespace Courses\Repository;

use Courses\Entity\Hydrator\AuthorHydrator;
use Courses\Entity\Hydrator\UserHydrator;
use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Courses\Entity\Hydrator\TopicHydrator;
use Courses\Entity\Course;
use Courses\Entity\Topic;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class CourseRepositoryImpl implements CourseRepository
{
    use AdapterAwareTrait;
 

    public function save(Course $course, $authorId)
    {
          
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'title' => $course->getTitle(),
                'slug' => $course->getSlug(),
                'content' => $course->getContent(),
                'category_id' => $course->getCategory()->getId(),
                'created' => time(),
                'author_id' => $authorId,
            ))
            ->into('course');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    public function fetch($page)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'title',
                'slug',
                'content',
                'created',
            ))
            ->from(array('p' => 'course'))
            ->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->order('p.id DESC');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Course());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(1);

        return $paginator;
    }

    /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
    public function find($categorySlug, $courseSlug)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'title',
                'slug',
                'content',
                'created',
            ))
            ->from(array('p' => 'course'))
            ->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'c.slug' => $categorySlug,
                'p.slug' => $courseSlug,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Course());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    /**
     * @param $courseId int
     *
     * @return Course|null
     */
    public function findById($courseId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'title',
            'slug',
            'content',
            'created',
        ))
            ->from(array('p' => 'course'))
            ->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $courseId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Course());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }
    
    /**
     * @param $userId int
     *
     * @return Course|null
     */
    public function findByUser($userId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'title',
            'slug',
            'content',
            'created',
        ))
            ->from(array('p' => 'course'))
            ->join(
                array('c' => 'category'), // Table name
                'c.id = p.category_id', // Condition
                array('category_id' => 'id', 'name', 'category_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.author_id' => $userId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Course());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->toArray() : null);
    }

    /**
     * @param Course $course
     *
     * @return void
     */
    public function update(Course $course)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('course')
            ->set(array(
                'title' => $course->getTitle(),
                'slug' => $course->getSlug(),
                'content' => $course->getContent(),
                'category_id' => $course->getCategory()->getId(),
            ))
            ->where(array(
                'id' => $course->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    /**
     * @param $courseId int
     *
     * @return void
     */
    public function delete($courseId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $delete = $sql->delete()
            ->from('course')
            ->where(array(
                'id' => $courseId,
            ));

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
    }
    
    /*
     * Topic's actions
     * 
     */
    
    public function saveTopic(Topic $topic, $authorId,$courseId)
    {
        var_dump($topic);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'title' => $topic->getTitle(),
                'slug' => $topic->getSlug(),
                'content' => $topic->getContent(),
                //'category_id' => $topic->getCategory()->getId(),
                'created' => time(),
                'author_id' => $authorId,
                'course_id' => $courseId,
            ))
            ->into('topic');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    /**
     * @param $categorySlug string
     * @param $courseSlug string
     *
     * @return Course|null
     */
    public function findTopic($topicSlug)
    {
     $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'topic_title'=>'title',
                'topic_slug'=>'slug',
                'topic_content'=>'content',
                'created',
            ))
            ->from(array('p' => 'topic'))
            ->join(
                array('c' => 'course'), // Table name
                'c.id = p.course_id', // Condition
                array('course_id' => 'id','course_title'=>'title', 'course_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.slug' => $topicSlug,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new UserHydrator());
         $hydrator->add(new TopicHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Topic());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }
    
     public function fetchTopics()
    {
        
    }

    public function fetchTopicsByCourse($courseId,$page)
        {
             $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'topic_title'=>'title',
            'topic_slug'=>'slug',
            'topic_content'=>'content',
            'created',
        ))
            ->from(array('p' => 'topic'))
            ->join(
                array('c' => 'course'), // Table name
                'c.id = p.course_id', // Condition
                array('course_id' => 'id', 
                      'course_title'=>'title',
                      'course_slug'=>'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.course_id' => $courseId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new TopicHydrator());
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new UserHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Topic());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(120);

        return $paginator;
        }

        public function findTopicById($topicId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'topic_title'=>'title',
            'topic_slug'=>'slug',
            'topic_content'=>'content',
            'created',
        ))
            ->from(array('p' => 'topic'))
            ->join(
                array('c' => 'course'), // Table name
                'c.id = p.course_id', // Condition
                array('course_id' => 'id', 'course_title'=>'title', 'course_slug' => 'slug'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('a' => 'user'),
                'a.id = p.author_id',
                array(
                    'author_id' => 'id',
                    'author_first_name' => 'first_name',
                    'author_last_name' => 'last_name',
                    'author_email' => 'email',
                    'author_created' => 'created',
                    'author_user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $topicId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new TopicHydrator());
        $hydrator->add(new UserHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Topic());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    /**
     * @param Course $course
     *
     * @return void
     */
    public function updateTopic(Topic $topic)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('topic')
            ->set(array(
                'title' => $topic->getTitle(),
                'slug' => $topic->getSlug(),
                'content' => $topic->getContent(),
                //'course_id' => $topic->getCourse()->getId(),
            ))
            ->where(array(
                'id' => $topic->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    /**
     * @param $courseId int
     *
     * @return void
     */
    public function deleteTopic($topicId)
    {
        var_dump($topicId);
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $delete = $sql->delete()
            ->from('topic')
            ->where(array(
                'id' => $topicId,
            ));

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
    }
    
}
<?php

namespace Courses\Repository;

use Courses\Entity\Hydrator\AuthorHydrator;
use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Courses\Entity\Course;
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
                'goal' => $course->getGoal(),
                'description' => $course->getDescription(),
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
                'goal',
                'description',
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
        $paginator->setItemCountPerPage(5);

        return $paginator;
    }

    /**
     * @param $categorySlug string
     * @param $title string
     *
     * @return Course|null
     */
    public function find($categorySlug, $title)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'title',
                'goal',
                'description',
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
                'p.title' => $title,
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
            'goal',
            'description',
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
                'goal' => $course->getGoal(),
                'description' => $course->getDescription(),
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
}
<?php

namespace Blog\Repository;

use Blog\Entity\Hydrator\AuthorHydrator;
use Blog\Entity\Hydrator\CategoryHydrator;
use Blog\Entity\Hydrator\PostHydrator;
use Blog\Entity\Post;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class PostRepositoryImpl implements PostRepository
{
    use AdapterAwareTrait;

    public function save(Post $post, $authorId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'title' => $post->getTitle(),
                'slug' => $post->getSlug(),
                'content' => $post->getContent(),
                'category_id' => $post->getCategory()->getId(),
                'created' => time(),
                'author_id' => $authorId,
            ))
            ->into('post');

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
            ->from(array('p' => 'post'))
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
        $hydrator->add(new PostHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Post());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);

        return $paginator;
    }

    /**
     * @param $categorySlug string
     * @param $postSlug string
     *
     * @return Post|null
     */
    public function find($categorySlug, $postSlug)
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
            ->from(array('p' => 'post'))
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
                'p.slug' => $postSlug,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new PostHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Post());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    /**
     * @param $postId int
     *
     * @return Post|null
     */
    public function findById($postId)
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
            ->from(array('p' => 'post'))
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
                'p.id' => $postId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new PostHydrator());
        $hydrator->add(new CategoryHydrator());
        $hydrator->add(new AuthorHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Post());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    /**
     * @param Post $post
     *
     * @return void
     */
    public function update(Post $post)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('post')
            ->set(array(
                'title' => $post->getTitle(),
                'slug' => $post->getSlug(),
                'content' => $post->getContent(),
                'category_id' => $post->getCategory()->getId(),
            ))
            ->where(array(
                'id' => $post->getId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    /**
     * @param $postId int
     *
     * @return void
     */
    public function delete($postId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $delete = $sql->delete()
            ->from('post')
            ->where(array(
                'id' => $postId,
            ));

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
    }
}
<?php

namespace User\Repository;

use User\Entity\Hydrator\OwnerHydrator;
use User\Entity\Hydrator\UserHydrator;
use User\Entity\Hydrator\UploadsHydrator;
use User\Entity\Uploads;
use User\Entity\User;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class UploadsRepositoryImpl implements UploadsRepository
{
    use AdapterAwareTrait;
    
  /*CREATE TABLE IF NOT EXISTS uploads (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  filename VARCHAR( 255 ) NOT NULL ,
  label VARCHAR( 255 ) NOT NULL ,
  user_id INT NOT NULL,
  UNIQUE KEY (filename)
);*/
 
    public function saveUpload(Uploads $file,$ownerId)
    {
          
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'filename' => $file->getfileName(),
                'label' => $file->getLabel(),
                'user_id' => $ownerId,
            ))
            ->into('uploads');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }
    
    public function fetchAll($page)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'id',
                'filename',
                'label',
            ))
            ->from(array('p' => 'uploads'))
            ->join(
                array('a' => 'user'),
                'a.id = p.user_id',
                array(
                    'user_id' => 'id',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'email' => 'email',
                    'created' => 'created',
                    'user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->order('p.id DESC');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new OwnerHydrator());
        $hydrator->add(new UploadsHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Uploads());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return $paginator;
    }
    
    public function getUpload();
    
    public function deleteUpload($fileId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $delete = $sql->delete()
            ->from('uploads')
            ->where(array(
                'id' => $fileId,
            ));

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();   
    }
    
    public function getUploadsByUserId($ownerId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'filename',
            'label',
        ))
            ->from(array('p' => 'uploads'))
            ->join(
                array('a' => 'user'),
                'a.id = p.user_id',
                array(
                    'user_id' => 'id',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'email' => 'email',
                    'created' => 'created',
                    'user_group' => 'user_group',
                ),
                $select::JOIN_LEFT
            )
            ->where(array(
                'p.id' => $ownerId,
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new OwnerHydrator());
        $hydrator->add(new UploadsHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Uploads());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }


    
}
<?php

namespace User\Repository;

use Application\Repository\RepositoryInterface;
use Courses\Entity\Uploads;

interface UploadsRepository extends RepositoryInterface
{
   
    public function saveUpload(Uploads $file,$ownerId);
    
    public function fetchAll($page);
    
    public function getUpload();
    
    public function deleteUpload($fileId);
    
    public function getUploadsByUserId($ownerId);


}
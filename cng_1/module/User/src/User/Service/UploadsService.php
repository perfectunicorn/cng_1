<?php

namespace User\Service;

use User\Entity\Uploads;

interface UploadsService
{
    
    public function saveUpload(Uploads $file,$ownerId);
    
    public function fetchAll($page);
    
    public function getUpload();
    
    public function deleteUpload($fileId);
    
    public function getUploadsByUserId($ownerId);
    
    public function getFileUploadLocation();
}
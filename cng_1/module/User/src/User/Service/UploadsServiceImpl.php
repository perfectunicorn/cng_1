<?php

namespace User\Service;

use User\Entity\Uploads;

class UploadsServiceImpl implements UploadsService
{
   
    protected $uploadsRepository;


    public function saveUpload(Uploads $file, $ownerId)
    {
        $this->uploadsRepository->saveUpload($file, $ownerId);
    }

   
    public function fetchAll($page)
    {
        return $this->uploadsRepository->fetchAll($page);
    }

 
    public function getUpload()
    {
        return $this->uploadsRepository->getUpload();
    }

  
    public function deleteUpload($fileId)
    {
        return $this->uploadsRepository->deleteUpload($fileId);
    }

  
    public function getUploadsByUserId($ownerId)
    {
        $this->uploadsRepository->getUploadsByUserId($ownerId);
    }
    
    public function getFileUploadLocation()
        {
          // Fetch Configuration from Module Config
          $config  = $this->getServiceLocator()->get('config');
          return $config['module_config']['upload_location'];
        }

}
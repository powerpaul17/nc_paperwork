<?php

namespace OCA\Paperwork\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Paperwork\Db\DocumentLabel;
use OCA\Paperwork\Db\DocumentLabelMapper;

class DocumentLabelService {

  private $mapper;

  public function __construct(DocumentLabelMapper $mapper) {
    $this->mapper = $mapper;
  }

  public function findAll($userId) {
    return $this->mapper->findAll($userId);
  }

  private function handleException($e) {
    if ($e instanceof DoesNotExistException ||
        $e instanceof MultipleObjectsReturnedException) {
          throw new NotFoundException($e->getMessage());
    } else {
      throw $e;
    }
  }

  public function find($id, $userId) {
    try {
      return $this->mapper->find($id, $userId);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  public function create($documentId, $labelId, $userId) {
    $documentLabel = new DocumentLabel();
    $documentLabel->setDocumentId($documentId);
    $documentLabel->setLabelId($labelId);
    $documentLabel->setUserId($userId);
    return $this->mapper->insert($documentLabel);
  }

  public function update($id, $documentId, $labelId, $userId) {
    try {
      $documentLabel = $this->mapper->find($id, $userId);
      $documentLabel->setDocumentId($documentId);
      $documentLabel->setLabelId($labelId);
      return $this->mapper->update($documentLabel);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  public function delete($id, $userId) {
    try {
      $documentLabel = $this->mapper->find($id, $userId);
      $this->mapper->delete($documentLabel);
      return $documentLabel;
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

}

?>

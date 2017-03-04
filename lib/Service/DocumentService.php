<?php

namespace OCA\Paperwork\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Paperwork\Db\Document;
use OCA\Paperwork\Db\DocumentMapper;

class DocumentService {

  private $mapper;

  public function __construct(DocumentMapper $mapper) {
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

  public function create($date, $description, $userId) {
    $document = new Document();
    $document->setDate($date);
    $document->setTimestampAdded(date('Y-m-d H:i:s'));
    $document->setDescription($description);
    $document->setUserId($userId);
    return $this->mapper->insert($document);
  }

  public function update($id, $date, $description, $userId) {
    try {
      $document = $this->mapper->find($id, $userId);
      $document->setDate($date);
      $document->setDescription($description);
      return $this->mapper->update($document);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  public function delete($id, $userId) {
    try {
      $document = $this->mapper->find($id, $userId);
      $this->mapper->delete($document);
      return $document;
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

}

?>

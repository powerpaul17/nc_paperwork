<?php

namespace OCA\Paperwork\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Paperwork\Db\Label;
use OCA\Paperwork\Db\LabelMapper;

class LabelService {

  private $mapper;

  public function __construct(LabelMapper $mapper) {
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

  public function findLabelsOfDocument($documentId, $userId) {
    try {
      return $this->mapper->findLabelsOfDocument($documentId, $userId);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  public function create($label, $description, $userId) {
    $label = new Label();
    $label->setLabel($label);
    $label->setDescription($description);
    $label->setUserId($userId);
    return $this->mapper->insert($label);
  }

  public function update($id, $label, $description, $userId) {
    try {
      $label = $this->mapper->find($id, $userId);
      $label->setLabel($label);
      $label->setDescription($description);
      return $this->mapper->update($label);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

  public function delete($id, $userId) {
    try {
      $label = $this->mapper->find($id, $userId);
      $this->mapper->delete($label);
      return $label;
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }

}

?>

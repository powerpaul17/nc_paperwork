<?php

namespace OCA\Paperwork\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class DocumentLabelMapper extends Mapper {

  public function __construct(IDb $db) {
    parent::__construct($db, 'paperwork_document_labels', '\OCA\Paperwork\Db\DocumentLabel');
  }

  public function find($id, $userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_document_labels WHERE id = ? AND user_id = ?';
    return $this->findEntity($sql, [$id, $userId]);
  }

  public function findAll($userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_document_labels WHERE user_id = ?';
    return $this->findEntities($sql, [$userId]);
  }

}

?>

<?php

namespace OCA\Paperwork\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class DocumentMapper extends Mapper {

  public function __construct(IDb $db) {
    parent::__construct($db, 'paperwork_documents', '\OCA\Paperwork\Db\Document');
  }

  public function find($id, $userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_documents WHERE id = ? AND user_id = ?';
    return $this->findEntity($sql, [$id, $userId]);
  }

  public function findAll($userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_documents WHERE user_id = ?';
    return $this->findEntities($sql, [$userId]);
  }

}

?>

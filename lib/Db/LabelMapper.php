<?php

namespace OCA\Paperwork\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class LabelMapper extends Mapper {

  public function __construct(IDb $db) {
    parent::__construct($db, 'paperwork_labels', '\OCA\Paperwork\Db\Label');
  }

  public function find($id, $userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_labels WHERE id = ? AND user_id = ?';
    return $this->findEntity($sql, [$id, $userId]);
  }

  public function findAll($userId) {
    $sql = 'SELECT * FROM *PREFIX*paperwork_labels WHERE user_id = ?';
    return $this->findEntities($sql, [$userId]);
  }

  public function findLabelsOfDocument($documentId, $userId) {
    $sql = 'SELECT labels.* ' .
           'FROM *PREFIX*paperwork_document_labels doclabels ' .
           'LEFT JOIN *PREFIX*paperwork_documents documents ON doclabels.document_id = documents.id ' .
           'LEFT JOIN *PREFIX*paperwork_labels labels ON doclabels.label_id = labels.id ' .
           'WHERE doclabels.document_id = ? ' .
           'AND doclabels.user_id = ?';
    return $this->findEntities($sql, [$documentId, $userId]);
  }

}

?>

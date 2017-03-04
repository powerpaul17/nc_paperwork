<?php

namespace OCA\Paperwork\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class DocumentLabel extends Entity implements JsonSerializable {

  protected $documentId;
  protected $labelId;
  protected $userId;

  public function __construct() {

  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'document_id' => $this->documentId,
      'label_id' => $this->labelId,
      'user_id' => $this->userId
    ];
  }

}

?>

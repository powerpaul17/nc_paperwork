<?php

namespace OCA\Paperwork\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Label extends Entity implements JsonSerializable {

  protected $label;
  protected $description;
  protected $userId;

  public function __construct() {

  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'label' => $this->label,
      'description' => $this->description,
      'user_id' => $this->userId
    ];
  }

}

?>

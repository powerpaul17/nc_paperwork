<?php

namespace OCA\Paperwork\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Document extends Entity implements JsonSerializable {

  protected $date;
  protected $timestampAdded;
  protected $description;
  protected $userId;

  public function __construct() {

  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'date' => $this->date,
      'timestampAdded' => $this->timestampAdded,
      'description' => $this->description,
      'user_id' => $this->userId
    ];
  }

}

?>

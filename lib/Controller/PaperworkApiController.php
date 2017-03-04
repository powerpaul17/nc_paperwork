<?php

namespace OCA\Paperwork\Controller;

use OCP\IRequest;
use OCP\IDBConnection;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\ApiController;

use OCA\Paperwork\Service\DocumentService;
use OCA\Paperwork\Service\LabelService;
use OCA\Paperwork\Service\DocumentLabelService;

class PaperworkApiController extends ApiController {

  private $userId;

  private $db;

  private $documentService;
  private $labelService;
  private $documentLabelService;

  public function __construct($AppName,
                              IRequest $request,
                              IDBConnection $db,
                              DocumentService $documentService,
                              LabelService $labelService,
                              DocumentLabelService $documentLabelService,
                              $UserId) {
    parent::__construct($AppName, $request);
    $this->db = $db;
    $this->userId = $UserId;
    $this->documentService = $documentService;
    $this->labelService = $labelService;
    $this->documentLabelService = $documentLabelService;
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  */
  public function getDocuments() {
    $documents = $this->documentService->findAll($this->userId);

    $result = [];

    foreach($documents as &$document) {
      $number = array_push($result, $document->jsonSerialize());
      $result[$number-1]['labels'] = $this->getLabelsOfDocument($document->id);
    }
    unset($document);

    return $result;
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  */
  public function getDocument($id) {
    $document = $this->documentService->find($id, $this->userId);

    $result = $document->jsonSerialize();
    $result['labels'] = $this->getLabelsOfDocument($id);

    return $result;
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  * @param string $description
  */
  public function updateDocument($id, $date, $description) {
    $this->documentService->update($id, $date, $description, $this->userId);
    return $this->getDocument($id);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param string $description
  */
  public function addDocument($date, $description) {
    $response = $this->documentService->create($date, $description, $this->userId);
    return $this->getDocument($response->id);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  */
  public function deleteDocument($id) {
    return $this->handleNotFound(function() use ($id) {
      return $this->documentService->delete($id, $this->userId);
    });
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $documentId
  */
  public function getLabelsOfDocument($documentId) {
    return $this->labelService->findLabelsOfDocument($documentId, $this->userId);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  */
  public function getLabels() {
    return $this->labelService->findAll($this->userId);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  */
  public function getLabel($id) {
    return $this->labelService->find($id, $this->userId);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  * @param string $label
  * @param string $description
  */
  public function updateLabel($id, $label, $description) {
    $this->labelService->update($id, $label, $description, $this->userId);
    return $this->getLabel($id);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  * @param string $label
  * @param string $description
  */
  public function addLabel($label, $description) {
    $response = $this->labelService->create($label, $description, $this->userId);
    return $this->getLabel($response->id);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $id
  */
  public function deleteLabel($id) {
    return $this->handleNotFound(function() use ($id) {
      // TODO: remove non-existing labels from documents?
      return $this->labelService->delete($id, $this->userId);
    });
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $documentId
  * @param int $labelId
  */
  public function addLabelToDocument($documentId, $labelId) {
    $this->documentLabelService->create($documentId, $labelId, $this->userId);
    return $this->getDocument($documentId);
  }

  /**
  * @NoCSRFRequired
  * @NoAdminRequired
  *
  * @param int $documentId
  * @param int $labelId
  */
  public function removeLabelFromDocument($documentId, $labelId) {
    $labels = $this->getLabelsOfDocument($documentId);
    // TODO

    return $this->getDocument($documentId);
  }

}

?>

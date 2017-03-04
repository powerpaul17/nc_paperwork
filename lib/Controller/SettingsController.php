<?php

namespace OCA\Paperwork\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\IRequest;

class SettingsController extends Controller {

  private $config;
  private $userSession;
  private $userId;

  public function __construct($AppName, IRequest $request, IUserSession $userSession, IConfig $config) {
    parent::__construct($AppName, $request);
    $this->config = $config;
    $this->userSession = $userSession;
    $this->userId = $userSession->getUser()->getUID();
  }

  /**
  * @NoAdminRequired
  *
  * @param string $key
  */
  public function getConfig($key) {
    switch ($key) {
      case 'documentPath':
        return $this->getDocumentPath();
      default:
        return new JSONResponse([], Http:STATUS_BAD_REQUEST);
    }
  }

  /**
  * @NoAdminRequired
  *
  * @param string $key
  * @param mixed $value
  */
  public function setConfig($key, $value) {
    switch ($key) {
      case 'documentPath':
        return $this->setDocumentPath($value);
      default:
        return new JSONResponse([], Http:STATUS_BAD_REQUEST);
    }
  }

  /**
  * @param string $currency
  */
  private function setDocumentPath($documentPath) {
    try {
      $this->config->setUserValue($this->userId, $this->appName, 'documentPath', $documentPath);
    } catch (\Exception $e) {
      return new JSONResponse([], Http::STATUS_INTERNAL_SERVER_ERROR);
    }
    return new JSONResponse();
  }

  private function getDocumentPath() {
    try {
      $documentPath = $this->config->getUserValue($this->userId, $this->appName, 'documentPath');
    } catch (\Exception $e) {
      return new JSONResponse([], Http::STATUS_INTERNAL_SERVER_ERROR);
    }
    return new JSONResponse([
      'value' => $documentPath
    ]);
  }

}

?>

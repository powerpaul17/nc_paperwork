<?php

namespace OCA\Paperwork\AppInfo

use \OCP\AppFramework\App;

use \OCA\Paperwork\Controller\PageController;
use \OCA\Paperwork\Controller\SettingsController;
use \OCA\Paperwork\Controller\PaperworkApiController;

use \OCA\Paperwork\Service\DocumentService;

use \OCA\Paperwork\Db\DocumentMapper;

class Application extends App {

  public function __construct(array $urlParams=array()) {
    parent::__construct('paperwork', $urlParams);

    $container =$this->getContainer();

    // Settings

    $container->registerService('Config', function($c) {
      return $c->query('ServerContainer')->getConfig();
    });

    // Controllers

    $container->registerService('PageController', function($c) {
      return new PageController(
        $c->query('AppName'),
        $c->query('Request')
      );
    });

    $container->registerService('SettingsController', function($c) {
      return new SettingsController(
        $c->query('AppName'),
        $c->query('Request'),
        $c->getServer()->getConfig(),
        $c->getServer()->getUserSession()
      );
    });

    $container->registerService('PaperworkApiController', function($c) {
      return new PaperworkApiController(
        $c->query('AppName'),
        $c->query('Request'),
        $c->query('Db'),
        $c->query('DocumentService')
      );
    });

    // Services

    $container->registerService('DocumentService', function($c) {
      return new DocumentService(
        $c->query('DocumentMapper')
      );
    });

    // Mappers

    $container->registerService('DocumentMapper', function($c) {
      return new DocumentMapper(
        $c->query('ServerContainer')->getDb()
      );
    });

  }

}

?>

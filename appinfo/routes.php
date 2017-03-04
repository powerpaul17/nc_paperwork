<?php
/**
 * Nextcloud - paperwork
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Paul Tirk <paultirk@paultirk.com>
 * @copyright Paul Tirk 2016
 */

return [
  'routes' => [
	   ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],

     ['name' => 'settings#get_config', 'url' => '/config', 'verb' => 'GET'],
     ['name' => 'settings#set_config', 'url' => '/config', 'verb' => 'POST'],

     ['name' => 'paperwork_api#get_documents', 'url' => '/ajax/get-documents', 'verb' => 'GET'],
     ['name' => 'paperwork_api#get_document', 'url' => '/ajax/get-document', 'verb' => 'GET'],
     ['name' => 'paperwork_api#update_document', 'url' => '/ajax/update-document', 'verb' => 'PUT'],
     ['name' => 'paperwork_api#add_document', 'url' => '/ajax/add-document', 'verb' => 'POST'],
     ['name' => 'paperwork_api#delete_document', 'url' => '/ajax/delete-document', 'verb' => 'POST'],
     ['name' => 'paperwork_api#get_labels_of_document', 'url' => '/ajax/get-labels-of-document', 'verb' => 'GET'],

     ['name' => 'paperwork_api#get_labels', 'url' => '/ajax/get-labels', 'verb' => 'GET'],
     ['name' => 'paperwork_api#get_label', 'url' => '/ajax/get-label', 'verb' => 'GET'],
     ['name' => 'paperwork_api#update_label', 'url' => '/ajax/update-label', 'verb' => 'PUT'],
     ['name' => 'paperwork_api#add_label', 'url' => '/ajax/add-label', 'verb' => 'POST'],
     ['name' => 'paperwork_api#delete_label', 'url' => '/ajax/delete-label', 'verb' => 'POST'],
     ['name' => 'paperwork_api#add_label_to_document', 'url' => '/ajax/add-label-to-document', 'verb' => 'POST'],
     ['name' => 'paperwork_api#remove_label_from_document', 'url' => '/ajax/remove-label-from-document', 'verb' => 'POST']
  ]
];

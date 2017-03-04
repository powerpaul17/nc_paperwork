/**
 * ownCloud - paperwork
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Paul Tirk <paultirk@paultirk.com>
 * @copyright Paul Tirk 2016
 */

angular.module('paperworkApp', ['uuid4', 'angular-cache', 'ngRoute', 'ui.bootstrap', 'ui.select', 'ngSanitize', 'ngclipboard'])
.config(function($routeProvider) {

	$routeProvider.when('/:label', {
		template: '<document-details></document-details>'
	});

	$routeProvider.when('/:label/:documentId', {
		template: '<document-details></document-details>'
	});

	$routeProvider.otherwise('/' + t('paperwork', 'All papers'));

});

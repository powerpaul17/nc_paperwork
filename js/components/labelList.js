angular.module('paperworkApp')
.controller('labelListCtrl', function($scope, DocumentService, SearchService, $routeParams) {
	var ctrl = this;

	var initialGroups = [t('paperwork', 'All documents'), t('paperwork', 'Not labeled')];

	ctrl.labels = initialLabels;

	DocumentService.getLabels().then(function(labels) {
		ctrl.labels = _.unique(initialLabels.concat(labels));
	});

	ctrl.getSelected = function() {
		return $routeParams.gid;
	};

	// Update labelList on document add/delete/update
	ContactService.registerObserverCallback(function() {
		$scope.$apply(function() {
			DocumentService.getLabels().then(function(labels) {
				ctrl.labels = _.unique(initialLabels.concat(labels));
			});
		});
	});

	ctrl.setSelected = function (selectedLabel) {
		SearchService.cleanSearch();
		$routeParams.gid = selectedLabel;
	};
});

angular.module('paperworkApp')
.directive('labelList', function() {
	return {
		restrict: 'EA', // has to be an attribute to work with core css
		scope: {},
		controller: 'labelListCtrl',
		controllerAs: 'ctrl',
		bindToController: {},
		templateUrl: OC.linkTo('paperwork', 'templates/labelList.html')
	};
});

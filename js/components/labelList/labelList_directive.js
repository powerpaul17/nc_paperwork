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

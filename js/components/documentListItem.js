angular.module('paperworkApp')
.controller('documentListItemCtrl', function($route, $routeParams) {
  var ctrl = this;

  ctrl.openDocument = function() {
    $route.updateParams({
      'label': $routeParams.label,
      'documentId': ctrl.document.id
    });
  };

});

angular.module('paperworkApp')
.directive('documentListItem', function() {
  return {
    scope: {},
    controller: 'documentListItemCtrl',
    controllerAs: 'ctrl',
    bindToController: {
      document: '=data'
    },
    templateUrl: OC.linkTo('paperwork', 'templates/documentListItem.html')
  };
});

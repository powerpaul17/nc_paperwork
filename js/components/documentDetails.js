angular.module('paperworkApp')
.controller('documentDetailsCtrl', function($route, $routeParams, $scope, DocumentService) {
  var ctrl = this;

  ctrl.document = undefined;

  ctrl.show = false;
  ctrl.showActionsPanel = false;

  // ctrl.availableCurrencies = [];

  ctrl.t = {
    deleteAccount: t('money', 'Delete account'),
    exportAccount: t('money', 'Export account'),
    importTransactions: t('money', 'Import transactions'),
    noDocument: t('paperwork', 'No document opened.'),
    placeholderName: t('money', 'Name'),
    placeholderCurrency: t('money', 'Currency'),
    placeholderDescription: t('money', 'Description'),
    download: t('money', 'Download'),
    delete: t('money', 'Delete'),
    newCurrency: t('money', 'New currency'),
  };

  // AccountService.getCurrencies().then(function(currencies) {
  //   ctrl.availableCurrencies = currencies;
  // });

  ctrl.closeDocument = function() {
    $route.updateParams({
      'label': $routeParams.label,
      'documentId': undefined
    });
    ctrl.show = false;
    ctrl.document = undefined;
  }

  ctrl.documentId = $routeParams.documentId;

  $scope.$watch('ctrl.documentId', function(newValue) {
    ctrl.changeDocument(newValue);
  });
  //
  ctrl.changeDocument = function(documentId) {
    if (typeof documentId === 'undefined') {
      ctrl.show = false;
      $('#app-navigation-toggle').removeClass('showdetails');
      return;
    } else {
      DocumentService.getDocumentById(documentId).then(function(document) {
        if (angular.isUndefined(document)) {
          ctrl.closeDocument();
          return;
        }
        ctrl.document = document;
        ctrl.document.editingEnabled = true; // TODO: implement locking of documents
        ctrl.show = true;
        $('#app-navigation-toggle').addClass('showdetails');
      });
    }
  };

  // ctrl.toggleActionsPanel = function() {
  //   ctrl.showActionsPanel = !ctrl.showActionsPanel;
  // };

  ctrl.updateDocument = function() {
    DocumentService.update(ctrl.document);
  };

  // ctrl.deleteAccount = function() {
  //   ctrl.deleteAccountLoading = true;
  //   AccountService.delete(ctrl.account);
  // };
  //
  // ctrl.exportAccount = function() {
  //
  // };
  //
  // ctrl.importTransactions = function() {
  //
  // }

});

angular.module('paperworkApp')
.directive('documentDetails', function() {
  return {
    priority: 1,
    scope: {},
    controller: 'documentDetailsCtrl',
    controllerAs: 'ctrl',
    bindToController: {},
    templateUrl: OC.linkTo('paperwork', 'templates/documentDetails.html')
  };
});

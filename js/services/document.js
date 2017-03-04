angular.module('paperworkApp')
.service('DocumentService', function($http, CacheFactory, $q) {

  var ctrl = this;

  var cacheFilled = false;
  var documents = CacheFactory('documents');
  var loadPromise = undefined;

  var observerCallbacks = [];

  ctrl.registerObserverCallback = function(callback) {
    observerCallbacks.push(callback);
  };

  var notifyObservers = function(eventname, response) {
    var ev = {
      event: eventname,
      response: response
    };
    angular.forEach(observerCallbacks, function(callback) {
      callback(ev);
    });
  };

  // TransactionService.registerObserverCallback(function(ev) {
  //   if(ev.event === 'create') {
  //     for(var i = 0; i < ev.response.splits.length; i++) {
  //       accounts.get(ev.response.splits[i].destAccountId).balance += ev.response.splits[i].value;
  //     }
  //   } else if (ev.event === 'addedSplit') {
  //     accounts.get(ev.response.destAccountId).balance += ev.response.value;
  //   } else if (ev.event === 'deletedSplit') {
  //     accounts.get(ev.response.destAccountId).balance -= ev.response.value;
  //   } else if (ev.event === 'updatedSplit') {
  //     accounts.get(ev.response.originalAccount).balance -= ev.response.originalValue;
  //     accounts.get(ev.response.destAccountId).balance += ev.response.value;
  //   }
  // });

  ctrl.fillCache = function() {
    if (_.isUndefined(loadPromise)) {
      loadPromise = $http.get('ajax/get-documents').then(function(response) {
      	//ctrl.accounts = response.data;
        for (var i in response.data) {
          response.data[i].id = parseInt(response.data[i].id);
          documents.put(response.data[i].id, response.data[i]);
        }
        cacheFilled = true;
      });
    }
    return loadPromise;
  };

  ctrl.getDocuments = function() {
    if (cacheFilled === false) {
      return this.fillCache().then(function() {
        return documents.values();
      });
    } else {
      return $q.when(documents.values());
    }
  };

  ctrl.getDocumentById = function(documentId) {
    if (cacheFilled === false) {
      return this.fillCache().then(function() {
        return documents.get(documentId);
      });
    } else {
      return $q.when(documents.get(documentId));
    }
  };

  // Get individual account from server
  // ctrl.getById = function(aid) {
  //   return $http.get('ajax/get-account', {
  //     params: {
  //       accountId: aid
  //     }
  //   }).then(function(response) {
  //     return response.data;
  //   });
  // };

  // ctrl.getCurrencies = function() {
  //   return this.getAccounts().then(function(accounts) {
  //     return _.uniq(accounts.map(function(element) {
  //       return element.currency;
  //     }).reduce(function(a, b) {
  //       return a.concat(b);
  //     }, []).sort(), true);
  //   });
  // };

  // ctrl.normalizeValues = function(account) {
  //   account.id = parseInt(account.id);
  //   account.type = parseInt(account.type);
  //   account.balance = parseInt(account.balance);
  // };

  ctrl.update = function(document) {
    return $http.put('ajax/update-document', document).then(function(response) {
      // ctrl.normalizeValues(response.data);
      notifyObservers('update', response.data);
    });
  };

  // ctrl.create = function(account) {
  //   return $http.post('ajax/add-account', account).then(function(response) {
  //     ctrl.normalizeValues(response.data);
  //     response.data.balance = 0.0;
  //     accounts.put(response.data.id, response.data);
  //     notifyObservers('create', response.data);
  //   });
  // };

  // ctrl.delete = function(account) {
  //   return $http.post('ajax/delete-account', {id: account.id}).then(function(response) {
  //     accounts.remove(account.id);
  //     notifyObservers('delete', response.data);
  //   })
  // }

  // ctrl.getAccountBalance = function(accountId) {
  //   return $http.get('ajax/get-account-balance', {
  //     params: {
  //       accountId: accountId
  //     }
  //   }).then(function(response) {
  //     return response.data;
  //   });
  // };

  // ctrl.getAccountTypeBalance = function(accountTypeId) {
  //   return this.getAccounts().then(function(accounts) {
  //     var balance = 0;
  //     for(var i = 0; i < accounts.length; i++) {
  //       if(accounts[i].type === accountTypeId) {
  //         balance += accounts[i].balance;
  //       }
  //     }
  //     var result = [];
  //     result['accountTypeId'] = accountTypeId;
  //     result['balance'] = balance;
  //     return result;
  //   });
  // };

});

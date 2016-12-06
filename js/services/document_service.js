angular.module('paperworkApp')
.service('DocumentService', function(DavClient, DocumentSourceService, Contact, $q, CacheFactory, uuid4) {

	var cacheFilled = false;

	var documents = CacheFactory('paperwork');

	var observerCallbacks = [];

	var loadPromise = undefined;

	this.registerObserverCallback = function(callback) {
		observerCallbacks.push(callback);
	};

	var notifyObservers = function(eventName, uid) {
		var ev = {
			event: eventName,
			uid: uid,
			documents: documents.values()
		};
		angular.forEach(observerCallbacks, function(callback) {
			callback(ev);
		});
	};

	this.fillCache = function() {
		if (_.isUndefined(loadPromise)) {
			loadPromise = DocumentSourceService.getAll().then(function (enabledDocumentSources) {
				var promises = [];
				enabledDocumentSources.forEach(function (documentSource) {
					promises.push(
						DocumentSourceService.sync(documentSource).then(function (documentSource) {
							for (var i in documentSource.objects) {
								if (documentSource.objects[i].addressData) { //TODO: addressData????
									var document = new Document(documentSource, documentSource.objects[i]);
									documents.put(document.uid(), document);
								} else {
									// custom console
									console.log('Invalid document received: ' + documentSource.objects[i].url);
								}
							}
						})
					);
				});
				return $q.all(promises).then(function () {
					cacheFilled = true;
				});
			});
		}
		return loadPromise;
	};

	this.getAll = function() {
		if(cacheFilled === false) {
			return this.fillCache().then(function() {
				return documents.values();
			});
		} else {
			return $q.when(documents.values());
		}
	};

	this.getLabels = function () {
		return this.getAll().then(function(documents) {
			return _.uniq(documents.map(function (element) {
				return element.categories();
			}).reduce(function(a, b) {
				return a.concat(b);
			}, []).sort(), true);
		});
	};

	this.getById = function(uid) {
		if(cacheFilled === false) {
			return this.fillCache().then(function() {
				return documents.get(uid);
			});
		} else {
			return $q.when(documents.get(uid));
		}
	};

	this.create = function(newDocument, documentSource, uid) {
		documentSource = documentSource || DocumentSourceService.getDefaultDocumentSource();
		newDocument = newDocument || new Document(documentSource);
		var newUid = '';
		if(uuid4.validate(uid)) {
			newUid = uid;
		} else {
			newUid = uuid4.generate();
		}
		newDocument.uid(newUid);
		newDocument.setUrl(documentSource, newUid);
		newDocument.documentSourceId = documentSource.displayName;
		// if (_.isUndefined(newDocument.fullName()) || newDocument.fullName() === '') {
			newDocument.fullName(t('paperwork', 'New document'));
		// }

	// 	return DavClient.createCard(
	// 		addressBook,
	// 		{
	// 			data: newContact.data.addressData,
	// 			filename: newUid + '.vcf'
	// 		}
	// 	).then(function(xhr) {
	// 		newContact.setETag(xhr.getResponseHeader('ETag'));
	// 		contacts.put(newUid, newContact);
	// 		notifyObservers('create', newUid);
	// 		return newContact;
	// 	}).catch(function(xhr) {
	// 		var msg = t('contacts', 'Contact could not be created.');
	// 		if (!angular.isUndefined(xhr) && !angular.isUndefined(xhr.responseXML) && !angular.isUndefined(xhr.responseXML.getElementsByTagNameNS('http://sabredav.org/ns', 'message'))) {
	// 			if ($(xhr.responseXML.getElementsByTagNameNS('http://sabredav.org/ns', 'message')).text()) {
	// 				msg = $(xhr.responseXML.getElementsByTagNameNS('http://sabredav.org/ns', 'message')).text();
	// 			}
	// 		}
	//
	// 		OC.Notification.showTemporary(msg);
	// 	});
	};

	// this.import = function(data, type, addressBook, progressCallback) {
	// 	addressBook = addressBook || AddressBookService.getDefaultAddressBook();
	//
	// 	var regexp = /BEGIN:VCARD[\s\S]*?END:VCARD/mgi;
	// 	var singleVCards = data.match(regexp);
	//
	// 	if (!singleVCards) {
	// 		OC.Notification.showTemporary(t('contacts', 'No contacts in file. Only VCard files are allowed.'));
	// 		if (progressCallback) {
	// 			progressCallback(1);
	// 		}
	// 		return;
	// 	}
	// 	var num = 1;
	// 	for(var i in singleVCards) {
	// 		var newContact = new Contact(addressBook, {addressData: singleVCards[i]});
	// 		if (['3.0', '4.0'].indexOf(newContact.version()) < 0) {
	// 			if (progressCallback) {
	// 				progressCallback(num / singleVCards.length);
	// 			}
	// 			OC.Notification.showTemporary(t('contacts', 'Only VCard version 4.0 (RFC6350) or version 3.0 (RFC2426) are supported.'));
	// 			num++;
	// 			continue;
	// 		}
	// 		this.create(newContact, addressBook).then(function() {
	// 			// Update the progress indicator
	// 			if (progressCallback) {
	// 				progressCallback(num / singleVCards.length);
	// 			}
	// 			num++;
	// 		});
	// 	}
	// };

	// this.moveDocument = function (document, documentSource) {
	// 	if (document.documentSourceId === documentSource.displayName) {
	// 		return;
	// 	}
	// 	contact.syncVCard();
	// 	var clone = angular.copy(contact);
	// 	var uid = contact.uid();
	//
	// 	// delete the old one before to avoid conflict
	// 	this.delete(contact);
	//
	// 	// create the contact in the new target addressbook
	// 	this.create(clone, addressbook, uid);
	// };

	// this.update = function(contact) {
	// 	// update rev field
	// 	contact.syncVCard();
	//
	// 	// update contact on server
	// 	return DavClient.updateCard(contact.data, {json: true}).then(function(xhr) {
	// 		var newEtag = xhr.getResponseHeader('ETag');
	// 		contact.setETag(newEtag);
	// 		notifyObservers('update', contact.uid());
	// 	});
	// };

	// this.delete = function(contact) {
	// 	// delete contact from server
	// 	return DavClient.deleteCard(contact.data).then(function() {
	// 		contacts.remove(contact.uid());
	// 		notifyObservers('delete', contact.uid());
	// 	});
	// };
});

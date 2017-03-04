<?php
// angular + components
script('paperwork', 'vendor/angular/angular');
script('paperwork', 'vendor/angular-route/angular-route');
script('paperwork', 'vendor/angular-uuid4/angular-uuid4');
script('paperwork', 'vendor/angular-cache/dist/angular-cache');
script('paperwork', 'vendor/angular-sanitize/angular-sanitize');
script('paperwork', 'vendor/ui-select/dist/select');

// compiled version of app javascript
// script('paperwork', 'public/script');

script('paperwork', 'main');
script('paperwork', 'components/labelList');
script('paperwork', 'components/documentDetails');
script('paperwork', 'components/documentList');
script('paperwork', 'components/documentListItem');
script('paperwork', 'services/document');

script('paperwork', 'vendor/angular-bootstrap/ui-bootstrap.min');
script('paperwork', 'vendor/angular-bootstrap/ui-bootstrap-tpls.min');
script('paperwork', 'vendor/jquery-timepicker/jquery.ui.timepicker');
script('paperwork', 'vendor/clipboard/dist/clipboard.min');
script('paperwork', 'vendor/ngclipboard/dist/ngclipboard.min');

// all styles
style('paperwork', 'public/style');
vendor_style('select2/select2');
?>

<div id="app" ng-app="paperworkApp">
	<div id="app-navigation">
		<newDocumentButton></newDocumentButton>
		<ul labelList></ul>

		<div id="app-settings">
			<div id="app-settings-header">
				<button class="settings-button"
						data-apps-slide-toggle="#app-settings-content">
					<?php p($l->t('Settings'));?>
				</button>
			</div>
			<div id="app-settings-content">
				<documentSourceList></documentSourceList>
				<documentImport></documentImport>
			</div>
		</div>
	</div>

	<div id="app-content">
		<div class="app-content-list">
			<document-list></document-list>
		</div>
		<div class="app-content-detail" ng-view></div>
	</div>
</div>

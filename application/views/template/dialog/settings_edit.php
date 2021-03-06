<md-dialog aria-label="Mango (Fruit)">
  <form ng-cloak>
    <md-dialog-content>
      <div class="md-dialog-content" layout="column">
        <ng-include src="settingsData.dialog.url"></ng-include>
         <md-progress-linear ng-hide="settingsData.dialog.progress" md-mode="indeterminate"></md-progress-linear>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <span flex></span>
      <md-button ng-click="cancel(settingsData.click)">
       CANCEL
      </md-button>
      <md-button ng-disabled="uButton" class="md-warn" ng-click="submit(settingsData.click)">
        UPDATE
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>

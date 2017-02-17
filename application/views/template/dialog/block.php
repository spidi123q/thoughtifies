<md-dialog aria-label="Mango (Fruit)">
  <form ng-cloak>

    <md-dialog-content>
      <div class="md-dialog-content">
        <md-list>
          <md-list-item  class="md-3-line" >
            <img ng-src="<?php echo base_url(); ?>images/{{item.icon}}" class="md-avatar" alt="{{item.who}}" >
            <div class="md-list-item-text">
              <p>
                {{item.name}}
                <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,$index+3)" aria-label="call">
                  <i class="material-icons">create</i>
                </md-button>
              </p>
              <h3></h3>
              <div>{{item.data}}</div>

            </div>
            <md-divider md-inset ng-if="!$last"></md-divider>
          </md-list-item>
        </md-list>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button ng-click="answer('useful')">
        Useful
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>

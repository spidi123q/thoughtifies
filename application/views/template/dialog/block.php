<md-dialog aria-label="Mango (Fruit)">
  <form ng-cloak>

    <md-dialog-content>
      <div class="md-dialog-content">
        <md-list>
          <md-list-item  class="md-2-line"  ng-repeat="item in userList">
            <img ng-src="{{item.picture}}" class="md-avatar" alt="{{item.who}}" >
            <div class="md-list-item-text">
              <h3>{{item.fname}} {{item.lname}}</h3>
              <p>

                <md-button  class="md-secondary md-icon-button md-warn md-hue-2" ng-click="unBlock(item)" aria-label="call">
                  <i class="material-icons">close</i>
                </md-button>
              </p>

            </div>
            <md-divider md-inset ng-if="!$last"></md-divider>
          </md-list-item>
        </md-list>
        <div class="empty_msg" ng-if="userList.length === 0">
            No blocked users
        </div>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button class="md-warn" ng-click="cancel()">
        close
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>

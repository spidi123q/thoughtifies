<md-dialog  aria-label="Mango (Fruit)" ng-controller="chatBox">

  <md-dialog-content  schroll-bottom="myvar">
      <div class="md-dialog-content">

        <md-list>
              <md-list-item class="md-3-line md-long-text"  ng-repeat="item in messages">
              <img ng-src="{{todos[0].face}}?25" class="md-avatar" alt="{{todos[0].who}}" />
              <div class="md-list-item-text">
                <h3>{{ todos[0].who }}</h3>
                <p>
                  Secondary line text Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam massa quam.
                  Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum
                  velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
              </div>
            </md-list-item>
          </md-list>

      </div>
      <div id="bottom">
      </div>

  </md-dialog-content>




  <md-dialog-actions flex layout="row">
    <md-button flex="10"  ng-click="cancel()">
     close
    </md-button>
    <textarea flex ="80" ng-model="msg" placeholder="Please provide a reason for rejection"></textarea>
    <md-button flex="10"  ng-click="k(msg)">
     sent
    </md-button>

  </md-dialog-actions>


</md-dialog>

<md-dialog  aria-label="Mango (Fruit)" ng-controller="chatBox">

  <md-dialog-content >
          <md-content>
          <md-content>
            <md-content class="md-dialog-content"  ng-hide="msgView" >
                <md-list style="max-height:250px;overflow-y: scroll;" scroll-glue>
                      <md-list-item class="md-long-text"  ng-repeat="item in messages"  >
                      <img ng-hide="dpDisplay(item)" ng-src="https://material.angularjs.org/latest/img/list/60.jpeg?20" class="md-avatar" alt="{{todos[0].who}}" />
                      <div class="md-list-item-text">
                        <h3>{{ todos[0].who }}</h3>
                        <p ng-bind-html="item.message">
                        </p>
                      </div>
                    </md-list-item>
                  </md-list>
              </md-content>


            </md-content>
            <div ng-hide="emojiView" style="height:150px;overflow-y: scroll;" scroll-glue>
                <span ng-repeat="item in emojilist">
                  <span ng-bind-html="item"></span>
                </span>

            </div>
          </md-content>
          <div  contenteditable="true"
          ng-model="msg" ng-change="change()"
                style="bottom: 0;max-height: 150px; overflow-y: scroll;">
          </div>


  </md-dialog-content>




  <md-dialog-actions>
    <md-button   ng-click="cancel()">
     close
    </md-button>

    <button ng-click="emojiButton()">
   Click me!
   </button>
    <md-button   ng-click="send(msg)">
     sent
    </md-button>

  </md-dialog-actions>


</md-dialog>

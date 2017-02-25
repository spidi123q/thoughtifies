<md-dialog  aria-label="Mango (Fruit)" ng-controller="chatBox">

  <md-dialog-content style="overflow-y:hidden;">
          <md-content>
            <md-content class="md-dialog-content chat_dialog_content"  ng-hide="msgView" scroll-glue>
                <md-list style="" >
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
            <div ng-hide="emojiView" style="">
                <span ng-repeat="item in emojilist">
                  <span ng-bind-html="item"></span>
                </span>

            </div>
          </md-content>
          <div  contenteditable="true"
          ng-model="msg" ng-change="change()"
          ng-keypress="checkIfEnterKeyWasPressed($event,this)"
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
    <md-button   ng-click="send(msg);msg=''">
     sent
    </md-button>

  </md-dialog-actions>


</md-dialog>

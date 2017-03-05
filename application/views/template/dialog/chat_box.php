<md-dialog  class="chat_dialog">

  <md-dialog-content layout="column" layout-align="space-between center" style="overflow-y:hidden;height:100%;">
            <md-content class="md-dialog-content chat_dialog_content"  ng-hide="view" scroll-glue style="width:100%;height: 100%;">
                <md-list style="" >
                  <md-list-item class="md-long-text"  ng-repeat="item in messages"  style="padding: 10px; ">
                    <img ng-click="setDp(item)" image-fetch  ng-src="{{setDp(item)}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                  <div class="md-list-item-text" ng-style="bgList(dpDisplay.get(item))" style="border-radius: 10px;padding: 5px; ">
                    <h3>{{ todos[0].who }}</h3>
                    <h5 ng-bind-html="item.message" style="color:grey"></h5>
                  </div>
                </md-list-item>
                  </md-list>
              </md-content>
            <md-content class="chat_dialog_content" ng-hide="!view">
                <span ng-repeat="item in emojilist">
                  <span ng-bind-html="item"></span>
                </span>

            </md-content>
            <div class="chat_dialog_contenteditable msg_placeholder" md-whiteframe="4"  contenteditable="true" placeholder="Type your message"
            ng-model="msg" ng-change="change()"
            ng-keypress="checkIfEnterKeyWasPressed($event,this)">
            </div>



  </md-dialog-content>




  <md-dialog-actions >
    <md-button   ng-click="cancel()">
     close
    </md-button>
   <md-switch ng-change="changeEmojiView()" class="md-warn"  ng-model="view" >

    <md-button class="md-icon-button" aria-label="More">
          <i class="material-icons ">tag_faces</i>
        </md-button>
  </md-switch>

  </md-dialog-actions>


</md-dialog>

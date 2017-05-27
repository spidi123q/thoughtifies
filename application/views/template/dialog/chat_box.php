<md-dialog  class="chat_dialog">

  <md-dialog-content layout="column" layout-align="space-between center" style="overflow-y:hidden;height:100%;">
            <md-content class="md-dialog-content chat_dialog_content"  ng-hide="view" scroll-glue style="width:100%;height: 100%;overflow-x:hidden">
                <md-list style="" >
                  <md-list-item class="md-long-text"  ng-repeat="item in messages"  style="padding: 10px; ">
                    <img ng-click="setDp(item)" image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg"  img-src="{{setDp(item)}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                  <div class="md-list-item-text" ng-style="bgList(dpDisplay.get(item))" style="border-radius: 10px;padding: 5px;overflow-x: hidden;">
                    <h5 class="chat-text" ng-bind-html="item.message" style="color:grey;overflow-wrap: break-word;"></h5>
                  </div>
                </md-list-item>
                  </md-list>
              </md-content>
            <md-content class="chat_dialog_content" ng-hide="!view">
                <span  ng-repeat="item in emojilist" ng-click="onEmojiClickChat(item)">
                  <span ng-bind-html="item"></span>
                </span>

            </md-content>
            <div class="typing-warn" ng-show="isTyping">
              typing
            </div>
            <div class="chat_dialog_contenteditable msg_placeholder" md-whiteframe="4"  contenteditable="true" placeholder="Type your message"
            ng-model="msg" ng-change="change()"
            ng-keypress="checkIfEnterKeyWasPressed($event,this)">
            </div>


  </md-dialog-content>




  <md-dialog-actions layout-margin>

    <md-button class=""  ng-click="cancel()">
     close
    </md-button>
   <md-switch ng-model="switchVal" ng-change="changeEmojiView()" class="md-warn"  ng-model="view" >

    <md-button class="md-icon-button" aria-label="More">
        <i class="material-icons ">tag_faces</i>
    </md-button>
  </md-switch>

  </md-dialog-actions>


</md-dialog>

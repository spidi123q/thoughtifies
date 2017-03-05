<md-dialog class="msg_dialog" aria-label="Mango (Fruit)">
  <div class="msg_dialog_contenteditable" md-whiteframe="4"  contenteditable="true"
    ng-model="msg" ng-change="change()"
    ng-keypress="checkIfEnterKeyWasPressed($event,this)">
    </div>



  <md-dialog-actions>
    <md-button ng-click="cancel()">
     close
    </md-button>
    <md-button ng-click="send()" ng-disabled="upload.button" class="md-warn">
      <md-icon md-font-library="material-icons" class="md-light md-48">send</md-icon>
    </md-button>

  </md-dialog-actions>


</md-dialog>

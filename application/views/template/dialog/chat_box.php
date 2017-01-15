<md-dialog  aria-label="Mango (Fruit)" ng-controller="chatBox">

  <md-dialog-content >
    <table>
      <tr >
        <td>
          <md-content>
          <md-content>
            <md-content class="md-dialog-content"  ng-hide="msgView" >
                <md-list style="max-height:250px;overflow-y: scroll;" scroll-glue>
                      <md-list-item class="md-3-line md-long-text"  ng-repeat="item in messages"  >
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
              </md-content>


            </md-content>
            <div ng-hide="emojiView" style="height:150px;overflow-y: scroll;" scroll-glue>
                <span ng-repeat="item in emojilist">
                  <span ng-bind-html="item"></span>
                </span>

            </div>
          </md-content>
        </td>
      </tr>
      <tr>
        <td>
          <div  contenteditable="true"
          ng-model="msg"
                style="bottom: 0;max-height: 150px; overflow-y: scroll;">
          </div>
        </td>
      </tr>
    </table>

  </md-dialog-content>




  <md-dialog-actions>
    <md-button   ng-click="cancel()">
     close
    </md-button>

    <button ng-click="emojiButton()">
   Click me!
   </button>
    <md-button   ng-click="k(msg)">
     sent
    </md-button>

  </md-dialog-actions>


</md-dialog>

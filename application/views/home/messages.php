

<md-content layout="row" ng-controller="msgController" layout-align="center center" >

  <md-sidenav  class="md-sidenav-left" md-component-id="jam"
       ui-scroll-viewport md-whiteframe="4">
<!--
  <md-toolbar class="md-theme-indigo" layout="row">
  <h1 class="md-toolbar-tools">Disabled Backdrop</h1>
  <md-button  class="md-icon-button md-accent" ng-click="toggleLeft()">
      <i class="material-icons">close</i>
  </md-button>
  </md-toolbar>
-->
  <md-list >
    <md-list-item  ui-scroll="item in jj" adapter="msgUserListAdapter on msgController" class="md-3-line" ng-click="selectMsgUser(item)">
       <img ng-src="https://material.angularjs.org/latest/img/icons/angular-logo.svg" class="md-avatar" alt="" />
       <div class="md-list-item-text" layout="column">
         {{item.fname}} {{item.lname}}
       </div>
  </md-list-item>
  </md-list>

  </md-sidenav>



        <div  layout="column" flex="80">
          <div layout="row" layout-align="end center">
            <span flex-offset="5">{{msgUserName.fname}} {{msgUserName.lname}}</span>
            <md-list-item flex-offset="5" ng-click="toggleLeft()" class="noright">
              <img alt="{{ person.name }}" ng-src="<?php echo base_url(); ?>images/flaticons/svg/team.svg" class="md-avatar" />
              <p>CONTACTS</p>
            </md-list-item>
          </div>
            <md-content layout="row" flex="60">
                    <md-content ng-hide="view" flex ui-scroll-viewport scroll-glue>
                          <md-list>
                                <md-list-item class="md-long-text"  ui-scroll="item in datasource"  adapter="msgUserAdapter on msgController" style="padding: 10px; ">
                                <img  ng-src="https://material.angularjs.org/latest/img/list/60.jpeg?20" class="md-avatar" alt="{{todos[0].who}}" />
                                <div class="md-list-item-text" ng-style="bgList(dpDisplay.get(item))" style="border-radius: 10px;padding: 5px; ">
                                  <h3>{{ todos[0].who }}</h3>
                                  <h4 ng-bind-html="item.message" style="opacity : 0.54"></h4>
                                </div>
                              </md-list-item>
                            </md-list>
                    </md-content>
                    <div  ng-hide="!view"style="height:100%;">
                        <span ng-repeat="item in emojilist">
                          <span ng-bind-html="item"></span>
                        </span>
                    </div>
            </md-content>
            <div layout="column">
              <div contenteditable ng-model="msg" md-whiteframe="4"
              ng-focus="focus()"
              ng-blur="unfocus()"
              ></div>
            </div>
            <div layout="row" >
              <span layout="row" layout-align="end center">
                <md-button class="md-icon-button md-primary" aria-label="More" ng-click="changeEmojiView()">
                    <i class="material-icons">tag_faces</i>
                </md-button>
              <!--  <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
                <label for="input-file-id" class="md-icon-button">
                      <i class="material-icons">insert_photo</i>
                </label>-->
              </span>
              <md-button class="md-warn" ng-click="sendMsg()">send</md-button>
            </div>

        </div>


</md-content>

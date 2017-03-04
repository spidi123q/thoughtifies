

<md-content layout="row" ng-controller="msgController" layout-align="center center" style="height:100%">

  <md-sidenav class="md-sidenav-left" md-component-id="jam" md-disable-backdrop md-whiteframe="4"
       ui-scroll-viewport >
<!--
  <md-toolbar class="md-theme-indigo" layout="row">
  <h1 class="md-toolbar-tools">Disabled Backdrop</h1>
  <md-button  class="md-icon-button md-accent" ng-click="toggleLeft()">
      <i class="material-icons">close</i>
  </md-button>
  </md-toolbar>
-->
  <md-list >
    <md-list-item  ui-scroll="item in jj" adapter="msgUserListAdapter on msgController" class="md-2-line" ng-click="selectMsgUser(item)">
       <img image-fetch ng-src="{{item.picture}}" size="60" class="md-avatar" alt="" />
       <div class="md-list-item-text" layout="column">
         {{item.fname}} {{item.lname}}
       </div>
       <md-menu class="md-secondary">
     <md-button aria-label="Open phone interactions menu" class="md-icon-button md-warn" ng-click="openMenu($mdOpenMenu, $event)">
       <i class="material-icons">more_vert</i>
     </md-button>
     <md-menu-content width="2">
       <md-menu-item>
         <md-button ng-click="deleteMsgUser(item.mem_id)">
           <i class="material-icons">delete</i>
           Delete
         </md-button>
       </md-menu-item>
       <md-menu-item>
         <md-button disabled="disabled" ng-click="ctrl.checkVoicemail()">
           <md-icon md-svg-icon="call:voicemail"></md-icon>
           Block
         </md-button>
       </md-menu-item>
     </md-menu-content>
   </md-menu>
  </md-list-item>

  </md-list>
  <div layout="row" layout-align="center center">
    <md-progress-circular ng-if="msgUserListAdapter.isLoading" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
  </div>

  </md-sidenav>



        <div  layout="column" flex="80" style="height:100%">
          <div layout="row" layout-align="end center">
            <span flex-offset="5">{{msgUserName.fname}} {{msgUserName.lname}}</span>
            <md-list-item flex-offset="5" ng-click="toggleLeft()" class="noright">
              <img alt="{{ person.name }}" ng-src="<?php echo base_url(); ?>images/flaticons/svg/team.svg" class="md-avatar" />
              <p>CONTACTS</p>
            </md-list-item>
          </div>
            <md-content layout="row" flex="60">
                    <md-content ng-hide="view" flex ui-scroll-viewport scroll-glue>
                      <div layout="row" layout-align="center center">
                        <md-progress-circular ng-if="msgUserAdapter.isLoading" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                      </div>
                          <md-list>
                                <md-list-item class="md-long-text"  ui-scroll="item in datasource"  adapter="msgUserAdapter on msgController" style="padding: 10px; ">
                                <img ng-if="dpDisplay.get(item.receiver)" image-fetch ng-src="{{myDp}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                                <img ng-if="!dpDisplay.get(item.receiver)" image-fetch ng-src="{{msgUserName.picture}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                                <div class="md-list-item-text" ng-style="bgList(dpDisplay.get(item))" style="border-radius: 10px;padding: 5px; ">
                                  <h3>{{ todos[0].who }}</h3>
                                  <h5 ng-bind-html="item.message" style="color:grey"></h5>
                                </div>
                              </md-list-item>
                            </md-list>
                    </md-content>
                    <div  ng-hide="!view"style="height:100%;">
                        <span ng-repeat="item in emojilist" ng-click="onEmojiClick(item)" style="width:32px;height:32px;">
                          <span ng-bind-html="item" ></span>
                        </span>
                    </div>
            </md-content>

            <div layout="column" style="width:100%">
              <div contenteditable ng-model="msg" md-whiteframe="4" style="width:100%;height:50px;"
              ng-focus="focus()"
              ng-blur="unfocus()"
              ></div>
            </div>
            <div layout="row" >
              <span layout="row" layout-align="end center">
                <md-switch ng-change="changeEmojiView()" class="md-warn"  ng-model="view" >

                 <md-button class="md-icon-button" aria-label="More">
                       <i class="material-icons ">tag_faces</i>
                     </md-button>
               </md-switch>
              <!--  <input class="ng-hide" id="input-file-id"  type="file" nv-file-select="" uploader="uploader" />
                <label for="input-file-id" class="md-icon-button">
                      <i class="material-icons">insert_photo</i>
                </label>-->
              </span>
              <md-button class="md-warn" ng-click="sendMsg()">send</md-button>
            </div>

        </div>


</md-content>

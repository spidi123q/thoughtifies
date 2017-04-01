
<br><br>
<md-content class="msgPage" layout="row" ng-controller="msgController" layout-align="center center" style="height:100%">

  <md-sidenav class="md-sidenav-left" md-component-id="jam"  md-whiteframe="4"
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
       <img image-fetch img-src="{{item.picture}}" ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" size="60" class="md-avatar" alt="" />
       <div class="md-list-item-text" layout="column">
         {{item.fname}} {{item.lname}}
       </div>
       <md-menu class="md-secondary">
     <md-button class="md-icon-button" ng-click="openMenu($mdOpenMenu, $event)">
       <md-icon md-font-library="material-icons" class="md-light md-48">more_vert</md-icon>
     </md-button>
     <md-menu-content width="2">
       <md-menu-item>
         <md-button ng-click="showConfirm($event,item.mem_id,$index)">
           <md-icon md-font-library="material-icons" class="md-light md-48">delete</md-icon>
           Delete
         </md-button>
       </md-menu-item>
       <md-menu-item>
         <md-button disabled="disabled" ng-click="ctrl.checkVoicemail()">
           <md-icon md-font-library="material-icons" class="md-light md-48">block</md-icon>
           Block
         </md-button>
       </md-menu-item>
     </md-menu-content>
   </md-menu>
  </md-list-item>

  </md-list>
  <div class="empty_msg" ng-if="msgUserListAdapter.isEmpty() && !msgUserListAdapter.isLoading">
    Inbox empty
  </div>
  <div layout="row" layout-align="center center">
    <md-progress-circular ng-if="msgUserListAdapter.isLoading " md-mode="indeterminate" md-diameter="20"></md-progress-circular>
  </div>

  </md-sidenav>



        <div  layout="column" flex="80" style="height:100%">
          <div layout="row" layout-align="end center">
            <a href="#/users/{{msgUser}}"><span flex-offset="5">{{msgUserName.fname}} {{msgUserName.lname}}</span></a>
            <md-list-item flex-offset="5" ng-click="toggleLeft()" class="noright">
              <img alt="{{ person.name }}" ng-src="<?php echo base_url(); ?>images/flaticons/svg/team.svg" class="md-avatar" />
              <p>CONTACTS</p>
            </md-list-item>
          </div>
            <md-content layout="row" flex="60" style="padding-left:20px;">
                    <md-content ng-hide="view" flex ui-scroll-viewport scroll-glue style="width:100%;overflow-x:hidden">
                      <div layout="row" layout-align="center center">
                        <md-progress-circular ng-if="msgUserAdapter.isLoading && msgUser !== undefined" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
                      </div>
                      <div class="empty_msg" ng-if="msgUserAdapter.isEmpty() && msgUser !== undefined && !msgUserAdapter.isLoading">
                        No messages
                      </div>
                      <div class="empty_msg" ng-if="msgUser === undefined">
                        No user selected
                      </div>
                          <md-list>
                                <md-list-item class="md-long-text"  ui-scroll="item in datasource"  adapter="msgUserAdapter on msgController" style="padding: 10px; ">
                                <img ng-if="dpDisplay.get(item.receiver)" image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{myDp}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                                <img ng-if="!dpDisplay.get(item.receiver)" image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{msgUserName.picture}}" size="60" class="md-avatar" alt="{{todos[0].who}}" />
                                <div class="md-list-item-text" ng-style="bgList(dpDisplay.get(item))" style="border-radius: 10px;padding: 5px;overflow-x: hidden;">
                                  <h5 ng-bind-html="item.message" style="color:grey;overflow-wrap: break-word;" ></h5>
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

            <div layout="column" style="width:100%;padding-top:10px;">
              <div class="msg_placeholder msg_dialog_contenteditable" contenteditable="true" placeholder="Type your message" ng-model="msg" md-whiteframe="4" style="height:40px;"
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

<div layout="column" ng-hide="hideProfile()">
  <div  flex="35" layout="row" layout-xs="column"  layout-align="center center" layout-align-xs="space-between center">

        <div layout="row" >
          <div layout="row"  layout-align="end end" style="z-index: 10;position: absolute;">

            <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,0)" aria-label="call">
              <md-icon md-font-library="material-icons" class="md-light md-48">create</md-icon>
            </md-button>

          </div>
          <img flex="40" md-whiteframe="3"   alt="" ng-src="{{settingsData.dp}}"  alt="" style="max-width: 150;
    max-height: 150;">
          <div flex-offset="10" flex layout="column" layout-align="center center">
              <div layout="row">
                <h3>
                <md-truncate flex>
                  {{settingsData.fname}} {{settingsData.lname}}
                </md-truncate>
              </h3>
              </div>
              <div layout="row"  layout-xs="column">
                  <h5>
                    <md-truncate flex>
                      {{settingsData.tag}}
                    </md-truncate>
                  </h5>
              </div>
          </div>
        </div>
        <div ng-if="!settingsData.config">
          <section md-whiteframe="1" layout="row" layout-align="center center">
            <friendpanel uid="uid"></friendpanel>
          </section>
        </div>
  </div>
  <div flex ng-cloak>
    <md-content>
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="{{settingsData.tabs.profile.name}}">
          <md-content layout="row" class="md-padding" layout-align="center center">
            <div layout="column"  flex-sm="80"  flex-gt-sm="50">
                    <md-list>
                      <md-list-item  class="md-3-line" ng-repeat="item in settingsData.tabs.profile.info" >
                        <img ng-src="<?php echo base_url(); ?>images/{{item.icon}}" class="md-avatar" alt="{{item.who}}" >
                        <div class="md-list-item-text">
                          <p>
                            {{item.name}}
                            <md-button ng-disabled=" ($index+3) === 7" ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,$index+3)" aria-label="call">
                              <md-icon md-font-library="material-icons" class="md-light md-48">create</md-icon>
                            </md-button>
                          </p>
                          <h3></h3>
                          <div>{{item.data}}</div>

                        </div>
                        <md-divider md-inset></md-divider>
                      </md-list-item>
                      <md-list-item  class="md-3-line"  >
                        <img ng-src="<?php echo base_url(); ?>images/flaticons/svg/001-hand-shake.svg" class="md-avatar" alt="{{item.who}}" >
                        <div class="md-list-item-text">
                          <p>
                            FRIENDS
                            <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" href="#/request/1" aria-label="call">
                              <md-icon md-font-library="material-icons" class="md-light md-48">remove_red_eye</md-icon>
                            </md-button>
                          </p>
                          <h3></h3>
                          <div>{{settingsData.friend_count}}</div>

                        </div>
                      </md-list-item>
                    </md-list>
            </div>



          </md-content>
        </md-tab>
        <md-tab label="{{settingsData.tabs.photos.name}}" md-on-select="onSelectPosts()">
          <md-content ng-controller="ProfilePosts"  class="md-padding" ng-if="settingsData.post">
                <div   layout="column"  layout-align="center center" ui-scroll="item in datasource" adapter="adapter on ProfilePosts">
                  <post-view-card adapter="adapter" index="$index" info="item" style="width:520px"></post-view-card>
                </div>
              <div  layout="column"  layout-align="center center">

                <br>
                <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
                <div class="empty_msg" ng-if="adapter.isEmpty() && !adapter.isLoading">
                  User has no thoughts yet
                </div>
                <br>
              </div>
          </md-content>

        </md-tab>
        <md-tab label="{{settingsData.tabs.settings.name}}">
          <md-content class="md-padding" layout="row" layout-align="center center" >
            <md-list flex-sm="80"  flex-gt-sm="50"  >

              <md-list-item class="md-2-line"  ng-click="getDialog($event,2)" id="left">
                <md-icon  md-font-library="material-icons" class="md-light md-48" style="color:grey">public</md-icon>
                <div class="md-list-item-text" layout="column">
                  <h3></h3>
                  <p>Change status</p>
                </div>
              </md-list-item>
              <md-list-item class="md-2-line"  ng-click="getDialog($event,1)" id="left">
                <md-icon  md-font-library="material-icons" class="md-light md-48" style="color:grey">person</md-icon>
                <div class="md-list-item-text" layout="column">
                  <h3></h3>
                  <p>Change name</p>
                </div>
              </md-list-item>
                 <md-list-item class="md-2-line"  ng-click="openFromLeft($event)" id="left">
                  <md-icon  md-font-library="material-icons" class="md-light md-48" style="color:grey">lock</md-icon>
                   <div class="md-list-item-text" layout="column">
                     <p>Blocked users</p>
                   </div>
                 </md-list-item>
              </md-list>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
</div>
<div ng-hide="!hideProfile()" layout="row" layout-align="center center">
  <h1>Sorry,you cant view this profile</h1>
</div>



<md-content layout="row" ng-controller="msgController" layout-align="center center" >

  <md-sidenav  class="md-sidenav-left" md-component-id="jam"
     md-disable-backdrop  ui-scroll-viewport md-whiteframe="4">

  <md-toolbar class="md-theme-indigo">
  <h1 class="md-toolbar-tools">Disabled Backdrop</h1>
  <md-button ng-click="toggleLeft()" class="md-raised">
    Toggle Sidenav
  </md-button>
  </md-toolbar>

  <md-list >
    <md-list-item  ui-scroll="item in jj" adapter="msgUserListAdapter on msgController" class="md-3-line" ng-click="selectMsgUser(item.mem_id)">
       <img ng-src="https://material.angularjs.org/latest/img/icons/angular-logo.svg" class="md-avatar" alt="" />
       <div class="md-list-item-text" layout="column">
         {{item.fname}}
       </div>
  </md-list-item>
  </md-list>

  </md-sidenav>



        <div  layout="column" flex="80">
            <span layout="row">
              <md-button ng-click="toggleLeft()" class="md-raised">
                Toggle Sidenav
              </md-button>
              <span>ss</span>
            </span>
            <md-content layout="row" flex="60">
                    <md-content flex ui-scroll-viewport >
                          <md-list >
                                <md-list-item class="md-long-text"  ui-scroll="item in datasource"  adapter="msgUserAdapter on msgController">
                                <img ng-hide="dpDisplay.get(item)" ng-src="https://material.angularjs.org/latest/img/list/60.jpeg?20" class="md-avatar" alt="{{todos[0].who}}" />
                                <div class="md-list-item-text">
                                  <h3>{{ todos[0].who }}</h3>
                                  <p ng-bind-html="item.message">
                                  </p>
                                </div>
                              </md-list-item>
                            </md-list>
                    </md-content>
            </md-content>
              <textarea ng-model="msg">
                ggggggg
              </textarea>
            <div layout="row" flex="20">
              <md-button class="md-warn" ng-click="sendMsg()">send</md-button>
            </div>

        </div>


</md-content>

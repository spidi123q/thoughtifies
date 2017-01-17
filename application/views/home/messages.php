<md-content layout="row" ng-controller="debug">

    <div flex  >
      <md-content  flex="70" layout="row">
        <md-content flex ui-scroll-viewport>
			<ul>
				<div ui-scroll="item in jj" adapter="msgUserListAdapter">
            <md-list-item class="md-3-line" ng-click="selectMsgUser(item.mem_id)">
               <img ng-src="https://material.angularjs.org/latest/img/icons/angular-logo.svg" class="md-avatar" alt="" />
               <div class="md-list-item-text" layout="column">
                 {{item.fname}}
               </div>
         </md-list-item>
        </div>
			</ul>


        </md-content>
      </md-content>
<br>
  </div>
        <div ng-controller="msgController" layout="column" flex="50">
              <md-content layout="row" flex="60">
                    <md-content flex ui-scroll-viewport >
                          <md-list>
                                <md-list-item class="md-long-text"  ui-scroll="item in datasource"  >
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
            <div layout="row" flex>
              <textarea ng-model="msg" flex="70">
              </textarea>
            </div>
            <div layout="row" flex="20">
              <md-button class="md-warn" ng-click="sendMsg()">send</md-button>
            </div>

        </div>


</md-content>

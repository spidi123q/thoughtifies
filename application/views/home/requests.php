<div ng-controller="Request" layout="column" layout-align="center center">

  <div ng-controller="FbUsers" layout="column" layout-align="center center">
      <div  layout="row" layout-align="center center" style="margin-top:20px">
          <div md-whiteframe="1" class="recent_visitors">
              <div class="rv_header">
                  Your Facebook friends <span ng-if="recentVisitors.length === 0"><div class="empty_msg" >
                No friends
              </div> </span>
              </div>
              <div  layout="row" style="overflow-x:auto">
                  <a ng-repeat="item in fbFriends" href="#/users/{{item.mem_id}}">
                      <img  ng-csp image-fetch img-src="{{item.picture}}" ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" size="60" class="img-circle" alt="{{item.who}}" />
                  </a>
              </div>


          </div>
      </div>

  </div>
    <md-switch ng-model="switch" aria-label="Switch 1" ng-change="switchReload()">
     <span ng-if="switch" class="empty_msg">Pending</span>
     <span ng-if="!switch" class="empty_msg">Friends</span>
  </md-switch>
    <div ui-scroll="user in datasource" adapter="adapter on Request" >
     <friend-request-card ng-if="switch"></friend-request-card>
     <usercard ng-if="!switch" info="user" index="$index" adapter="adapter"></usercard>
    </div>
    <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
    <div class="empty_msg" ng-if="adapter.isEmpty()">
        No users to list
    </div>
  </div>
<br><br>
</div>

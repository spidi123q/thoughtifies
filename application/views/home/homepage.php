<div ng-controller="PostView">
      <div  layout="column" layout-align="center center" >
        <div  layout="row" layout-align="center center" >
          <postcard adapter="adapter" style="width:500px"></postcard>
        </div>
        <div  layout="row" layout-align="center center" style="margin-top:20px">
          <div md-whiteframe="1" class="recent_visitors">
            <div class="rv_header">
              Recent visitors <span ng-if="recentVisitors.length === 0"><div class="empty_msg" >
                No visitors
              </div> </span>
            </div>
            <div  layout="row" style="overflow-x:auto">
              <a ng-repeat="item in recentVisitors" href="#/users/{{item.mem_id}}">
                <img  ng-csp image-fetch img-src="{{item.picture}}" ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" size="60" class="img-circle" alt="{{item.who}}" />
              </a>
            </div>


          </div>
        </div>

      </div>
    <div layout="row" layout-align="center center">
      <md-switch ng-model="friend_switch" aria-label="Switch 1" ng-change="friendSwitchChange()">
       <span class="empty_msg">Friend's thoughts</span>
     </md-switch>
    </div>
    <div  layout="column" layout-align="center center"  >
      <div layout="column"  layout-align="center center" ui-scroll="item in datasource" adapter="adapter on PostView" >
          <post-view-card info="item" style="width:520px"></post-view-card>
      </div>
      <div layout="column"  layout-align="center center">
        <br>
        <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
        <br>
      </div>
    </div>
</div>

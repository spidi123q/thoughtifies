<div ng-controller="Request" layout="row" layout-align="center center">

  <div layout="column" layout-align="center center">
    <md-switch ng-model="switch" aria-label="Switch 1" ng-change="switchReload()">
     <span ng-if="switch" class="empty_msg">Pending</span>
     <span ng-if="!switch" class="empty_msg">Friends</span>
  </md-switch>
    <div ui-scroll="user in datasource" adapter="adapter on Request" >
     <friend-request-card ng-if="switch"></friend-request-card>
     <usercard ng-if="!switch" info="user" index="$index" adapter="adapter"></usercard>
    </div>
  </div>
<br><br>
</div>

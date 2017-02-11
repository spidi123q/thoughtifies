<div id="recentVisitors" class="memberTable">
             <a href="#/users/34">hh</a>
             
</div>
<div layout="row" layout-align="center center" >
  <div layout="column" >
    <div layout="row" layout-align="center center">
      <postcard flex></postcard>
    </div>
  </div>
</div>
<br>
<div layout="column" layout-align="center center" ng-controller="PostView" >
  <div layout="column" ui-scroll="item in datasource" adapter="adapter on PostView" >
    <post-view-card></post-view-card>
  </div>
</div>

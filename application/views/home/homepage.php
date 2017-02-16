<div id="recentVisitors" class="memberTable">
             <a href="#/users/34">hh</a>

</div>


    <div  layout="column" layout-align="center center" >
      <div  layout="row" layout-align="center center" >
        <postcard  style="width:500px"></postcard>
      </div>
    </div>

  <br>
  <div  layout="column" layout-align="center center" ng-controller="PostView" >
    <div layout="column"  layout-align="center center" ui-scroll="item in datasource" adapter="adapter on PostView" >
        <post-view-card style="width:520px"></post-view-card>
        
    </div>
  </div>

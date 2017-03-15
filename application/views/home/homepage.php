<div id="recentVisitors" class="memberTable">
             <a href="#/users/34">hh</a>
</div>
<div ng-controller="PostView">
      <div  layout="column" layout-align="center center" >
        <div  layout="row" layout-align="center center" >
          <postcard adapter="adapter" style="width:500px"></postcard>
        </div>
        <br>
        <div  layout="row" layout-align="center center" >
          <div md-whiteframe="1" class="recent_visitors">
            <div class="rv_header">
              Recent visitors
            </div>
            <div  layout="row" style="overflow-x:scroll">
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" /><img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />
                <img ng-csp image-fetch ng-src="8fa89e3b9ed9ea7d84493c3a63e4a376" size="60" class="img-circle" alt="{{item.who}}" />

            </div>

          </div>
        </div>

      </div>

    <br>
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

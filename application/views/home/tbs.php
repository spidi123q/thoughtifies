
<div ng-controller="ToolbarSearch">
  <div layout="column" layout-align="center center" layout-margin>
    <div layout="column"  layout-align="center center" ui-scroll="item in datasource" adapter="adapter on ToolbarSearch" >
        <post-view-card info="item" style="width:520px"></post-view-card>
    </div>
    <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
    <div class="empty_msg" ng-if="adapter.isEmpty() && !adapter.isLoading">
      No result
    </div>
  </div>
</div>

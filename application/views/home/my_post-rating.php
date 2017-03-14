
  <div ng-controller="MyPostRating" layout="row" layout-align="center center" >

    <div layout="column" layout-align="center center" style="width:100%">
      <div ui-scroll="item in datasource" adapter="adapter on MyPostRating" >
        <rated-usercard ></rated-usercard>
      </div>
      <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
    </div>
  <br><br>
  </div>

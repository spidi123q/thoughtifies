


  <md-content layout="column" layout-align="center center" ng-controller="Search as ctrl" >
    <br>

    <div layout-gt-xs="column" layout-xs="column" layout-align="space-between center">

        <div lauout-xs="column" layout-gt-xs="row" layout-align="center center">
          <div layout="row" layout-padding layout-align="start center">
            <md-switch ng-change="startSearch()" ng-model="searchData.data.photo" aria-label="Switch 1">
              photo
            </md-switch>
            <md-switch ng-change="startSearch()" ng-model="searchData.data.online" aria-label="Switch 2">
              online
            </md-switch>
          </div>
          <md-input-container flex-offset="10"  >
                    <label>{{searchData.title.country}}</label>
                    <md-select ng-change="startSearch()" ng-model="searchData.data.country">
                      <md-option  value="Any">
                        Any
                      </md-option>
                      <md-option ng-repeat="item in countries" value="{{item}}">
                        {{item}}
                      </md-option>
                    </md-select>
          </md-input-container>

        </div>
        <div class="md-secondary" layout-xs="column" layout-gt-xs="row" layout-align-gt-xs="space-between center" layout-align-xs="center center"  layout-margin>
            <md-autocomplete
           ng-disabled="ctrl.isDisabled2"
           md-no-cache="ctrl.noCache2"
           md-selected-item="ctrl.selectedItem2"
           md-search-text-change="ctrl.searchTextChange2(ctrl.searchText)"
           md-search-text="ctrl.searchText2"
           md-selected-item-change="ctrl.selectedItemChange2(item)"
           md-items="item in ctrl.querySearch2(ctrl.searchText)"
           md-item-text="item.label"
           md-min-length="0"
           placeholder="Search keyword">
         <md-item-template>
           <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.label}}</span>
         </md-item-template>
         <md-not-found>
           No states matching "{{ctrl.searchText}}" were found.
           <a ng-click="ctrl.newState2(ctrl.searchText)">Create a new one!</a>
         </md-not-found>
       </md-autocomplete>

            <md-autocomplete
           ng-disabled="ctrl.isDisabled"
           md-no-cache="ctrl.noCache"
           md-selected-item="ctrl.selectedItem"
           md-search-text-change="ctrl.searchTextChange(ctrl.searchText)"
           md-search-text="ctrl.searchText"
           md-selected-item-change="ctrl.selectedItemChange(item)"
           md-items="item in ctrl.querySearch(ctrl.searchText)"
           md-item-text="item.label"
           md-min-length="0"
           placeholder="Search name">
         <md-item-template>
           <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.label}}</span>
         </md-item-template>
         <md-not-found>
           No states matching "{{ctrl.searchText}}" were found.
           <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
         </md-not-found>
       </md-autocomplete>
        </div>

    </div>

      <rzslider layout="row" rz-slider-model="slider.min"
      rz-slider-high="slider.max"
      rz-slider-options="slider.options">
      </rzslider>
    <div layout="row" >
          <div flex  >
                <div layout="column" layout-align="center center">
                  <div ui-scroll="item in datasource"  adapter="adapter on Search">
                   <usercard  index="$index" adapter="adapter" info="item"></usercard>
                  </div>
                  <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
                  <div class="empty_msg" ng-if="adapter.isEmpty() && !adapter.isLoading">
                    No result
                  </div>
                  <div class="">
                    <br><br>
                  </div>
                </div>

          </div>
  </div>

</md-content>

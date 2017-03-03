


  <div layout="column" layout-align="center center" ng-controller="Search as ctrl" >
    <br>

    <div layout-gt-xs="column" layout-xs="column" layout-align="space-around center">

        <div layout="row" layout-align="space-around center" layout-padding >
          <md-switch ng-change="startSearch()" ng-model="searchData.data.photo" aria-label="Switch 1">
            photo
          </md-switch>
          <md-switch ng-change="startSearch()" ng-model="searchData.data.online" aria-label="Switch 2">
            online
          </md-switch>
          <md-input-container  >
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
        <div class="md-secondary" layout="row" layout-align="space-around center"  layout-padding>
          <md-input-container flex-offset="15">
            <label>{{searchData.title.keyword}}</label>
            <input ng-change="startSearch()" ng-model="searchData.data.keyword">
          </md-input-container>
          
          <div >
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

    </div>

      <rzslider layout="row" rz-slider-model="slider.min"
      rz-slider-high="slider.max"
      rz-slider-options="slider.options">
      </rzslider>
    <div layout="row" >
          <div flex  >
                <div layout="column" layout-align="center center">
                  <div ui-scroll="item in datasource" adapter="adapter on Search">
                   <usercard info="item"></usercard>
                  </div>
                  <md-progress-circular ng-if="adapter.isLoading" md-mode="indeterminate" md-diameter="30"></md-progress-circular>
                  <div class="">
                    <br><br>
                  </div>
                </div>

          </div>
  </div>

</div>

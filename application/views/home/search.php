


  <div layout="column" layout-align="center center" ng-controller="Search" >
    <br>

    <div layout-gt-xs="row" layout-xs="column" layout-align="center center">

        <div layout="row" layout-padding >
          <md-switch ng-change="startSearch()" ng-model="searchData.data.photo" aria-label="Switch 1">
            photo
          </md-switch>
          <md-switch ng-change="startSearch()" ng-model="searchData.data.online" aria-label="Switch 2">
            online
          </md-switch>

        </div>
        <div class="md-secondary" layout="row"  layout-padding>
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
          <md-input-container flex-offset="15">
            <label>{{searchData.title.keyword}}</label>
            <input ng-change="startSearch()" ng-model="searchData.data.keyword">
          </md-input-container>
        </div>

    </div>

      <rzslider layout="row" rz-slider-model="slider.min"
      rz-slider-high="slider.max"
      rz-slider-options="slider.options">
      </rzslider>
    <div layout="row" >
          <div flex  >
                <ul>
                  <div ui-scroll="item in datasource" adapter="adapter on Search">
                   <usercard info="item"></usercard>

                  </div>
                </ul>
          </div>
  </div>
</div>

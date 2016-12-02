<md-input-container class="md-block" flex-gt-sm>
          <label>{{settingsData.tabs.profile.info.country.name}}</label>
          <md-select ng-model="user.tabs.profile.info.country.data">
            <md-option ng-repeat="item in user.countries" value="{{item}}">
              {{item}}
            </md-option>
          </md-select>
</md-input-container>

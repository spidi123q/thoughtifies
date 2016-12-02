<md-input-container class="md-block" flex-gt-sm>
          <label>{{settingsData.tabs.profile.info.gender.name}}</label>
          <md-select ng-model="user.gender">
            <md-option ng-repeat="item in settingsData.tabs.profile.info.gender.value" value="{{item}}">
              {{item}}
            </md-option>
          </md-select>
</md-input-container>

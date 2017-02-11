<md-input-container class="md-block" flex-gt-sm>
          <label>{{settingsData.tabs.profile.info.ph.name}}</label>
          <input name="phone" ng-model="user.tabs.profile.info.ph.data" ng-pattern="/^[0-9]{10}$/" />

          <div class="hint" ng-show="showHints">(###) ###-####</div>

          <div ng-messages="userForm.phone.$error" ng-hide="showHints">
            <div ng-message="pattern">(###) ###-#### - Please enter a valid phone number.</div>
          </div>
</md-input-container>

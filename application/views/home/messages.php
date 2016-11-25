<div layout="row">

    <div flex ng-controller="debug" >
      <md-content  flex="70" layout="row">
        <md-content flex ui-scroll-viewport>
			<ul>
				<div ui-scroll="item in listMessengers">
            <md-list-item class="md-3-line" ng-click="null">
               <img ng-src="https://material.angularjs.org/latest/img/icons/angular-logo.svg" class="md-avatar" alt="" />
               <div class="md-list-item-text" layout="column">
                 {{item.fname}}
               </div>
         </md-list-item>
        </div>
			</ul>


        </md-content>
      </md-content>
<br>
  </div>

  <div flex="60" hide-xs>
    fffffffffffffffff



  </div>
</div>

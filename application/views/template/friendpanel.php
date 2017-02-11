
    <md-button class="md-icon-button md-accent" aria-label="Favorite" ng-disabled="actions.request.disabled" ng-click="actions.requestButton()">
      <i class="material-icons" ng-hide="actions.request.progress">{{actions.request.icon}}</i>
      <md-progress-circular md-mode="indeterminate" ng-hide="!actions.request.progress" md-diameter="20px">
      </md-progress-circular>
    </md-button>
    <md-menu>
         <md-button  class="md-icon-button md-accent" ng-click="actions.openMenu($mdOpenMenu, $event)">
             <i class="material-icons">more_vert</i>
         </md-button>
         <md-menu-content>
           <md-menu-item>
             <md-button ng-click="ctrl.redial($event)">
               <i class="material-icons">{{actions.block.icon}}</i>
               Block
             </md-button>
           </md-menu-item>
           <md-menu-item>
             <md-button ng-click="ctrl.redial($event)">
               <i class="material-icons">message</i>
               Message
             </md-button>
           </md-menu-item>
         </md-menu-content>
       </md-menu>

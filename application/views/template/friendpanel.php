<section md-whiteframe="1" layout="row" layout-align="center center">
    <md-button class="md-icon-button md-accent" aria-label="Favorite" ng-click="requestButton()">
      <i class="material-icons" ng-hide="buttons.request.progress">{{buttons.request.icon}}</i>
      <md-progress-circular md-mode="indeterminate" ng-hide="!buttons.request.progress" md-diameter="20px">
      </md-progress-circular>
    </md-button>
    <md-menu>
         <md-button  class="md-icon-button md-accent" ng-click="openMenu($mdOpenMenu, $event)">
             <i class="material-icons">more_vert</i>
         </md-button>
         <md-menu-content>
           <md-menu-item>
             <md-button ng-click="ctrl.redial($event)">
               <i class="material-icons">{{button.block.icon}}</i>
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
</section>

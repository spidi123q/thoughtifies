
    <md-button md-menu-origin="" class="md-icon-button md-accent" aria-label="Favorite" ng-disabled="actions.request.disabled" ng-click="actions.requestButton()">
      <md-icon md-font-library="material-icons">{{actions.request.icon}}</md-icon>
      <md-progress-circular md-mode="indeterminate" ng-hide="!actions.request.progress" md-diameter="20px">
      </md-progress-circular>
    </md-button>
    <md-menu ng-if="!addOnly">
         <md-button   class="md-icon-button md-accent" ng-click="actions.openMenu($mdOpenMenu, $event)">
             <i md-menu-align-target="" class="material-icons">more_vert</i>
         </md-button>
         <md-menu-content>
           <md-menu-item>
             <md-button ng-click="showConfirm($event,0)">
               <md-icon md-font-library="material-icons" class="md-light md-48">{{actions.block.icon}}</md-icon>
               Block
           </md-button>
           </md-menu-item>
           <md-menu-item>
             <md-button ng-click="actions.msgButton($event)">
              <md-icon md-font-library="material-icons" class="md-light md-48">message</md-icon>
               Message
             </md-button>
           </md-menu-item>
           <md-menu-item ng-if="actions.request.icon === 'done'">
             <md-button ng-click="showConfirm($event,1)">
              <md-icon md-font-library="material-icons" class="md-light md-48">clear</md-icon>
               Unfriend
             </md-button>
           </md-menu-item>
           <md-menu-item ng-if="actions.pending">
             <md-button ng-click="accept()">
              <md-icon md-font-library="material-icons" class="md-light md-48">done</md-icon>
               Accept
             </md-button>
           </md-menu-item>
           <md-menu-item ng-if="actions.pending">
             <md-button ng-click="reject()">
              <md-icon md-font-library="material-icons" class="md-light md-48">clear</md-icon>
               Reject
             </md-button>
           </md-menu-item>
         </md-menu-content>
       </md-menu>

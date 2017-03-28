
  <md-card >
         <md-card-header ng-if="!mydp">
           <md-card-avatar>
             <a href="#/users/{{item.mem_id}}">
            <img class="md-user-avatar" image-fetch img-src="{{item.dp}}" ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" size="60"/>
            </a>
           </md-card-avatar>
           <md-card-header-text>
             <span class="md-title"><a href="#/users/{{item.mem_id}}">{{item.fname}} {{item.lname}}</a></span>
             <span class="md-subhead">{{item.tag}}</span>
           </md-card-header-text>
            <md-menu class="md-secondary">
              <md-button class="md-icon-button" ng-click="openMenu($mdOpenMenu, $event)">
                <md-icon md-font-library="material-icons" class="md-light md-48">more_vert</md-icon>
              </md-button>
                  <md-menu-content width="2">
                    <md-menu-item ng-if="item.mem_id === sessid">
                      <md-button ng-click="showConfirm()">
                        <md-icon md-font-library="material-icons" class="md-light md-48">delete</md-icon>
                        Delete
                      </md-button>
                    </md-menu-item>
                    <md-menu-item>
                      <md-button ng-click="showPrompt($event)">
                        <md-icon md-font-library="material-icons" class="md-light md-48">pan_tool</md-icon>
                        Report
                      </md-button>
                    </md-menu-item>
                  </md-menu-content>
        </md-menu>
         </md-card-header>
         <img ng-if="item.image !== null" ng-src="<?php echo base_url() ;?>images/userimages/posts/{{item.image}}.jpg" class="md-card-image" alt="Washed Out">
         <md-card-content>
           <p>
             <span ng-bind-html="item.content" ></span>
           </p>
         </md-card-content>
         <md-card-actions layout="row" layout-align="start center">
           <jk-rating-stars max-rating="5" rating="item.my_rating" read-only="false" on-rating="onRating(rating,item.id)" >
           </jk-rating-stars>
           <md-card-icon-actions>
           </md-card-icon-actions>
         </md-card-actions>

       </md-card>

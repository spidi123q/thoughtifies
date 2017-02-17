
  <md-card >
         <md-card-header>
           <md-card-avatar>
             <img class="md-user-avatar" src="{{item.dp}}"/>
           </md-card-avatar>
           <md-card-header-text>
             <span class="md-title">{{item.fname}} {{item.lname}}</span>
             <span class="md-subhead">{{item.tag}}</span>
           </md-card-header-text>
            <md-button class="md-icon-button">
              <i class="material-icons">more_vert</i>
            </md-button>
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

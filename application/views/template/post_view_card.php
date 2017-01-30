<md-card>
       <md-card-header>
         <md-card-avatar>
           <img class="md-user-avatar" src="https://material.angularjs.org/latest/img/100-2.jpeg"/>
         </md-card-avatar>
         <md-card-header-text>
           <span class="md-title">User</span>
           <span class="md-subhead">subhead</span>
         </md-card-header-text>
          <md-button class="md-icon-button">
            <i class="material-icons">more_vert</i>
          </md-button>
       </md-card-header>
       <img ng-src="https://material.angularjs.org/latest/img/washedout.png" class="md-card-image" alt="Washed Out">
       <md-card-content>
         <p>
           The titles of Washed Out's breakthrough song and the first single from Paracosm share the
           two most important words in Ernest Greene's musical language: feel it. It's a simple request, as well...
         </p>
       </md-card-content>
       <md-card-actions layout="row" layout-align="start center">
         <jk-rating-stars max-rating="5" rating="ctrl.rating" read-only="false" on-rating="ctrl.onRating(rating)" >
         </jk-rating-stars>
         <md-card-icon-actions>
         </md-card-icon-actions>
       </md-card-actions>

     </md-card>

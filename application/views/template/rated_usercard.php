  <div md-whiteframe="1" class="user_card">
    <div layout-xs="column" layout-gt-xs="row" >
      <a href="#/users/{{item.mem_id}}"><img image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{item.picture}}" size="500" class="md-card-image" alt="Washed Out"></a>
      <div flex-offset="5" layout="column">
        <a href="#/users/{{item.mem_id}}"><span class="md-headline">{{item.fname}}  {{item.lname}}</span></a>
        <div class="rating_card_star">
          <p>rated your post</p>
          <md-button class="md-icon-button" ng-click="viewPost(item.post_id,$event)">
            <md-icon md-font-library="material-icons" class="md-light md-48">remove_red_eye</md-icon>
          </md-button>

          <jk-rating-stars  max-rating="5" rating="item.rating" read-only="true" on-rating="onRating(rating,item.id)">
          </jk-rating-stars>
        </div>
      </div>
    </div>
  </div>

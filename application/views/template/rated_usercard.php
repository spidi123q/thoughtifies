  <div md-whiteframe="1" layout-xs="column" layout-gt-xs="row" class="user_card" >
    <a href="#/users/{{item.mem_id}}"><img image-fetch ng-src="{{item.picture}}" size="500" class="md-card-image" alt="Washed Out"></a>
    <div flex-offset="5" layout="column">
      <a href="#/users/{{item.mem_id}}"><span class="md-headline">{{item.fname}}  {{item.lname}}</span></a>
      <div >
        <p>rated your post
          <md-button class="md-icon-button" ng-click="viewPost(item.post_id,$event)">
          <md-icon md-font-library="material-icons" class="md-light md-48">remove_red_eye</md-icon>
        </md-button>
      </p>
        <jk-rating-stars  max-rating="5" rating="item.rating" read-only="true" on-rating="onRating(rating,item.id)">
        </jk-rating-stars>
      </div>
    </div>
  </div>

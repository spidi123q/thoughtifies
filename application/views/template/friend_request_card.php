<md-card>
    <md-card-title-media>
    <a href="#/users/{{user.mem_id}}">
        <img image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{user.picture}}" size="300" class="md-card-image" alt="Washed Out">
    </a>
    </md-card-title-media>
        <md-card-title>
          <md-card-title-text>
              <a href="#/users/{{user.mem_id}}">
            <span class="md-headline">{{user.fname}} {{user.lname}}</span>
              </a>
          </md-card-title-text>
        </md-card-title>
        <md-card-content>
          <p>
            {{user.tag}}
          </p>

        </md-card-content>
        <md-card-actions layout="row" layout-align="end center">
          <md-button ng-click="reject(user)" class="md-primary md-icon-button">
            <i class="material-icons">clear</i>
          </md-button>
          <md-button class="md-warn md-icon-button" ng-click="accept(user)">
            <i class="material-icons">done</i>
          </md-button>
        </md-card-actions>
  </md-card>


  <md-card>
          <md-card-title-media>
            <a href="#/users/{{info.mem_id}}"><img image-fetch ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" img-src="{{info.picture}}" size="400" class="md-card-image" alt="Washed Out"></a>
          </md-card-title-media>
          <md-card-title>
            <md-card-title-text>
              <div class="name">
                <a href="#/users/{{info.mem_id}}"><span class="md-headline">{{info.fname}} {{info.lname}}</span></a>
              </div>
            </md-card-title-text>
          </md-card-title>
          <md-card-content>
            <div class="tag">
                {{info.tag}}
            </div>
          </md-card-content>
          <md-card-actions layout="row" layout-align="end center">
            <friendpanel layout="row" uid="info.mem_id" index="index" adapter="adapter">
            </friendpanel>
          </md-card-actions>
        </md-card>

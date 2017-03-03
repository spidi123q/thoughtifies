
<md-card >
    <img image-fetch ng-src="{{info.picture}}" size="400" class="md-card-image" alt="Washed Out">
      <md-card-title>
        <md-card-title-text class="user_card">
          <a href="#/users/{{info.mem_id}}">
          <span class="md-headline">{{info.fname}} {{info.lname}}</span>
        </a>
        </md-card-title-text>
      </md-card-title>
      <md-card-content>
        <div layout="row"  layout-align="space-between center">
          <p>
            {{info.tag}}
          </p>
          <md-card-actions layout="row" layout-align="end center">
            <friendpanel layout="row" uid="info.mem_id">
            </friendpanel>
          </md-card-actions>
        </div>
      </md-card-content>
</md-card>

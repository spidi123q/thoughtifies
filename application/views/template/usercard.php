
<md-card>
    <md-card-title>
      <md-card-title-text>
        <span class="md-headline">{{info.fname}} {{info.lname}}</span>
      </md-card-title-text>


  </md-card-title>
        <img ng-src="{{info.picture}}" class="md-card-image" alt="Washed Out">
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

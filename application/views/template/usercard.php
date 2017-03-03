  <div md-whiteframe="1" layout-xs="column" layout-gt-xs="row" class="user_card">
    <img image-fetch ng-src="{{info.picture}}" size="500" class="md-card-image" alt="Washed Out">
    <div flex-offset="5" layout="column">
      <span class="md-headline">{{info.fname}} {{info.lname}}</span>
      <p>
        {{info.tag}}hhhhh h     hhhhhhhhhhhhh sssssss sssssssss s
      </p>
    </div>
      <friendpanel layout-xs="row"  layout-gt-xs="column" uid="info.mem_id">
      </friendpanel>
  </div>

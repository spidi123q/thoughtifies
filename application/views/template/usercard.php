  <div md-whiteframe="1" layout-xs="column" layout-gt-xs="row" class="user_card">
    <a href="#/users/{{info.mem_id}}"><img image-fetch ng-src="{{info.picture}}" size="500" class="md-card-image" alt="Washed Out"></a>
    <div flex-offset="5" layout="column">
      <a href="#/users/{{info.mem_id}}"><span class="md-headline">{{info.fname}} {{info.lname}}</span></a>
      <p>
        {{info.tag}}hhhhh h     hhhhhhhhhhhhh sssssss sssssssss s
      </p>
    </div>
      <friendpanel layout-xs="row"  layout-gt-xs="column" uid="info.mem_id" index="index" adapter="adapter">
      </friendpanel>
  </div>

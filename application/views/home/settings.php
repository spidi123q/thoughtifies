<div layout="column" ng-controller="Settings">
  <div flex="35" layout="row"  layout-align="center center">
        <div layout="row">
          <div layout="row"  layout-align="end end" style="z-index: 10;position: absolute;">

            <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,0)" aria-label="call">
              <i class="material-icons">create</i>
            </md-button>

          </div>
          <img flex="40" md-whiteframe="3" height="150" width="200"   alt="" src="http://www.freedigitalphotos.net/images/img/homepage/87357.jpg" alt="">
          <div flex-offset="10" flex layout="column" layout-align="center center">
              <div layout="row">
                <h3>{{settingsData.fname}} {{settingsData.lname}}</h3>
                <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,1)" aria-label="call">
                  <i class="material-icons">create</i>
                </md-button>
              </div>
              <div layout="row">
                <h5>{{settingsData.tag}}</h5>
                <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,2)" aria-label="call">
                  <i class="material-icons">create</i>
                </md-button>
              </div>
          </div>
        </div>


  </div>
  <div flex ng-cloak>
    <md-content>
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="{{settingsData.tabs.profile.name}}">
          <md-content layout="row" class="md-padding" layout-align="center center">
            <div layout="column"  flex-sm="80"  flex-gt-sm="50">
                    <md-list>
                      <md-list-item  class="md-3-line" ng-repeat="item in settingsData.tabs.profile.info" >
                        <img ng-src="<?php echo base_url(); ?>images/{{item.icon}}" class="md-avatar" alt="{{item.who}}">
                        <div class="md-list-item-text">
                          <p>
                            {{item.name}}
                            <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,$index+3)" aria-label="call">
                              <i class="material-icons">create</i>
                            </md-button>
                          </p>
                          <h3></h3>
                          <div>{{item.data}}</div>

                        </div>
                        <md-divider md-inset ng-if="!$last"></md-divider>
                      </md-list-item>
                    </md-list>
            </div>



          </md-content>
        </md-tab>
        <md-tab label="{{settingsData.tabs.photos.name}}">
          <md-content class="md-padding">
            <h1 class="md-display-2">Tab Two</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
            <p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
            <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
          </md-content>
        </md-tab>
        <md-tab label="{{settingsData.tabs.settings.name}}">
          <md-content class="md-padding">
            <h1 class="md-display-2">Tab Three</h1>
            <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
</div>

<div layout="column">
  <div flex="35" layout="row" layout-xs="column"  layout-align="center center" layout-align-xs="space-between center">
        <div layout="row">
          <div layout="row"  layout-align="end end" style="z-index: 10;position: absolute;">

            <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,0)" aria-label="call">
              <i class="material-icons">create</i>
            </md-button>

          </div>
          <img flex="40" md-whiteframe="3"   alt="" src="http://www.freedigitalphotos.net/images/img/homepage/87357.jpg" alt="" style="max-width: 150;
    max-height: 150;">
          <div flex-offset="10" flex layout="column" layout-align="center center">
              <div layout="row">
                <h3>{{settingsData.fname}} {{settingsData.lname}}</h3>
                <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,1)" aria-label="call">
                  <i class="material-icons">create</i>
                </md-button>
              </div>
              <div layout="row"  layout-xs="column">
                  <h5>{{settingsData.tag}}dddddddddd ddd dddd ddddddddddd</h5>
                  <md-button ng-if="settingsData.config" class="md-secondary md-icon-button" ng-click="getDialog($event,2)" aria-label="call">
                    <i class="material-icons">create</i>
                  </md-button>

              </div>
          </div>
        </div>
<br>
        <div ng-if="!settingsData.config">
          <section md-whiteframe="1" layout="row" layout-align="center center">
            <friendpanel uid="uid"></friendpanel>
          </section>
        </div>
  </div><br>
  <div flex ng-cloak>
    <md-content>
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="{{settingsData.tabs.profile.name}}">
          <md-content layout="row" class="md-padding" layout-align="center center">
            <div layout="column"  flex-sm="80"  flex-gt-sm="50">
                    <md-list>
                      <md-list-item  class="md-3-line" ng-repeat="item in settingsData.tabs.profile.info" >
                        <img ng-src="<?php echo base_url(); ?>images/{{item.icon}}" class="md-avatar" alt="{{item.who}}" >
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
            <div  ng-include="dialog/2">
            </div>
    <div class="popover-demo-container">
  		<span class="button ng-popover-trigger" id="normal-popover">Popover with Text</span>
  		<span class="button ng-popover-trigger" id="heading-popover">Popover with Heading</span>
  		<span class="button ng-popover-trigger" id="custom-popover">Popover with Custom Template</span>
      <span class="button ng-popover-trigger" id="kkkk">kkkkplate</span>
  	</div>
    <ng-popover trigger="kkkk" popover-class="normal-text-popover" direction="left" on-open="openCallback('text popover')" on-close="closeCallbacl('text popover')">
<div  ng-include="dialog/2">
</div>
    </ng-popover>
  	<ng-popover trigger="normal-popover" popover-class="normal-text-popover" direction="left" on-open="openCallback('text popover')" on-close="closeCallbacl('text popover')">
  		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur nulla incidunt provident quibusdam laborum suscipit. Vel laborum cupiditate, harum hic error ipsum dolorum, facilis culpa quo tenetur fugit eveniet illum.
  	</ng-popover>
  	<ng-popover trigger="heading-popover" popover-class="heading-popover" direction="top" on-open="openCallback('heading popover')" on-close="closeCallback('heading popover')">
  		<h4>This text is inside an &lt;h4&gt; tag!</h4>
  	</ng-popover>
  	<ng-popover trigger="custom-popover" popover-class="custom-popover" on-open="openCallback('template popover')" on-close="closeCallback('template popover')">
  	    <div class="condition-popover">
  	      	<div class="popover-header">
  	        	<div class="popover-header-content clearfix">
  	          		<div class="title">
  	            		Field
  	          		</div>
  	          		<div class="options">
  	            		<div class="option">
  	              			<input type="radio" id="opt1" name="option">
  	              			<label for="opt1">Label</label>
  	            		</div>
  	            		<div class="option">
  			              <input type="radio" id="opt2" name="option">
  			              <label for="opt2">Label</label>
  			            </div>
  			            <div class="option">
  			        	    <input type="radio" id="option3" name="option">
  			            	<label for="option3">Label</label>
  			            </div>
  	          		</div>
  	        	</div>
  	      	</div>
  	      	<div class="popover-body">You can do some super crazy stuff here and this popover wont break.<br> <span>Believe it!</span></div>
  	      	<div class="popover-footer text-right">
  	      		<span class="button" ng-click="closePopover('custom-popover')">Cancel</span>
  	      		<span class="button" ng-click="closePopover('custom-popover')">Okay</span>
  	      	</div>
  	    </div>
  	</ng-popover>
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

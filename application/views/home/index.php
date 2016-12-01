<html lang="en" >
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Angular Material style sheet -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>node_modules/angular-material/angular-material.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>js/node_modules/angular-ui-scroll/demo/css/style.css" type="text/css"/>
</head>
<body ng-app="BlankApp" ng-cloak ng-controller="AppCtrl" style="overflow-y:hidden">
  <div id="splash" ng-cloak ng-hide="bootscreen">
        <h2>Loading</h2>
     </div>

	<md-toolbar style="z-index:999; position: fixed;box-shadow: 0px 5px 5px grey;">
				<div class="md-toolbar-tools">
							 <md-fab-speed-dial md-open="menu.isOpen" md-direction="down"
																	ng-class="menu.selectedMode" class="md-scale md-raised md-fab-top-left">
								 <md-fab-trigger>
									 <md-button aria-label="menu" class="md-fab md-warn">
										 <i class="material-icons">dashboard</i>
									 </md-button>
								 </md-fab-trigger>

								 <md-fab-actions>
                   <md-button  href="#/" aria-label="Home" class="md-fab md-raised md-mini">
									 </md-button>
									 <md-button  href="#/messages" aria-label="Twitter" class="md-fab md-raised md-mini">
										 <i class="material-icons">message</i>
									 </md-button>
									 <md-button  href="#/request" aria-label="Facebook" class="md-fab md-raised md-mini">
										 <md-icon md-svg-src="" aria-label="Facebook"></md-icon>
									 </md-button>
									 <md-button  href="#/profile" aria-label="Google Hangout" class="md-fab md-raised md-mini">
										 <md-icon md-svg-src="" aria-label="Google Hangout"></md-icon>
									 </md-button>
								 </md-fab-actions>
							 </md-fab-speed-dial>
					<span flex></span>

				</div>
			</md-toolbar>

       <md-content ng-controller="chatInit" layout-padding >
      <div layout="row" style="height: 100%;" ng-cloak>
        <section layout="row" flex >

     <md-sidenav flex class="md-sidenav-left" md-component-id="left"
                 md-disable-backdrop md-whiteframe="4">

       <md-toolbar class="md-theme-indigo">
         <h1 class="md-toolbar-tools">Disabled Backdrop</h1>
       </md-toolbar>

       <md-content layout-margin  >
         <md-list flex>
         <md-subheader class="md-no-sticky">
           <md-button ng-click="closeLeft()" class="md-accent">
             Close this Sidenav
           </md-button>
         </md-subheader>
         <md-list-item class="md-3-line" ng-repeat="user in list[0]" ng-click="null">
           <img ng-src="" class="md-avatar" alt="{{user.fname}}" />
           <div class="md-list-item-text" layout="column">
             <h3>{{ user.fname }} {{user.lname}}</h3>
           </div>
         </md-list-item>
       </md-list>

            </md-content>
     </md-sidenav>


   <div style="outline: none;
       border: 0;" flex layout-padding>
<br><br>
<!--
<md-button ng-click="t()" class="md-fab md-primary" aria-label="Chat">
         <i class="material-icons ">perm_contact_calendar</i>
 </md-button>-->
    <div ng-view layout-align="center center">

    </div>

  </div>
</div>

						</div>
 </md-content>

  <md-button ng-click="toggleLeft()" style="position: fixed;
    z-index: 999;" class="md-fab md-fab-bottom-right md-primary" aria-label="Chat">
           <i class="material-icons ">perm_contact_calendar</i>
   </md-button>









  <!-- Angular Material requires Angular.js Libraries -->
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-route.js" charset="utf-8"></script>
    <script src="https://cdn.rawgit.com/AngularClass/angular-websocket/v2.0.0/dist/angular-websocket.min.js" charset="utf-8"></script>
  <script src="<?php echo base_url(); ?>js/node_modules/angular-ui-scroll/dist/ui-scroll.js"></script>
  	<script src="<?php echo base_url(); ?>js/node_modules/angular-ui-scroll/dist/ui-scroll-jqlite.js"></script>

  <!-- Angular Material Library -->
  <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>

  <!-- Your application bootstrap  -->
  <script type="text/javascript" src="<?php echo base_url() ;?>js/app.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</body>
<style media="screen">
.fabSpeedDialdemoBasicUsage .text-capitalize {
text-transform: capitalize; }

.fabSpeedDialdemoBasicUsage .md-fab:hover, .fabSpeedDialdemoBasicUsage .md-fab.md-focused {
background-color: #000 !important; }

.fabSpeedDialdemoBasicUsage p.note {
font-size: 1.2rem; }

.fabSpeedDialdemoBasicUsage .lock-size {
min-width: 300px;
min-height: 300px;
width: 300px;
height: 300px;
margin-left: auto;
margin-right: auto; }
</style>
</html>

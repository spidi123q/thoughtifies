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

	<md-toolbar style="z-index:500; position: fixed;box-shadow: 0px 5px 5px grey;">
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
                   <md-button  href="#/search" aria-label="Twitter" class="md-fab md-raised md-mini">
										 <i class="material-icons">message</i>
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

          <md-autocomplete flex-offset-xs="30" flex-offset-sm="15" flex-offset-gt-sm="10" flex
          ng-disabled="ctrl.isDisabled"
          md-no-cache="ctrl.noCache"
          md-selected-item="ctrl.selectedItem"
          md-search-text-change="ctrl.searchTextChange(ctrl.searchText)"
          md-search-text="ctrl.searchText"
          md-selected-item-change="ctrl.selectedItemChange(item)"
          md-items="item in ctrl.querySearch(ctrl.searchText)"
          md-item-text="item.display"
          md-min-length="0"
          placeholder="Search for anything"
          >
        <md-item-template>
          <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.display}}</span>
        </md-item-template>
        <md-not-found>
          No states matching "{{ctrl.searchText}}" were found.
          <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
        </md-not-found>
      </md-autocomplete>
      <span flex-sm="30" flex-gt-sm="25"></span>
      <md-button class="md-icon-button" aria-label="Favorite">
            <i class="material-icons">search</i>
        </md-button>
				</div>
			</md-toolbar>


   <md-content ng-controller="chatInit" layout-padding ui-scroll-viewport scroll-glue-top>
      <div layout="row" style="height: 100%;" ng-cloak>
        <section layout="row" flex >

     <md-sidenav flex class="md-sidenav-left" md-component-id="left"
                 md-whiteframe="4">

       <md-toolbar class="md-theme-indigo">
         <h1 class="md-toolbar-tools">Disabled Backdrop</h1>
       </md-toolbar>

       <md-content layout-margin  >
         <md-list flex>
         <md-subheader class="md-no-sticky">
           <md-button ng-click="clickToOpen()" class="md-accent">
             Close this Sidenav
           </md-button>
         </md-subheader>
         <md-list-item class="md-1-line" ng-repeat="user in list[0]" ng-click="showAdvanced($event,user.mem_id)">
           <img ng-src="" class="md-avatar" alt="{{user.fname}}" />
           <div class="md-list-item-text" layout="column">
             <p>{{ user.fname }} {{user.lname}}</p>
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

  <md-button ng-hide="chatButton.chat.isOpen" ng-click="chatButton.toggleLeft()" style="position: fixed;
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
  <script src="<?php echo base_url(); ?>node_modules/angular-ui-scroll/dist/ui-scroll.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-ui-scroll/dist/ui-scroll-grid.min.js"></script>
  <script src="<?php echo base_url(); ?>js/angular-file-upload.js"></script>
  <script src="<?php echo base_url(); ?>js/ngImgCrop-master/compile/unminified/ng-img-crop.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angularjs-scroll-glue/src/scrollglue.js"></script>
  <script src="<?php echo base_url(); ?>js/chatbox.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-sanitize/angular-sanitize.min.js"></script>
  <script src="<?php echo base_url(); ?>js/jk-rating-stars/dist/jk-rating-stars.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-linkify/angular-linkify.js"></script>

  <script src="http://twemoji.maxcdn.com/2/twemoji.min.js?2.2.3"></script>
  <script>
    var SESS_MEMBER_ID = "<?php echo $mem_id; ?>";
  </script>


  <script src="<?php echo base_url(); ?>node_modules/angularjs-slider/dist/rzslider.min.js"></script>

  <!-- Angular Material Library -->
  <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
    <script src="<?php echo base_url() ;?>node_modules/angular-contenteditable/angular-contenteditable.js"></script>


  <!-- Your application bootstrap  -->
  <script type="text/javascript" src="<?php echo base_url() ;?>js/app.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-slider/5.8.7/rzslider.min.css"/>


</body>
<style>
.jk-rating-stars-container .button {
  cursor: pointer; }
  .jk-rating-stars-container .button .material-icons {
    font-size: 30px; }

.jk-rating-stars-container .star-button {
   }
  .jk-rating-stars-container .star-button.star-on .material-icons {
    color: #EE9A00; }
  .jk-rating-stars-container .star-button.star-off .material-icons {
    color: #ddd; }
</style>

</html>

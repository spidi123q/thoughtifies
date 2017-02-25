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

	<md-toolbar ng-controller="ToolbarController as ctrl" class="main_toolbar">
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

                  <md-autocomplete ng-class="tbClass" flex-offset-xs="30" flex-offset-sm="15" flex-offset-gt-sm="10" flex
                  ng-disabled="ctrl.isDisabled"
                  md-no-cache="ctrl.noCache"
                  md-selected-item="ctrl.selectedItem"
                  md-search-text-change="ctrl.searchTextChange(ctrl.searchText)"
                  md-search-text="ctrl.searchText"
                  md-selected-item-change="ctrl.selectedItemChange(item)"
                  md-items="item in ctrl.querySearch(ctrl.searchText)"
                  md-item-text="item.label"
                  md-min-length="0"
                  placeholder="Search for anything"
                  md-menu-class="autocomplete-custom-template"
                  >
                <md-item-template>
                  <span ng-if="ctrl.isHash">
                    <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">#{{item.label}}</span>
                  </span>
                  <span ng-if="ctrl.isEmail" >
                    <md-list-item class="md-2-line">
                      <img ng-src="{{item.picture}}" class="md-avatar" alt="{{item.fname}}" />
                      <div class="md-list-item-text" layout="column">
                        <p><span> {{item.label}}</span></p>
                      </div>
                    </md-list-item>
                  </span>
                  <span ng-if="ctrl.isOther">
                    <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.label}}</span>
                  </span>
                </md-item-template>
                <md-not-found>
                  No states matching "{{ctrl.searchText}}" were found.
                  <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
                </md-not-found>
              </md-autocomplete>
              <span ng-class="logoClass" flex-offset-xs="30" flex-offset-sm="15" flex-offset-gt-sm="10" style="padding-bottom:9px">
                <img style="" src="<?php echo base_url(); ?>images/tho_small.png" />
              </span>
              <span flex-xs></span>
              <md-button class="md-icon-button" aria-label="Favorite" ng-click="searchButton()" ng-class="searchButtonClass">
                    <i class="material-icons">search</i>
              </md-button>
        				</div>
        			</md-toolbar>


   <md-content ng-controller="chatInit" layout-padding ui-scroll-viewport scroll-glue-top>
      <div layout="row" style="height: 100%;" ng-cloak>
        <section layout="row" flex >

     <md-sidenav flex class="md-sidenav-left" md-component-id="left" class="chatnav"
                 md-whiteframe="4">

       <md-toolbar class="md-theme-indigo">
         <h1 class="md-toolbar-tools badge1" data-badge="6"></h1>
       </md-toolbar>
       <md-content layout-margin  >
         <md-list flex>
           <md-button ng-click="clickToOpen()" class="md-accent badge1" data-badge="27">
             Close this Sidenav
           </md-button>
           <md-list-item class="md-1-line" ng-repeat="user in list[0]" ng-click="showAdvanced($event,user.mem_id)">
             <img image-fetch ng-src="{{user.picture}}" size="60" class="badge1 md-avatar" alt="{{user.fname}}" data-badge="27" />
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
  <script src="<?php echo base_url(); ?>node_modules/angular/angular.min.js"></script>
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
    var SESS_USERIMAGE = "<?php echo $picture; ?>";
  </script>


  <script src="<?php echo base_url(); ?>node_modules/angularjs-slider/dist/rzslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>node_modules/angularjs-slider/dist/rzslider.min.css"/>
  <!-- Angular Material Library -->
  <script src="<?php echo base_url(); ?>node_modules/angular-material/angular-material.min.js"></script>
  <script src="<?php echo base_url() ;?>node_modules/angular-contenteditable/angular-contenteditable.js"></script>


  <!-- Your application bootstrap  -->
  <script type="text/javascript" src="<?php echo base_url() ;?>js/app.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/index.css">


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
.autocomplete-custom-template li {
  height: auto;
  padding-top: 8px;
  padding-bottom: 8px;
  white-space: normal;
}
.autocomplete-custom-template li:last-child {
  border-bottom-width: 0;
}
.autocomplete-custom-template .item-title,
.autocomplete-custom-template .item-metadata {
  display: block;
  line-height: 2;
}
.autocomplete-custom-template .item-title md-icon {
  height: 60px;
  width: 60px;
}
</style>

</html>

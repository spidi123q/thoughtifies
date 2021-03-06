<html lang="en" >
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#26A69A" />
    <style rel="prefetch">
        body{
            background-image: url("<?php echo base_url(); ?>images/ripple.gif");
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
  <link rel="icon" href="<?php echo base_url(); ?>images/fav.png">
  <link rel="manifest" href="<?php echo base_url(); ?>manifest.json">
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-97318105-1', 'auto');
        ga('send', 'pageview');

    </script>
  <script>
    var SESS_MEMBER_ID = "<?php echo $mem_id; ?>";
    var SESS_USERIMAGE = "<?php echo $picture; ?>";
    var BASE_URL = "<?php echo base_url(); ?>";
    var CHAT_URL = "<?php echo $chat_url; ?>";
  </script>
    <script src="<?php echo base_url(); ?>node_modules/angular/angular.min.js"></script>
  <title>Thoughtifies</title>
</head>
<body class="home_body" ng-app="BlankApp" ng-cloak ng-controller="AppCtrl" style="overflow-y:hidden" ng-class="disabledClass" >
  <div id="splash" ng-cloak ng-hide="bootscreen">
        <h2>Loading</h2>
     </div>

	<md-toolbar ng-controller="ToolbarController as ctrl" class="main_toolbar">
				<div class="md-toolbar-tools fabSpeedDialdemoBasicUsage">
							 <md-fab-speed-dial  md-open="menu.isOpen" md-direction="down"
																	ng-class="menu.selectedMode" class="md-scale md-raised md-fab-top-left" >
								 <md-fab-trigger>
									 <md-button aria-label="menu" class="md-fab md-warn">
                     <md-icon  md-font-library="material-icons">dashboard</md-icon>
									 </md-button>
								 </md-fab-trigger>

								 <md-fab-actions>
                   <md-button  href="#/" aria-label="Home" class="md-fab md-raised md-mini fab_actions" ng-click="onFabClick()">
                     <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/002-home.svg" alt="" >
                     <md-tooltip md-direction="right" md-visible="tooltipVisible">Home</md-tooltip>
                   </md-button>
                   <md-button  href="#/search" aria-label="Twitter" class="md-fab md-raised md-mini fab_actions" ng-click="onFabClick()">
										 <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/003-search.svg" alt="" >
                     <md-tooltip md-direction="right" md-visible="tooltipVisible">Search People</md-tooltip>
									 </md-button>
									 <md-button  href="#/messages" aria-label="Twitter" class="md-fab md-raised md-mini fab_actions" ng-click="onFabClick()">
                     <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/paper-plane.svg" alt="" >
                     <md-tooltip md-direction="right" md-visible="tooltipVisible">Inbox</md-tooltip>
									 </md-button>
									 <md-button  href="#/profile" aria-label="Google Hangout" class="md-fab md-raised md-mini fab_actions" ng-click="onFabClick()">
  										 <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/004-user.svg" alt="" >
                       <md-tooltip md-direction="right" md-visible="tooltipVisible">My profile & Settings</md-tooltip>
									 </md-button>
								 </md-fab-actions>
							 </md-fab-speed-dial>

                  <md-autocomplete id="tbs_box" ng-class="tbClass" flex-offset-xs="30" flex-offset-sm="15" flex-offset-gt-sm="10" flex-gt-sm="50"
                  ng-disabled="ctrl.isDisabled"
                  md-no-cache="ctrl.noCache"
                  md-autofocus = "true"
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


   <md-content id="scrollview" ng-controller="chatInit" layout-padding ui-scroll-viewport scroll-glue-top >
      <div layout="row" style="height: 100%;" ng-cloak>
        <section layout="row" flex >

     <md-sidenav flex class="md-sidenav-left" md-component-id="left" class="chatnav"
                 md-whiteframe="4" >
       <md-toolbar class="md-theme-indigo">
       </md-toolbar>
       <div layout="row" layout-align="space-around start" style="margin-top: 8px;">
         <md-button  class="md-secondary md-icon-button" href="logout" aria-label="call">
           <md-icon md-font-library="material-icons" class="md-warn">power_settings_new</md-icon>
         </md-button>
       </div>
       <md-content layout-align="end start" layout-margin  >
         <div flex layout="row"  layout-align="space-around start" ng-controller="notiCtrl">
           <div>
             <span ng-hide="msgButton === 0" ng-hide="true"class="badge1" data-badge="{{msgButton}}"></span>
             <md-button class="md-icon-button" aria-label="More" href="#/messages" ng-click="onClick('message',$event)">
              <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/paper-plane.svg" alt="" >
            </md-button>
           </div>
           <div>
             <span ng-hide="handButton === 0" class="badge1" data-badge="{{handButton}}"></span>
               <md-button class="md-icon-button" aria-label="More" href="#/request/0" ng-click="onClick('friend_req',$event)">
                <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/001-hand-shake.svg" alt="">
              </md-button>

           </div>
           <div>
             <span ng-hide="globeButton === 0" class="badge1" data-badge="{{globeButton}}"></span>
             <md-button class="md-icon-button" aria-label="More" href="#/listrating" ng-click="onClick('rating',$event)">
               <img class="notification_icon" src="<?php echo base_url(); ?>images/flaticons/svg/earth-globe.svg" alt="">
             </md-button>
           </div>
         </div>
           <div class="empty_msg" style="margin: 5px">
               Online users
           </div>
         <md-list flex>
           <md-list-item class="md-1-line" ng-repeat="user in list[0]" ng-click="showAdvanced($event,user)">
             <img image-fetch img-src="{{user.picture}}" ng-src="<?php echo base_url(); ?>images/dp_bg.jpg" size="60" class="badge1 md-avatar" alt="{{user.fname}}" data-badge="27" />
             <div class="md-list-item-text" layout="column">
               <p>{{ user.fname }} {{user.lname}}<span ng-hide="( badge.get(user.mem_id) === 0) || (  badge.get(user.mem_id) === undefined )" class="badge1" data-badge="{{badge.get(user.mem_id)}}"></span></p>
             </div>
           </md-list-item>
        </md-list>

        <div class="empty_msg" ng-if="list[0].length === 0 || list === undefined" style="font-size: smaller">
              Empty
        </div>
          <audio-fetch><audio-fetch>
      </md-content>

     </md-sidenav>


   <div style="outline: none;
       border: 0;" flex layout-padding>
<br>
    <div class="main_view" ng-view layout-align="center center" >

    </div>

  </div>
</div>

						</div>
 </md-content>
<span >
  <md-button myfab  id="chat_fab" ng-hide="chatButton" ng-click="toggleLeft()" class="md-fab md-fab-bottom-right md-primary" aria-label="Chat">
           <md-icon  md-font-library="material-icons">perm_contact_calendar</md-icon><span ng-hide="totalNoti === 0" class="badge1" data-badge="{{totalNoti}}"></span>

   </md-button>
</span>










  <!-- Angular Material requires Angular.js Libraries -->
  <script src="<?php echo base_url(); ?>node_modules/angular-animate/angular-animate.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-aria/angular-aria.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-messages/angular-messages.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-route/angular-route.min.js" charset="utf-8"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-websocket/dist/angular-websocket.min.js" charset="utf-8"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-ui-scroll/dist/ui-scroll.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-ui-scroll/dist/ui-scroll-grid.min.js"></script>
  <script src="<?php echo base_url(); ?>js/angular-file-upload.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angularjs-scroll-glue/src/scrollglue.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angular-sanitize/angular-sanitize.min.js"></script>
  <script src="<?php echo base_url(); ?>js/jk-rating-stars/dist/jk-rating-stars.min.js"></script>
    <script src="<?php echo base_url(); ?>js/twemoji.min.js"></script>
  <script src="<?php echo base_url(); ?>node_modules/angularjs-slider/dist/rzslider.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>node_modules/angularjs-slider/dist/rzslider.min.css"/>
  <script src="<?php echo base_url(); ?>js/angular-loading-bar-master/build/loading-bar.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/angular-loading-bar-master/build/loading-bar.min.css"/>
  <script src="<?php echo base_url(); ?>node_modules/ng-croppie/minified/ng-croppie.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>node_modules/ng-croppie/minified/ng-croppie.min.css"/>
  <script src="<?php echo base_url(); ?>node_modules/angular-contenteditable/angular-contenteditable.min.js"></script>

  <!-- Angular Material Library -->
  <script src="<?php echo base_url(); ?>node_modules/angular-material/angular-material.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Angular Material style sheet -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>node_modules/angular-material/angular-material.fixed.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/index.fixed-0.0.3.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>js/app.fixed-0.0.8.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/register_webpush-fixed-0.0.1.js"></script>


</body>


</html>

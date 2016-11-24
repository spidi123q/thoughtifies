
var app = angular.module('BlankApp', ['ngMaterial','ngRoute','ui.scroll', 'ui.scroll.jqlite']);
app.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('teal',{
      'default': '500', // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '200', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '600', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A100' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('deep-orange');
});

app.config(['$routeProvider', function($routeProvider){
                $routeProvider
                .when('/',{templateUrl:'p/0'})
                .when('/messages',{
                  templateUrl:'p/2',
                })
                .when('/request',{template:'This is the fs Route'})
                .when('/profile',{template:'This is the profile Route'})
                .otherwise({redirectTo:'/'});
            }]);

app.factory('listMessengers', ['$log', '$timeout',
		function (console, $timeout) {

			var get = function (index, count, success) {


        var max = 100;
				$timeout(function () {
					var result = [];
          index = index-1;
					for (var i = index; i <= index + count - 1; i++) {
            console.log("index: "+index);
					 if(i < 0 || i > max) {
                        continue;
                    }
						result.push("item #" + i);
					}
					success(result);
				}, 100);
			};

			return {
				get: get
			};
		}
	]);

app.controller('DemoCtrl', function() {

});



app.controller('AppCtrl', function ($scope, $timeout, $mdSidenav,$log) {
  $scope.bootscreen = false;
  $scope.menu = {};
  $scope.menu.isOpen = false;
  $scope.menu.selectedMode = 'md-scale';
  $scope.toggleLeft = buildToggler('left');
  $scope.toggleRight = buildToggler('right');
  $scope.closeLeft = buildToggler('left');
  $scope.closeRight = buildToggler('right');
  $scope.bodyClick = function () {

    if ($mdSidenav('left').isOpen()) {
      console.log("open");
      $scope.closeLeft();
    }
  };


  function buildClose (componentId) {
     // Component lookup should always be available since we are not using `ng-if`
     $mdSidenav(componentId).close()
       .then(function () {
         $log.debug("close "+componentId+" is done");
       });
   }

    function buildToggler(componentId) {
      return function() {
        $mdSidenav(componentId).toggle();
      };
    }

  $scope.bootscreen = true;

  });


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

app.factory('getMsgUsers',['$log', '$timeout','$http','$q',
 function(console, $timeout,$http,$q) {

}]);



app.factory('listMessengers', ['$log', '$timeout','$http','$q',
		function (console, $timeout,$http,$q) {

      var max = 1000;

      var big = -1;
      var page = [];

      var getCount = function (big) {
        var deferred = $q.defer();
        if (big == 0) {

              $http({
                method: 'GET',
                url: 'msg/f/'+6,
              }).then(function successCallback(response) {
                  // this callback will be called asynchronously
                  // when the response is available
                  console.log(response.data);
                  max = response.data.count;
                  deferred.resolve(response);

                }, function errorCallback(response) {
                  // called asynchronously if an error occurs
                  // or server returns response with an error status.
                   deferred.reject({ message: "Really bad" });
                });

        }else {
          deferred.resolve({ message: "no http needed" });
        }
        return deferred.promise;

      };
      var setBig = function(index){

      var deferred = $q.defer();

        if(index > big){
          big = index;
          getCount(big).then(function () {
            $http({
              method: 'GET',
              url: 'msg/f/'+big,
            }).then(function successCallback(response) {
                // this callback will be called asynchronously
                // when the response is available
                console.log(response.data);
                for (var i = 0; i < response.data.length; i++) {
                  page.push(response.data[i]);
                }

                deferred.resolve(response);

              }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                 deferred.reject({ message: "Really bad" });
              });
          });




        }
        else {
          deferred.resolve({ message: "no http needed" });
        }
        return deferred.promise;
      };



			var get = function (index, count, success) {

console.log("cll");
				$timeout(function () {

          index = index-1;
          setBig(index).then(
            function (result) {
                // promise was fullfilled (regardless of outcome)
                // checks for information will be peformed here
                var result2 = [];
                for (var i = index; i <= index + count - 1; i++) {
                  //console.log("index: "+index);
                  //console.log("i = "+i);
                 if(i < 0 || i > max) {
                              continue;
                          }
                          //console.log(page);
                  result2.push(page[i]);
                }
                success(result2);

            },
            function (error) {
                // handle errors here
                console.log(error.statusText);
            }
        );



				},100);

			};

			return {
				get: get
			};
		}
	]);

app.controller('DemoCtrl', function() {

});
app.controller('debug', ['$scope', '$log', function($scope, $log) {
   $scope.greetings = ["Hello", "Bonjour", "Guten tag"];
   console.log("debug created");
   $scope.log = function(message) {
     $log.debug(message);
   }
 }]);


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

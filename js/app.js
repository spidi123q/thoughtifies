
var app = angular.module('BlankApp', ['ngMaterial','ngRoute','ui.scroll', 'ui.scroll.jqlite','ngWebSocket','angularFileUpload']);

app.directive('myCustomer', function() {
  return {
    restrict: 'E',
    template: '<h1>fdsfs</h1>',
  };
});



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
                .when('/profile',{templateUrl:'p/4'})
                .otherwise({redirectTo:'/'});
}]);



app.factory('getMsgUsers',['$log', '$timeout','$http','$q',
 function(console, $timeout,$http,$q) {

}]);

app.factory('MyWebSocket', function($websocket,$http) {
      // Open a WebSocket connection
      var socket,mem_id,response;
      socket = $websocket('ws://localhost:8887');
      var protoSent = {
        init : "7000",
        newmsg  : "7001",
      };

      var init = function () {
        var info = {
          data  : mem_id,
          header  : protoSent.init,
        };
        socket.send(info);
      };

      $http({
        method: 'GET',
        url: 'info/1',
      }).then(function successCallback(response) {
            //console.log(response.data.mem_id);
            mem_id = response.data.mem_id;
            init();

        }, function errorCallback(response) {

        });



      socket.onOpen(function () {
        console.log("connection opened");

      });
      socket.onError(function () {
        console.log("connection error");

      });


      var methods = {
        mem_id  : mem_id,
        response  : response,
        socket  :socket,
        protoSent : protoSent,
      };

      return methods;
    });


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
                  //console.log(response.data);
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
              //  console.log(response.data);
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
				get: get,
        test : function () {
          return max;
        }
			};
		}
	]);

app.controller('msgController', [
		'$scope', '$log', '$timeout','$http','MyWebSocket', function ($scope,console, $timeout,$http,MyWebSocket) {
			var datasource = {};
      console.log($scope.chat);
      MyWebSocket.socket.onMessage(function (message) {
        console.log(message);
      });

			datasource.get = function (index, count, success) {
				$timeout(function () {
					var result = [];
					for (var i = index; i <= index + count - 1; i++) {
            if(i > 0) {
                        continue;
                    }
						result.push("item #" + i);
					}
					success(result);
				}, 100);
			};

			$scope.datasource = datasource;
      $scope.sendMsg = function () {
          var data = {
            receiver : $scope.msgUser,
            message : $scope.msg
          };
          $scope.myuser = angular.copy($scope.msgUser);
          //console.log(data);
            $http({
              method: 'POST',
              url: 'msg/sent',
              data: data,
            }).then(function successCallback(response) {
                //console.log(response.data);
                if (response.data === "1") {
                  var data = {
                    code : MyWebSocket.protoSent.newmsg,
                    data: $scope.myuser,
                  };
                  taskList(data);
                }
              }, function errorCallback(response) {

              });
		};

    var taskList = function (data) {

        if (data.code === MyWebSocket.protoSent.newmsg) {
            console.log("message send success");
            var info = {
              header: MyWebSocket.protoSent.newmsg,
              data: data.data,
            };
            MyWebSocket.socket.send(info);

        }

    };

  }
	]);

app.controller('DemoCtrl', function() {

});
app.controller('chatBox', [
		'$scope', '$log', '$timeout','$http', function ($scope, console, $timeout,$http) {


		}
	]);
app.controller('chatInit', function($scope,$http,MyWebSocket) {
    $scope.chat = MyWebSocket;
    $scope.chat.socket.onMessage(function(message) {
        var msg = JSON.parse(message.data);
        //console.log(msg.header);
        taskList(msg);
    });
    $scope.list = [];

    $scope.t = function () {
        $scope.list.push("gfgdg");
        $scope.list[1] = "5";
    };
    var taskList = function (data) {
      if (data.header == "8000") {
        console.log("refresh chat");
        $http({
          method: 'GET',
          url: 'online/2',
        }).then(function successCallback(response) {
              //console.log(response.data);
              $scope.list = [];
              $scope.list.push(response.data);
              console.log($scope.list);


          }, function errorCallback(response) {

          });

      }
    };
});
app.controller('Settings', ['$scope','$http','$mdDialog','FileUploader',function($scope,$http,$mdDialog,FileUploader) {


          console.log("seetigs");
          $scope.settingsData = {
            tabs : {
              profile  : {
                name : "Profile",
                info  : {
                  aboutme : {
                    name: "ABOUT ME",
                    icon: "flaticons/svg/curriculum.svg"
                  },
                  mypre : {
                    name: "MY PREFRENCES",
                    icon  : "flaticons/svg/color-palatte.svg"
                  },
                  gender : {
                    name: "GENDER",
                    value:  {
                      male : "MALE",
                      female : "FEMALE"
                    },
                  },
                  bday : {
                    name: "BIRTHDAY",
                    icon: "flaticons/svg/birthday-cake.svg"
                  },
                  email : {
                    name: "EMAIL",
                    icon: "flaticons/svg/note.svg"
                  },
                  ph : {
                    name: "PHONE",
                    icon: "flaticons/svg/phone-book.svg"
                  },
                  country : {
                    name: "COUNTRY",
                  },
                },
              },
              photos  : {
                name  : "Photos",
              },
              settings  : {
                name  : "Settings",
              },
            },
            dialog  : {
            },
            config: true,

          };






          $http({
            method: 'GET',
            url: 'settings/get/0',
          }).then(function successCallback(response) {
              // this callback will be called asynchronously
              // when the response is available
              $scope.settingsData.tabs.profile.info.aboutme.data = response.data.about_me;
              $scope.settingsData.tabs.profile.info.mypre.data = response.data.about_partner;
              $scope.settingsData.tabs.profile.info.bday.data = response.data.yy;
              $scope.settingsData.tabs.profile.info.email.data = response.data.email;
              $scope.settingsData.tabs.profile.info.ph.data = response.data.contact;
              $scope.settingsData.tabs.profile.info.country.data = response.data.c_name;
              $scope.settingsData.tabs.profile.info.country.icon = "flags/1x1/"+response.data.country.toLowerCase()+".svg";
              $scope.settingsData.fname = response.data.fname;
              $scope.settingsData.lname = response.data.lname;
              $scope.settingsData.tag = response.data.tag;

              console.log(response.data);
              if (response.data.gender == 'M') {
                $scope.settingsData.tabs.profile.info.gender.data = "Male";
                $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/muscular.svg";
              }else {
                $scope.settingsData.tabs.profile.info.gender.data = "Female";
                $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/femenine.svg";
              }



            }, function errorCallback(response) {
              // called asynchronously if an error occurs
              // or server returns response with an error status.

            });

            $scope.openMenu = function($mdOpenMenu, ev) {
              $mdOpenMenu(ev);
            };
            $scope.showAlert = function(ev) {
    // Appending dialog to document.body to cover sidenav in docs app
    // Modal dialogs should fully cover application
    // to prevent interaction outside of dialog
    $mdDialog.show(
      $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('This is an alert title')
        .textContent('You can specify some description text in here.')
        .ariaLabel('Alert Dialog Demo')
        .ok('Got it!')
        .targetEvent(ev)
    );
  };
  $scope.getDialog = function(ev,sel) {

    var openModal = function () {
            $mdDialog.show({
              controller: DialogController,
              templateUrl: 'dialog/1',
              parent: angular.element(document.body),
              targetEvent: ev,
              clickOutsideToClose:true,
              bindToController  : true,
              locals : {
                settingsData  : $scope.settingsData,
              },
              fullscreen: false // Only for -xs, -sm breakpoints.
            })
            .then(function(answer) {
              $scope.status = 'You said the information was .';
            }, function() {
              $scope.status = 'You cancelled the dialog.';
            });
      };

    var preFetch = function (sel) {
      if (sel == 9) {

        $http({
            method: 'GET',
            url: 'list/countries',

          }).then(function successCallback(response) {
            $scope.settingsData.countries = response.data;
            console.log(response.data);
            openModal();

            }, function errorCallback(response) {

            });


      }else {
        openModal();
      }
    };

    for (var i = 0; i < 10; i++) {
      if(sel === i){
        $scope.settingsData.dialog.url = "dialog/content/"+i;
        $scope.settingsData.click = i;
        preFetch(i);
        break;
      }
    }



    };

      function DialogController($scope, $mdDialog,settingsData) {
        $scope.settingsData = settingsData;
        $scope.settingsData.dialog.progress = true;
        $scope.user = angular.copy(settingsData);
        $scope.user.bday  = new Date();
        $scope.myImage='';
          $scope.myCroppedImage='';
        $scope.upload = {
          progress : true,
        };
        var uploader = $scope.uploader = new FileUploader({
          url: 'settings/upload',
          autoUpload: true,
        });
        // FILTERS

          uploader.filters.push({
              name: 'customFilter',
              fn: function(item /*{File|FileLikeObject}*/, options) {
                  return this.queue.length < 10;
              }
          });

          // CALLBACKS

          uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
              console.info('onWhenAddingFileFailed', item, filter, options);
          };
          uploader.onAfterAddingFile = function(fileItem) {
              console.info('onAfterAddingFile', fileItem);
          };
          uploader.onAfterAddingAll = function(addedFileItems) {
              //console.info('onAfterAddingAll', addedFileItems);
              console.log($scope.uploader.queue[0]._file);
          };
          uploader.onBeforeUploadItem = function(item) {
              console.info('onBeforeUploadItem', item);
              $scope.upload.progress = false;

          };
          uploader.onProgressItem = function(fileItem, progress) {
              console.info('onProgressItem', fileItem, progress);

          };
          uploader.onProgressAll = function(progress) {
              console.info('onProgressAll', progress);
              $scope.upload.status = progress;
          };
          uploader.onSuccessItem = function(fileItem, response, status, headers) {
              console.info('onSuccessItem', fileItem, response, status, headers);
              $scope.upload.progress = true;

          };
          uploader.onErrorItem = function(fileItem, response, status, headers) {
              console.info('onErrorItem', fileItem, response, status, headers);
          };
          uploader.onCancelItem = function(fileItem, response, status, headers) {
              console.info('onCancelItem', fileItem, response, status, headers);
          };
          uploader.onCompleteItem = function(fileItem, response, status, headers) {
              //console.info('onCompleteItem', fileItem, response, status, headers);
              $scope.myImage= "data:image/jpeg;base64,"+response;
          };
          uploader.onCompleteAll = function() {
              console.info('onCompleteAll');
          };

          console.info('uploader', uploader);









        $scope.hide = function() {
          $mdDialog.hide();
        };

        $scope.cancel = function() {
          $mdDialog.cancel();
        };

        $scope.submit = function(sel) {
          $scope.settingsData.dialog.progress = false;
          $scope.settingsData.dialog.type = "indeterminate";
          if(sel == 1){
            $http({
                method: 'POST',
                url: 'settings/5',
                data: JSON.stringify({
                  fname : $scope.user.fname,
                  lname : $scope.user.lname,
                }),

              }).then(function successCallback(response) {
                    //console.log(response.data);
                    if (response.data.status) {
                      $scope.settingsData.fname = $scope.user.fname;
                      $scope.settingsData.lname = $scope.user.lname;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;
                    }
                }, function errorCallback(response) {
                  console.log(response.data);
                  $scope.settingsData.dialog.progress = true;

                });
          }
          else if (sel == 5) {

            var gender;
            var info = settingsData.tabs.profile.info.gender.value;
            if ($scope.user.gender == info.male) {
                gender = "M";
            }else {
              gender = "F";
            }

            $http({
                method: 'POST',
                url: 'settings/6',
                data: JSON.stringify({
                  gender : gender,
                }),

              }).then(function successCallback(response) {
                    console.log(response.data);
                    if (response.data.status) {

                      if (gender === "M") {
                        $scope.settingsData.tabs.profile.info.gender.data = "Male";
                        $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/muscular.svg";
                      }else {
                        $scope.settingsData.tabs.profile.info.gender.data = "Female";
                        $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/femenine.svg";
                      }

                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;

                    }
                }, function errorCallback(response) {
                      console.log(response);
                });

          }
          else if (sel == 6) {

            var data = {
              yy  : $scope.user.bday.getFullYear(),
              mm  : $scope.user.bday.getMonth()+1,
              dd  : $scope.user.bday.getDate(),
            };



            $http({
                method: 'POST',
                url: 'settings/7',
                data: data,

              }).then(function successCallback(response) {
                    console.log(response.data);
                    if (response.data.status) {



                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;

                    }
                }, function errorCallback(response) {
                      console.log(response);
                });


          }
          else if (sel == 9) {


            $http({
                method: 'POST',
                url: 'settings/8',
                data: {
                  country : $scope.user.tabs.profile.info.country.data,
                },

              }).then(function successCallback(response) {
                    console.log(response.data);
                    if (response.data.status) {



                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;

                    }
                }, function errorCallback(response) {
                      console.log(response);
                });


          }



        };
      }





}]);
app.controller('debug', ['$scope', '$log','listMessengers', function($scope, $log,listMessengers) {
   $scope.greetings = ["Hello", "Bonjour", "Guten tag"];
   console.log("fgdfgdfffffff");
   $scope.log = function() {
     listMessengers.test();
   };
   $scope.jj = listMessengers;
   $scope.selectMsgUser = function (user) {
     $scope.msgUser = user;
     console.log($scope.msgUser);
   };

   $scope.msgUserListAdapter = {
     remain: true
   };



   $scope.removeFromList1 = function() {
     console.log("del");
     return $scope.msgUserListAdapter.reload(0);
   };


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
  $scope.jsonToURL = function (data) {
    var str = Object.keys(data).map(function(key){
        return encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
    }).join('&');
    return str;
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

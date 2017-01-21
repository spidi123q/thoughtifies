
var app = angular.module('BlankApp', ['rzModule','ngMaterial','ngRoute','ui.scroll', 'ui.scroll.jqlite','ngWebSocket','angularFileUpload','luegg.directives','ngPopover','angular-popover','contenteditable','ngEmoticons']);




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
                .when('/search',{
                  templateUrl:'p/1',
                })
                .when('/messages',{
                  templateUrl:'p/2',
                })
                .when('/users/:uid',{
                  templateUrl:'p/4',
                  controller : "Users"

                })
                .when('/request',{template:'This is the fs Route',})
                .when('/profile',{
                  templateUrl:'p/4',
                  controller : "Settings"
                })
                .otherwise({redirectTo:'/'});
}]);



app.factory('chatSidenav',['$mdSidenav',function($mdSidenav) {

  var chat = {};
  chat.isOpen = false;
  var menu = {};
  menu.isOpen = false;
  menu.selectedMode = 'md-scale';
  var toggleLeft = buildToggler('left');
  var toggleRight = buildToggler('right');
  var closeLeft = buildToggler('left');
  var closeRight = buildToggler('right');
  var bodyClick = function () {

    if ($mdSidenav('left').isOpen()) {
      console.log("open");
      closeLeft();
    }
  };

  function buildClose (componentId) {
     // Component lookup should always be available since we are not using `ng-if`
     $mdSidenav(componentId).close()
       .then(function () {

       });
   }

    function buildToggler(componentId) {
      return function() {
        $mdSidenav(componentId).toggle();
      };
    }

    chat.hideButton = function () {
      chat.isOpen = true;
    };
    chat.showButton = function () {
      chat.isOpen = false;
    };

    return  {
      chat: chat,
      menu  : menu,
      toggleLeft  : toggleLeft,
    };



}]);

app.factory('dpDisplay', function() {
        var dpDisplay = function(data){
          if (data.receiver == SESS_MEMBER_ID) {
            return false;
          }
          else {
            return true;
          }
        };
        return{
          get : dpDisplay,
        };
    });

    app.factory('friendPanelActions', function($http) {
            var buttons = {
              request : {
                icon : "add",
                val : -1,
                progress : false,
              },
              message : "message",
              block : {
                icon : "block",
                val : -1,
              },
            };

            var openMenu = function($mdOpenMenu, ev) {
              originatorEv = ev;
              $mdOpenMenu(ev);
            };

           var init = function() {
             $http({
               method: 'GET',
               url: 'users/frnd/status/'+buttons.uid,
             }).then(function successCallback(response) {
                   console.log(response.data+"rnd");
                   if (response.data === "0") {
                     buttons.request.icon = "close";
                     buttons.request.val = 0;
                   }
               }, function errorCallback(response) {

               });
           };

            var requestButton = function () {

              buttons.request.progress = true;
                if (buttons.request.val == -1) {
                  $http({
                    method: 'GET',
                    url: 'users/request/'+buttons.uid,
                  }).then(function successCallback(response) {
                        buttons.request.progress = false;
                        if (response.data == "1") {
                          buttons.request.icon = "close";
                          buttons.request.val = 0;
                        }
                    }, function errorCallback(response) {

                    });
                }else {
                  $http({
                    method: 'GET',
                    url: 'users/cancel/'+buttons.uid,
                  }).then(function successCallback(response) {
                      buttons.request.progress = false;
                      if (response.data == "1") {
                        buttons.request.icon = "add";
                        buttons.request.val = -1;
                      }

                    }, function errorCallback(response) {

                    });
                }
            };

            buttons.openMenu = openMenu;
            buttons.requestButton = requestButton;

            var setUser = function (uid) {
              buttons.uid = uid;
            };
            var actions = function () {
              return buttons;
            };
            return{
              setUser : setUser,
              actions : actions,
              init : init,
            };

        });

app.factory('MyWebSocket', function($websocket,$http) {
      // Open a WebSocket connection
      var socket,mem_id,response;
      socket = $websocket('ws://localhost:8887');
      var protoSent = {
        init : "7000",
        newmsg  : "7001",
        sendmsg  : "7002",
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

      socket.onMessage(function () {
        console.log("newmsg");

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
  app.directive('friendpanel', function () {
      return {
          restrict: 'E',
          scope : {
            uid : '=uid'
          },
          controller: ['$scope','$http', function ($scope,$http) {
            $scope.buttons = {
              request : {
                icon : "add",
                val : -1,
                progress : false,
              },
              message : "message",
              block : {
                icon : "block",
                val : -1,
              },
            };

            var openMenu = function($mdOpenMenu, ev) {
              originatorEv = ev;
              $mdOpenMenu(ev);
            };

           var init = function() {
             $http({
               method: 'GET',
               url: 'users/frnd/status/'+$scope.uid,
             }).then(function successCallback(response) {
                   console.log(response.data+"rnd");
                   if (response.data === "0") {
                     $scope.buttons.request.icon = "close";
                     $scope.buttons.request.val = 0;
                   }
               }, function errorCallback(response) {

               });
           };
           init();

            var requestButton = function () {

              $scope.buttons.request.progress = true;
                if ($scope.buttons.request.val == -1) {
                  $http({
                    method: 'GET',
                    url: 'users/request/'+$scope.uid,
                  }).then(function successCallback(response) {
                        $scope.buttons.request.progress = false;
                        if (response.data == "1") {
                          $scope.buttons.request.icon = "close";
                          $scope.buttons.request.val = 0;
                        }
                    }, function errorCallback(response) {

                    });
                }else {
                  $http({
                    method: 'GET',
                    url: 'users/cancel/'+$scope.uid,
                  }).then(function successCallback(response) {
                      $scope.buttons.request.progress = false;
                      if (response.data == "1") {
                        $scope.buttons.request.icon = "add";
                        $scope.buttons.request.val = -1;
                      }

                    }, function errorCallback(response) {

                    });
                }
            };

            $scope.buttons.openMenu = openMenu;
            $scope.buttons.requestButton = requestButton;
            $scope.actions = $scope.buttons;
              }],
          templateUrl:'element/0',
      };
  });
  app.directive('usercard', function () {
      return {
          restrict: 'E',
          scope: {
            info: '=info'
          },
          templateUrl:'element/1',
      };
  });

app.controller('msgController', [
		'$scope', '$log', '$timeout','$http','MyWebSocket','$q','dpDisplay', function ($scope,console, $timeout,$http,MyWebSocket,$q,dpDisplay) {
			var datasource = {};
      var big  = -1,max = 0;
      var page  = [];
      console.log($scope.chat);
      MyWebSocket.socket.onMessage(function (message) {
        console.log(message);
      });

      var getCount = function (big) {
        var deferred = $q.defer();
        if (big === 0) {

              $http({
                method: 'GET',
                url: 'msg/count/'+34,
              }).then(function successCallback(response) {
                  // this callback will be called asynchronously
                  // when the response is available
                  console.log(response.data);
                  max = response.data.count;
                  deferred.resolve(response);

                }, function errorCallback(response) {
                  // called asynchronously if an error occurs
                  // or server returns response with an error status.
                  console.log("count err");
                   deferred.reject({ message: "Really bad" });
                });

        }else {
          deferred.resolve({ message: "no http needed" });
        }
        return deferred.promise;

      };
      var setBig = function(index){
        var deferred = $q.defer();
        index = index*(-1);
        if (index > big) {
          big = index;
          var offset = big-9;
          getCount(offset).then(function (result) {
            //console.log(result);
            $http({
              method: 'POST',
              url: 'msg/get',
              data: {
                offset : offset,
                user: 34,
              },
            }).then(function successCallback(response) {
                //console.log(response.data);
                response.data.forEach(function (item,index) {
                  page.push(item);
                  deferred.resolve(page);
                });


              }, function errorCallback(response) {
                  deferred.resolve(page);
              });
          });

        }else {
          deferred.resolve("ddd");
        }
        return deferred.promise;
      };
			datasource.get = function (index, count, success) {

				$timeout(function () {
					setBig(index).then(function (responce) {
            //console.log(responce);
            var result = [];
  					for (var i = index; i <= index + count - 1; i++) {
  setBig(index);
              if(i > 0 || (i*-1) >= max) {
                          continue;
                      }
                      //console.log(i);
  						    result.push(page[i*-1]);
  					}
  					success(result);
					},    function (error) {
                  // handle errors here
                  console.log(error.statusText);
              });
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
app.controller('Search',['$scope','$timeout','$http','$q', function($scope,$timeout,$http,$q) {
    console.log("search activated");
    var big = -1,page = [];



          $http({
              method: 'GET',
              url: 'list/countries',

            }).then(function successCallback(response) {
              $scope.countries = response.data;
              //console.log(response.data);
              }, function errorCallback(response) {

              });

          $scope.slider = {
              min: 20,
              max: 50,
              options: {
                floor: 10,
                ceil: 130,
                onChange: function () {
                    $scope.startSearch();
                },
              }
            };
            $scope.searchData ={
              title:  {
                country : "Country",
                keyword : "Keyword"
              },
              data: {
                country : "Any",
                photo : false,
                online: false,
                keyword:  "",
              }
            };

            var datasource = {};
            var max = -1;

      			datasource.get = function (index, count, success) {
      				$timeout(function () {
      					var result = [];
                index = index-1;
                setBig(index).then(function (response) {
                  for (var i = index; i <= index + count - 1; i++) {
                    //console.log(index);
                    if(i < 0 || i > max) {
                                continue;
                            }
        						result.push(page[i]);
        					}
        					success(result);
                },function (error) {
                  console.log(error);
                });

      				}, 100);
      			};

      			$scope.datasource = datasource;




            $scope.adapter = {
              remain: true
            };
            $scope.startSearch = function (val) {
               val = typeof val !== 'undefined' ? val : 0;
                  if (val === 0) {
                    big = -1;
                    page = [];
                    return $scope.adapter.reload();
                  }

            };

              $scope.startSearch(1);
              var getCount = function (big) {
                  var deferred = $q.defer();
                  deferred.resolve({ message: "no http needed" });
                  return deferred.promise;
              };
              var setBig = function(index){

              var deferred = $q.defer();

                if(index > big){
                  big = index;
                  console.log(big);


                    $scope.searchData.data.h_age = $scope.slider.max;
                    $scope.searchData.data.l_age = $scope.slider.min;
                    $scope.searchData.data.offset = big;
                    //console.log($scope.searchData.data);
                    max =100;
                    $http({
                        method: 'POST',
                        url: 'search/adv',
                        data: $scope.searchData.data,

                      }).then(function successCallback(response) {
                        //console.log(response.data);
                        response.data.forEach(function (item,index) {
                          page.push(item);
                        });
                        deferred.resolve(response);
                        }, function errorCallback(response) {
                          deferred.reject({ message: "Really bad" });
                        });


                }
                else {
                  deferred.resolve({ message: "no http needed" });
                }
                return deferred.promise;
              };



}]);

app.controller('chatBox', [
		'$scope', '$log', '$timeout','$http','$location', '$anchorScroll', function ($scope, console, $timeout,$http,$location, $anchorScroll) {
      //$scope.gotoBottom();



		}
	]);

app.controller('chatInit', function($scope,$http,MyWebSocket,$mdDialog,chatSidenav) {
    $scope.chat = MyWebSocket;
    $scope.chatMessages = [];

    var msgMap = new Map();

    $scope.chat.socket.onMessage(function(message) {
        var msg = JSON.parse(message.data);
        console.log(msg);
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
      else if (data.header == "8002") {
        console.log("at 8002");
          var msg = JSON.parse(data.data);
          console.log(msg);
          checkUser(msg.sender.toString());
         //msgMap.get(parseInt(msg.sender)).push(msg);
           msgMap.get(msg.sender.toString()).push(msg);
          console.log("after msg sent"+msgMap.get(msg.sender));

      }
    };
    var checkUser = function (mem_id) {

      if (!msgMap.has(mem_id)) {
        msgMap.set(mem_id,[]);
      }

    };
    var insertMapData = function (mem_id,obj) {
      var temp = msgMap.get(mem_id);

    };

    $scope.showAdvanced = function(ev,mem_id) {
      checkUser(mem_id);
      console.log(msgMap);
      var x = msgMap.get(mem_id);

      console.log("content");
      console.log(x);


      var chatButton = chatSidenav.chat;
      chatButton.hideButton();

        $mdDialog.show({
          controller: DialogController,
          templateUrl: 'dialog/2',
          parent: angular.element(document.body),
          targetEvent: ev,
          clickOutsideToClose:false,
          locals : {
            chatButton  : chatButton,
            data  : {
              messages  : msgMap.get(mem_id),
              receiver  : mem_id,
              websocket  : $scope.chat,
            },
          },
          fullscreen: false // Only for -xs, -sm breakpoints.
        })
        .then(function(answer) {
          $scope.status = 'You said the information was "' + answer + '".';

        }, function() {
          $scope.status = 'You cancelled the dialog.';
        });
      };


      function DialogController($scope, $mdDialog,chatButton,data,$location, $anchorScroll,$timeout,$http,$sce) {
          $scope.messages = data.messages;
          console.log($scope.messages);
          $scope.receiver = data.receiver;
          $scope.myvar = [1,2,3,4,5,6,7];
          var socket = data.websocket.socket;
          var protoSent = data.websocket.protoSent;
          $scope.emojiView = true;
          $scope.msgView = !$scope.emojiView;
          $scope.kunna = "dialog/content/1";
          $scope.msg= "jkhjkh";

          //console.log($scope.messages);
          $scope.hide = function() {
            $mdDialog.hide();
            chatButton.showButton();
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
            chatButton.showButton();
          };

          $scope.answer = function(answer) {
            $scope.hide();
          };
          $scope.gotoBottom = function() {
            // set the location.hash to the id of
            // the element you wish to scroll to.
            $location.hash('bottom');

            // call $anchorScroll()
            $anchorScroll();
          };
          $scope.change = function () {
            console.log("dfg");
          };
          $scope.dpDisplay = function(data){
            if (data.receiver == SESS_MEMBER_ID) {
              return false;
            }
            else {
              return true;
            }
          };

          $scope.send = function (msg) {
            $scope.msg = msg;
            var data = {
              message  : msg,
              receiver : $scope.receiver,
            };

            $scope.messages.push(data);
            var info = {
              header  : protoSent.sendmsg,
              data: JSON.stringify(data),
            };
            //console.log(info);
            $scope.msg = null;
            socket.send(info);


          };
          $scope.emojiButton = function () {
              $scope.emojiView = !$scope.emojiView;
              $scope.msgView = !$scope.msgView;
          };
          $scope.checkIfEnterKeyWasPressed = function($event,scope){
            var keyCode = $event.which || $event.keyCode;
            if (keyCode === 13) {
              $scope.send(scope.msg);
              scope.msg = '';
            }
          };

          $scope.emojilist = [];

          var makeEmoji = function (item, index) {
              var list_code = item.list_code.split(/\s*\b\s*/);
              var uni = '';
              list_code.forEach(function(item, index) {
                uni += twemoji.convert.fromCodePoint(item);
              });

              uni = twemoji.parse(uni);
              uni = $sce.trustAsHtml(uni);
              //console.log(uni);
              $scope.emojilist.push(uni);
              //console.log($scope.emojilist);
          };

          var listEmoji = function (index) {
            $http({
              method: 'GET',
              url: 'msg/emoji/'+index,
            }).then(function successCallback(response) {
                //console.log(response.data);
                response.data.forEach(makeEmoji);
                listEmoji(index+10);
              }, function errorCallback(response) {

              });
          };
          listEmoji(0);


      }
});

app.controller('Settings', ['$scope','$http','$mdDialog','FileUploader',function($scope,$http,$mdDialog,FileUploader) {


          console.log("seetigs");
          console.log("kkk");
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

app.controller('Users', ['$scope','$http','$mdDialog','$routeParams','friendPanelActions',function($scope,$http,$mdDialog,$routeParams,friendPanelActions) {


          console.log("Users");
          console.log($routeParams.uid);
          $scope.uid = $routeParams.uid;
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
            },
            config: false,

          };



          $http({
            method: 'GET',
            url: 'users/'+$routeParams.uid,
          }).then(function successCallback(response) {
              // this callback will be called asynchronously
              // when the response is available
              console.log(response.data);
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

            });










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

app.controller('AppCtrl', function ($scope, $timeout, $mdSidenav,$log,chatSidenav) {
  $scope.bootscreen = false;
  $scope.chatButton = chatSidenav;
  $scope.jsonToURL = function (data) {
    var str = Object.keys(data).map(function(key){
        return encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
    }).join('&');
    return str;
  };
  $scope.bootscreen = true;

  $scope.buttons = {
    request : {
      icon : "add",
      val : -1,
      progress : false,
    },
    message : "message",
    block : {
      icon : "block",
      val : -1,
    }
  };
  $scope.k = {
    fname : "suraj",
    mem_id : "888"
  };

  });

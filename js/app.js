
var app = angular.module('BlankApp', ['rzModule','ngMaterial','ngRoute','ui.scroll', 'ui.scroll.grid','ngWebSocket','angularFileUpload','luegg.directives','contenteditable','jkAngularRatingStars','linkify','ngSanitize']);




app.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('teal',{
      'default': '500', // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '200', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '600', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A100' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('deep-orange',{
      'hue-1': '200',
      'hue-2' : 'A700',
    });
});

app.config(['$routeProvider', function($routeProvider){
                $routeProvider
                .when('/',{
                  templateUrl:'p/0'
                })
                .when('/search',{
                  templateUrl:'p/1',
                })
                .when('/messages',{
                  templateUrl:'p/2',
                })
                .when('/request',{
                  templateUrl:'p/3',
                })
                .when('/users/:uid',{
                  templateUrl:'p/4',
                  controller : "UserController"
                })
                .when('/profile',{
                  templateUrl:'p/4',
                  controller : "Settings"
                })
                .when('/tbs/:type/:data',{
                  templateUrl:'p/5',
                })
                .otherwise({redirectTo:'/'});
}]);

app.config(function($sceDelegateProvider) {
  $sceDelegateProvider.resourceUrlWhitelist([
    // Allow same origin resource loads.
    'self',
    // Allow loading from our assets domain.  Notice the difference between * and **.
    'http://127.0.0.1/**',
    'http://localhost/**'
  ]);

  // The blacklist overrides the whitelist so the open redirect here is blocked.
  $sceDelegateProvider.resourceUrlBlacklist([
    'http://myapp.example.com/clickThru**'
  ]);
});
app.config(function($mdIconProvider) {
    $mdIconProvider
      .iconSet('social', 'http://127.0.0.1/code/images/angular-logo.svg', 24)
      .defaultIconSet('img/icons/sets/core-icons.svg', 24);
  });
app.config( [
    '$compileProvider',
    function( $compileProvider )
    {
        $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|file|blob):|data:.*\//);
        // Angular before v1.2 uses $compileProvider.urlSanitizationWhitelist(...)
    }
]);
  app.directive('friendpanel', function () {
      return {
          restrict: 'E',
          scope : {
            uid : '=uid'
          },
          controller: ['$scope','$http','$rootScope','$location', function ($scope,$http,$rootScope, $location) {
            $scope.buttons = {
              request : {
                icon : "add",
                val : -1,
                progress : false,
                disabled : false,
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
                   //
                   if (response.data === "0") {
                     $scope.buttons.request.icon = "close";
                     $scope.buttons.request.val = 0;
                   }
                   else if (response.data === "1") {
                     $scope.buttons.request.icon = "done";
                     $scope.buttons.request.disabled = true;
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

            var blockButton = function () {

              $http({
                method: 'GET',
                url: 'users/block/'+$scope.uid,
              }).then(function successCallback(response) {
                  //$scope.buttons.request.progress = false;
                  if (response.data == "1") {
                    $location.path( "/" );
                  }

                }, function errorCallback(response) {

                });

            };

            $scope.buttons.openMenu = openMenu;
            $scope.buttons.requestButton = requestButton;
            $scope.buttons.blockButton = blockButton;
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
  app.directive('postcard', function () {
      return {
          restrict: 'E',
          scope : {
            uid : '=uid'
          },
          controller: ['$scope','$http','FileUploader','linkify','EmojiService', function ($scope,$http,FileUploader,linkify,EmojiService) {
                $scope.shadow = {};
                $scope.picture = SESS_USERIMAGE;
                var placeholder = "<span style='opacity:0.54'>Share your thoughts</span>";
                $scope.upload = {
                  progress : true,
                  button : false,
                  response : {
                    file : false,
                  }
                };
                $scope.focus = function functionName() {
                  //
                  if ($scope.data === placeholder) {
                    $scope.data = "";
                  }
                  $scope.shadow = {
                     //"box-shadow" : "0px 0px 30px #888888",
                  };
                };
                $scope.unfocus = function functionName($event) {
                  //
                  if ($scope.data === "") {
                    $scope.data = placeholder;
                  }
                  $scope.shadow = {};
                };
                $scope.emojilist = [];
                $scope.view = false;
                $scope.changeEmojiView = function () {

                    //$scope.view = !$scope.view;
                    if ($scope.view && $scope.emojilist.length === 0) {

                      $scope.emojilist = EmojiService.get();
                    }else {


                    }
                };
                $scope.onEmojiClick = function (item) {
                  if ($scope.data === placeholder) {
                    $scope.data = "";
                  }
                  $scope.data += " "+item;
                };
                $scope.data = placeholder;
                var uploader = $scope.uploader = new FileUploader({
                  url: 'home/upload',
                  autoUpload: true,
                });
                uploader.filters.push({
                    name: 'customFilter',
                    fn: function(item /*{File|FileLikeObject}*/, options) {
                        return this.queue.length < 1;
                    }
                });
                uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
                    console.info('onWhenAddingFileFailed', item, filter, options);
                };
                uploader.onAfterAddingFile = function(fileItem) {
                    console.info('onAfterAddingFile', fileItem);
                };
                uploader.onAfterAddingAll = function(addedFileItems) {
                    //console.info('onAfterAddingAll', addedFileItems);
                };
                uploader.onBeforeUploadItem = function(item) {
                    console.info('onBeforeUploadItem', item);
                    $scope.upload.progress = false;
                    $scope.upload.button = true;

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
                    $scope.upload.button = false;
                    if (response.status) {
                      $scope.upload.response = response;
                    }


                };
                uploader.onErrorItem = function(fileItem, response, status, headers) {
                    console.info('onErrorItem', fileItem, response, status, headers);
                };
                uploader.onCancelItem = function(fileItem, response, status, headers) {
                    console.info('onCancelItem', fileItem, response, status, headers);
                };
                uploader.onCompleteItem = function(fileItem, response, status, headers) {
                    //console.info('onCompleteItem', fileItem, response, status, headers);
                };
                uploader.onCompleteAll = function() {
                    console.info('onCompleteAll');
                };
                var text = "@scottcorgan and http://github.com";

                $scope.hashtagify = function () {

                  //$scope.data.replace(/.*/,linkify.twitter($scope.data));
                };
                $scope.post = function () {

                        $http({
                          method: 'POST',
                          url: 'home/post',
                          data : {
                            content : $scope.data,
                            upload : $scope.upload.response,
                          },
                          }).then(function successCallback(response) {

                            if (response.data === "1") {
                                uploader.clearQueue();
                                $scope.data = placeholder;
                            }

                          }, function errorCallback(response) {

                          });

                          // $scope.data = $scope.data.replace(/(^|\W)(#[a-z\d][\w-]*)/igm, '$1<a href="">$2</a>');


                            // Twitter
                            // Must use $sce.trustAsHtml() as of Angular 1.2.x


                          function getHashTags(inputText) {
                            var regex = /(?:^|\s)(?:#)([a-zA-Z\d]+)/gm;
                            var matches = [];
                            var match;
                            while ((match = regex.exec(inputText))) {
                                matches.push(match[1]);
                            }
                            return matches;
                        }

                        //

                };


        }],
          templateUrl:'element/2',
      };
  });
  app.directive('friendRequestCard', function () {
      return {
          restrict: 'E',
          templateUrl:'element/3',
      };
  });
  app.directive('postViewCard', function () {
      return {
          restrict: 'E',
          templateUrl:'element/4',
      };
  });
  app.directive('elastic', [
    '$timeout',
    function($timeout) {
        return {
            restrict: 'A',
            link: function($scope, element) {
                $scope.initialHeight = $scope.initialHeight || element[0].style.height;
                var resize = function() {
                    element[0].style.height = $scope.initialHeight;
                    element[0].style.height = "" + element[0].scrollHeight + "px";
                };
                element.on("input change", resize);
                $timeout(resize, 0);
            }
        };
    }
]);

app.directive('ngThumb', ['$window', function($window) {
        var helper = {
            support: !!($window.FileReader && $window.CanvasRenderingContext2D),
            isFile: function(item) {
                return angular.isObject(item) && item instanceof $window.File;
            },
            isImage: function(file) {
                var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };

        return {
            restrict: 'A',
            template: '<canvas/>',
            link: function(scope, element, attributes) {
                if (!helper.support) return;

                var params = scope.$eval(attributes.ngThumb);

                if (!helper.isFile(params.file)) return;
                if (!helper.isImage(params.file)) return;

                var canvas = element.find('canvas');
                var reader = new FileReader();

                reader.onload = onLoadFile;
                reader.readAsDataURL(params.file);

                function onLoadFile(event) {
                    var img = new Image();
                    img.onload = onLoadImage;
                    img.src = event.target.result;
                }

                function onLoadImage() {
                    var width = params.width || this.width / this.height * params.height;
                    var height = params.height || this.height / this.width * params.width;
                    canvas.attr({ width: width, height: height });
                    canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
                }
            }
        };
    }]);

app.directive('imageFetch',function($http,$sce) {
        return {
            restrict: 'A',

           link: function(scope, elem, attrs) {
             $http({
               method: 'GET',
               url: 'img/dp/'+attrs.ngSrc+'/'+attrs.size,
             }).then(function successCallback(response) {
                 //$sceDelegate.getTrusted($sce.HTML, response.data);
                 //
                 var temp = $sce.trustAsResourceUrl(response.data);
                 //
                 attrs.$set('ngSrc',temp);

               }, function errorCallback(response) {

               });
            //$compile(elem)(scope);
          }
            //template: '<img class="md-user-avatar" src="{{data}}"/>',
        };
});
app.directive('audioFetch',function($http,$sce,MyWebSocket,notiService) {
        return {
            restrict: 'E',

           link: function(scope, elem, attrs) {


            elem["0"].addEventListener("ended", function() {

               //elem["0"].childNodes["0"].play();
             }, true);
             var protoRec = MyWebSocket.protoRec;

            MyWebSocket.socket.onMessage(function (message) {
                 message = JSON.parse(message.data);
                  if (message.header === protoRec.newmsg) {
                            if (notiService.getDialog.isOpen) {


                                  var data = JSON.parse(message.data);

                                  if (data.sender.toString() === notiService.getDialog.user.mem_id.toString()) {

                                  }else {

                                    elem["0"].childNodes["0"].play();
                                  }
                              }
                            else {

                              elem["0"].childNodes["0"].play();
                            }
                }else {


                }
                //elem["0"].childNodes["0"].autoplay =true;

            });
            //elem["0"].childNodes["0"].autoplay =true;
          },
            templateUrl: 'element/6',
        };
});
app.factory('notiService',function () {
  var dialog = {
    isOpen : false,
  };
  var setDialog = function (user,isOpen){
      dialog.isOpen = isOpen;
      dialog.user = user;

  };
  return {
    setDialog : setDialog,
    getDialog : dialog,
  };
});
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

app.factory('EmojiService',['$http','$rootScope',function($http,$rootScope) {

    var emojilist = [],view = false;
  var makeEmoji = function (item, index) {
            var list_code = item.list_code.split(/\s*\b\s*/);
            var uni = '';
            list_code.forEach(function(item, index) {
              uni += twemoji.convert.fromCodePoint(item);
            });

            uni = twemoji.parse(uni,  {
              base: 'http://localhost/twemoji-gh-pages/',
              ext : '.png',
              size :20
              });
            emojilist.push(uni);

        };

        var listEmoji = function (index) {
          $http({
            method: 'GET',
            url: 'msg/emoji/'+index,
          }).then(function successCallback(response) {
              //
              response.data.forEach(makeEmoji);
              if( index <= 1791)
                listEmoji(index+10);

            }, function errorCallback(response) {

            });
        };

        var get = function () {
          listEmoji(0);
          return emojilist;
        };

        return {
          get : get,
        };

}]);

app.factory('dpDisplay', function($http) {

        var dpDisplay = function(data){
          if (data == SESS_MEMBER_ID) {

            return false;
          }
          else {

            return true;
          }
        };
        var getDp = function(id,size){
          $http({
            method: 'GET',
            url: 'img/userdp/'+id+'/'+size,
          }).then(function successCallback(response) {
              //
              return response.data;
            }, function errorCallback(response) {

            });
        };
        return{
          get : dpDisplay,
          getDp : getDp,
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
      var protoRec = {
        newmsg  : "8002",
      };



      var init = function () {
        var info = {
          data  : SESS_MEMBER_ID,
          header  : protoSent.init,
        };
        socket.send(info);
      };
      init();





      socket.onOpen(function () {


      });
      socket.onError(function () {


      });

      socket.onMessage(function () {


      });


      var methods = {
        mem_id  : mem_id,
        response  : response,
        socket  :socket,
        protoSent : protoSent,
        protoRec : protoRec,
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
        if (big === 0) {

              $http({
                method: 'GET',
                url: 'msg/users/count',
              }).then(function successCallback(response) {
                  // this callback will be called asynchronously
                  // when the response is available

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
              url: 'msg/users/'+big,
            }).then(function successCallback(response) {
                // this callback will be called asynchronously
                // when the response is available

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


				$timeout(function () {

          index = index-1;
          setBig(index).then(
            function (result) {
                // promise was fullfilled (regardless of outcome)
                // checks for information will be peformed here
                var result2 = [];
                for (var i = index; i <= index + count - 1; i++) {
                  //
                  //
                 if(i < 0 || i >= max) {
                              continue;
                          }
                          //
                  result2.push(page[i]);
                }
                success(result2);

            },
            function (error) {
                // handle errors here

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
  app.factory('MyPosts', ['$log', '$timeout','$http','$q',
  		function (console, $timeout,$http,$q) {

        var datasource = {};
        var big =-1,max = 0,user = SESS_MEMBER_ID;
        var page = [];

        var setUser = function (id) {
          big = -1;
          user = id;
        };
        var getCount = function (big) {
          var deferred = $q.defer();
          if (big === 0) {
                $http({
                  method: 'GET',
                  url: 'post/count/'+user,
                }).then(function successCallback(response) {
                    // this callback will be called asynchronously
                    // when the response is available

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
            big = (big === -1)? 0 : big+10;
            //big = index;


              getCount(big).then(function (response) {

                $http({
                    method: 'GET',
                    url: 'post/get/'+big+'/'+user,
                  }).then(function successCallback(response) {

                    response.data.forEach(function (item,index3) {
                      page.push(item);
                    });
                      deferred.resolve(response);
                    }, function errorCallback(response) {
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

          $timeout(function () {

                //
              setBig(index).then(function (response) {
                var result = [];
                for (var i = index; i <= index + count - 1; i++) {

                  if(i < 0 || i >= max) {
                              continue;
                          }
                          //
                 result.push(page[i]);
                //result.push("page : "+i);
                }
                success(result);
              },function (error) {

              });

            }, 100);

  			};

  			return {
  				get: get,
          setUser : setUser,
  			};
  		}
  	]);


app.controller('msgController', [
		'$scope', '$log', '$timeout','$http','MyWebSocket','$q','dpDisplay','listMessengers','$mdSidenav','EmojiService', function ($scope,console, $timeout,$http,MyWebSocket,$q,dpDisplay,listMessengers,$mdSidenav,EmojiService) {
			var datasource = {};
      var big  = -1,max = 0;
      var page  = [];
      $scope.msg = '';
      $scope.myDp = SESS_USERIMAGE;
      $scope.dpDisplay = dpDisplay;

      MyWebSocket.socket.onMessage(function (message) {

      });
      $scope.log = function() {
        listMessengers.test();
      };
      $scope.jj = listMessengers;
      $scope.toggleLeft = buildToggleri('jam');
      $scope.toggleRight = buildToggleri('right');

       function buildToggleri(componentId) {
         return function() {
           $mdSidenav(componentId).toggle();
         };
       }
       $mdSidenav('jam', true).then(function(instance) {

          $scope.toggleLeft();
        });


      $scope.removeFromList1 = function() {

        return $scope.msgUserListAdapter.reload(0);
      };

      var getCount = function (big) {
        var deferred = $q.defer();
        if (big === 0) {

              $http({
                method: 'GET',
                url: 'msg/count/'+$scope.msgUser,
              }).then(function successCallback(response) {
                  // this callback will be called asynchronously
                  // when the response is available

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
        index = index*(-1);
        if (index > big) {
          big = index;
          var offset = big-9;
          getCount(offset).then(function (result) {
            //
            $http({
              method: 'POST',
              url: 'msg/get',
              data: {
                offset : offset,
                user: $scope.msgUser,
              },
            }).then(function successCallback(response) {
                //
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
            //
            var result = [];
  					for (var i = index; i <= index + count - 1; i++) {
  //setBig(index);
              if(i > 0 || (i*-1) >= max) {
                          continue;
                      }
                      //
  						    result.push(page[i*-1]);
  					}
  					success(result);
					},    function (error) {
                  // handle errors here

              });
				}, 100);
			};

			$scope.datasource = datasource;
      $scope.msgUserListAdapter = {
        remain: true
      };
      $scope.msgUserAdapter = {
        remain: true
      };

      $scope.sendMsg = function () {
          var data = {
            receiver : $scope.msgUser,
            message : $scope.msg
          };

          $scope.myuser = angular.copy($scope.msgUser);
          //
            $http({
              method: 'POST',
              url: 'msg/sent',
              data: data,
            }).then(function successCallback(response) {
                //
                if (response.data === "1") {
                  var data = {
                    code : MyWebSocket.protoSent.newmsg,
                    data: $scope.myuser,
                  };
                  taskList(data);
                }
              }, function errorCallback(response) {

              });
              $scope.msgUserAdapter.append([data]);
              $scope.msg = "";

		};

    var taskList = function (data) {

        if (data.code === MyWebSocket.protoSent.newmsg) {

            var info = {
              header: MyWebSocket.protoSent.newmsg,
              data: data.data,
            };
            MyWebSocket.socket.send(info);

        }

    };

    $scope.selectMsgUser = function (user) {
      $scope.msgUser = user.mem_id;

      $scope.msgUserName = {
        fname : user.fname,
        lname : user.lname,
        picture : user.picture,
      };
      big = -1;
      $scope.msgUserAdapter.reload();
      $scope.toggleLeft();
    };
    $scope.bgList = function (val) {
      if (val) {
        return {
          'background-color':'#80CBC4',

        };
      }
      else {
        return {
          'background-color':'#E0F2F1',
        };
      }
    };
    $scope.emojilist = [];
    $scope.view = false;
    $scope.changeEmojiView = function () {

        //$scope.view = !$scope.view;
        if ($scope.view && $scope.emojilist.length === 0) {

          $scope.emojilist = EmojiService.get();
        }else {


        }
    };
    $scope.onEmojiClick = function (item) {
      $scope.msg += " "+item;
    };



  }
	]);


app.controller('DemoCtrl', function() {

});
app.controller('Search',['$scope','$timeout','$http','$q', function($scope,$timeout,$http,$q) {

    var big = -1,page = [];



          $http({
              method: 'GET',
              url: 'list/countries',

            }).then(function successCallback(response) {
              $scope.countries = response.data;
              //
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
            var getCount = function (big) {
              var deferred = $q.defer();
              if (big === 0) {

                    $http({
                      method: 'POST',
                      url: 'search/adv/count',
                      data: $scope.searchData.data,
                    }).then(function successCallback(response) {
                        // this callback will be called asynchronously
                        // when the response is available

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
              index2 = index-1;

              if(index2 > big){
                big = index2;




                  $scope.searchData.data.h_age = $scope.slider.max;
                  $scope.searchData.data.l_age = $scope.slider.min;
                  $scope.searchData.data.offset = big;
                  //
                  //max =100;
                  getCount(big).then(function (response) {
                    $http({
                        method: 'POST',
                        url: 'search/adv',
                        data: $scope.searchData.data,

                      }).then(function successCallback(response) {
                        //
                        response.data.forEach(function (item,index3) {
                          page.push(item);

                        });
                          deferred.resolve(response);
                        }, function errorCallback(response) {
                          deferred.reject({ message: "Really bad" });
                        });
                  });



              }
              else {
                deferred.resolve({ message: "no http needed" });
              }
              return deferred.promise;
            };

      			datasource.get = function (index, count, success) {
      				$timeout(function () {

                setBig(index).then(function (response) {
                  var result = [];
                  for (var i = index; i <= index + count - 1; i++) {

                    if(i < 0 || i >= max) {
                                continue;
                            }

        						result.push(page[i]);
        					}
        					success(result);
                },function (error) {

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





}]);

app.controller('chatBox', [
		'$scope', '$log', '$timeout','$http','$location', '$anchorScroll', function ($scope, console, $timeout,$http,$location, $anchorScroll) {
      //$scope.gotoBottom();



		}
	]);

app.controller('chatInit', function($scope,$http,MyWebSocket,$mdDialog,chatSidenav,dpDisplay,notiService) {
    $scope.chat = MyWebSocket;
    $scope.chatMessages = [];

    var msgMap = new Map();

    $scope.chat.socket.onMessage(function(message) {
        var msg = JSON.parse(message.data);

        taskList(msg);
    });
    $scope.list = [];

    $scope.t = function () {
        $scope.list.push("gfgdg");
        $scope.list[1] = "5";
    };
    var taskList = function (data) {
      if (data.header == "8000") {

        $http({
          method: 'GET',
          url: 'online/2',
        }).then(function successCallback(response) {
              //
              $scope.list = [];
              $scope.list.push(response.data);



          }, function errorCallback(response) {

          });

      }
      else if (data.header == "8002") {

          var msg = JSON.parse(data.data);

          checkUser(msg.sender.toString());
         //msgMap.get(parseInt(msg.sender)).push(msg);
           msgMap.get(msg.sender.toString()).push(msg);


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

    $scope.showAdvanced = function(ev,user) {
      var mem_id = user.mem_id;
      checkUser(mem_id);

      notiService.setDialog(user,true);
      var x = msgMap.get(mem_id);





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
              picture : user.picture,
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


      function DialogController($scope, $mdDialog,chatButton,data,$http,EmojiService,dpDisplay,notiService) {
          $scope.messages = data.messages;

          $scope.receiver = data.receiver;

          $scope.myvar = [1,2,3,4,5,6,7];
          var socket = data.websocket.socket;
          var protoSent = data.websocket.protoSent;
          $scope.emojiView = true;
          $scope.msgView = !$scope.emojiView;
          $scope.kunna = "dialog/content/1";
          $scope.msg= "jkhjkh";
          $scope.dpDisplay = dpDisplay;
          $scope.setDp = function (item) {
            item.receiver = item.receiver.toString();
                if (item.receiver === SESS_MEMBER_ID) {
                  return data.picture;
                }
                else {
                  //
                  return SESS_USERIMAGE;
                }
            };

          //
          $scope.hide = function() {
            $mdDialog.hide();
            chatButton.showButton();
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
            notiService.setDialog(null,false);
            chatButton.showButton();
          };

          $scope.answer = function(answer) {
            $scope.hide();
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
            //
            $scope.msg = null;
            socket.send(info);


          };

          $scope.checkIfEnterKeyWasPressed = function($event,scope){
            var keyCode = $event.which || $event.keyCode;
            if (keyCode === 13) {
              $scope.send(scope.msg);
              scope.msg = '';
            }
          };
          $scope.emojilist = [];
          $scope.view = false;
          $scope.changeEmojiView = function () {
             //$scope.view = !$scope.view;
              if ( $scope.emojilist.length === 0) {

                $scope.emojilist = EmojiService.get();
              }else {

              }
          };
          $scope.bgList = function (val) {
            if (val) {
              return {
                'background-color':'#80CBC4',

              };
            }
            else {
              return {
                'background-color':'#E0F2F1',
              };
            }
          };





      }
});

app.controller('Settings', ['$scope','$http','$mdDialog','FileUploader','$timeout','$q','MyPosts',function($scope,$http,$mdDialog,FileUploader,$timeout,$q,MyPosts) {
      var datasource = {};
      var big =-1,max = 500;
      var page = [];
			$scope.datasource = MyPosts;
			$scope.delay = false;

        $scope.adapter = {
          remain: true
        };
        $scope.openFromLeft = function(ev) {
             $mdDialog.show({
                  controller: BlockController,
                  templateUrl: 'dialog/3',
                  parent: angular.element(document.body),
                  targetEvent: ev,
                  clickOutsideToClose:true,
                  openFrom : '#left',
                  closeTo : angular.element(document.querySelector('#right')),
                  //fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
                }
             );
        };
        function BlockController($scope, $mdDialog) {

          $http({
            method: 'GET',
            url: 'block/get',
          }).then(function successCallback(response) {

              $scope.userList = response.data;
            }, function errorCallback(response) {

            });
          $scope.hide = function() {
            $mdDialog.hide();
          };

          $scope.cancel = function() {
            $mdDialog.cancel();
          };
          $scope.unBlock = function (item) {
            $http({
              method: 'GET',
              url: 'block/cancel/'+item.mem_id,
            }).then(function successCallback(response) {

                if (response.data === "1") {
                  var index = $scope.userList.indexOf(item);
                  if (index > -1) {
                        $scope.userList.splice(index, 1);
                    }
                }
              }, function errorCallback(response) {

              });
          };
        }



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
                info : {
                  block : {
                    name : "BLOCKED USERS",
                    icon  : "flaticons/svg/lock.svg"
                  },
                  deac : {
                    name : "DEACTIVATE",
                  },
                }
              },
            },
            dialog  : {
            },
            config: true,
            post : false,
            dp : '',

          };
          $scope.onSelectPosts = function () {
            MyPosts.setUser(SESS_MEMBER_ID);
            $scope.settingsData.post = true;
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
              $scope.settingsData.tabs.profile.info.country.data = response.data.c_name;
              $scope.settingsData.tabs.profile.info.country.icon = "flags/1x1/"+response.data.country.toLowerCase()+".svg";
              $scope.settingsData.fname = response.data.fname;
              $scope.settingsData.lname = response.data.lname;
              $scope.settingsData.tag = response.data.tag;
              $scope.settingsData.dp = response.data.picture;


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

      if (sel == 8) {

        $http({
            method: 'GET',
            url: 'list/countries',

          }).then(function successCallback(response) {
            $scope.settingsData.countries = response.data;

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
              //console.info('onSuccessItem', fileItem, response, status, headers);
              $scope.upload.progress = true;
              $scope.settingsData.dp = response;

          };
          uploader.onErrorItem = function(fileItem, response, status, headers) {
              console.info('onErrorItem', fileItem, response, status, headers);
          };
          uploader.onCancelItem = function(fileItem, response, status, headers) {
              console.info('onCancelItem', fileItem, response, status, headers);
          };
          uploader.onCompleteItem = function(fileItem, response, status, headers) {
              //$mdDialog.cancel();

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
          if (sel === 0) {

            $scope.settingsData.dialog.progress = true;

          }
          if(sel == 1){
            //change name
            $http({
                method: 'POST',
                url: 'settings/5',
                data: JSON.stringify({
                  fname : $scope.user.fname,
                  lname : $scope.user.lname,
                }),

              }).then(function successCallback(response) {
                    //
                    if (response.data.status) {
                      $scope.settingsData.fname = $scope.user.fname;
                      $scope.settingsData.lname = $scope.user.lname;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;
                    }
                }, function errorCallback(response) {

                  $scope.settingsData.dialog.progress = true;

                });
          }
          else if (sel === 2) {
            //change tag
            $http({
                method: 'POST',
                url: 'settings/1',
                data: JSON.stringify({
                  tag : $scope.user.tag,
                }),

              }).then(function successCallback(response) {
                    //
                    if (response.data.status) {
                      $scope.settingsData.tag = $scope.user.tag;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;
                    }
                }, function errorCallback(response) {

                  $scope.settingsData.dialog.progress = true;
                });
          }
          else if (sel === 3) {
            //chnage about me
            $http({
                method: 'POST',
                url: 'settings/2',
                data: JSON.stringify({
                  about_me : $scope.user.tabs.profile.info.aboutme.data,
                }),

              }).then(function successCallback(response) {
                    //
                    if (response.data.status) {
                      $scope.settingsData.tabs.profile.info.aboutme.data = $scope.user.tabs.profile.info.aboutme.data;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;
                    }
                }, function errorCallback(response) {

                  $scope.settingsData.dialog.progress = true;
                });

          }
          else if (sel === 4) {
            //change my preference
            $http({
                method: 'POST',
                url: 'settings/2',
                data: JSON.stringify({
                  about_me : $scope.user.tabs.profile.info.mypre.data,
                }),

              }).then(function successCallback(response) {
                    //
                    if (response.data.status) {
                      $scope.settingsData.tabs.profile.info.mypre.data = $scope.user.tabs.profile.info.mypre.data;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;
                    }
                }, function errorCallback(response) {

                  $scope.settingsData.dialog.progress = true;
                });
          }
          else if (sel == 5) {
            //change gender
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

                });

          }
          else if (sel == 6) {
            //change dob
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

                    if (response.data.status) {
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;

                    }
                }, function errorCallback(response) {

                });


          }
          else if (sel === 7) {
          //  change mail
          }
          else if (sel == 8) {
            //change country

            $http({
                method: 'POST',
                url: 'settings/8',
                data: {
                  country : $scope.user.tabs.profile.info.country.data,
                },

              }).then(function successCallback(response) {

                    if (response.data.status) {
                      $scope.settingsData.tabs.profile.info.country.icon = "flags/1x1/"+response.data.result.toLowerCase()+".svg";
                      $scope.settingsData.tabs.profile.info.country.data = $scope.user.tabs.profile.info.country.data;
                      $scope.cancel();
                      $scope.settingsData.dialog.progress = true;

                    }
                }, function errorCallback(response) {

                });


          }



        };
      }





}]);

app.controller('UserController', ['$scope','$http','$mdDialog','$routeParams','MyPosts',function($scope,$http,$mdDialog,$routeParams,MyPosts) {




          $scope.uid = $routeParams.uid;
          $scope.datasource = MyPosts;
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
            blocked : false,
            post : false,
          };
          $scope.onSelectPosts = function () {

            MyPosts.setUser($scope.uid);
            $scope.settingsData.post = true;
          };

          $scope.hideProfile = function () {

            return !$scope.settingsData.config && $scope.settingsData.blocked;
          };

          $http({
            method: 'GET',
            url: 'users/'+$routeParams.uid,
          }).then(function successCallback(response) {
              // this callback will be called asynchronously
              // when the response is available

              if (response.data === "0") {
                $scope.settingsData.blocked = true;
              }else {
                $scope.settingsData.tabs.profile.info.aboutme.data = response.data.about_me;
                $scope.settingsData.tabs.profile.info.mypre.data = response.data.about_partner;
                $scope.settingsData.tabs.profile.info.bday.data = response.data.yy;
                $scope.settingsData.tabs.profile.info.email.data = response.data.email;
                $scope.settingsData.tabs.profile.info.country.data = response.data.c_name;
                $scope.settingsData.tabs.profile.info.country.icon = "flags/1x1/"+response.data.country.toLowerCase()+".svg";
                $scope.settingsData.fname = response.data.fname;
                $scope.settingsData.lname = response.data.lname;
                $scope.settingsData.tag = response.data.tag;
                $scope.settingsData.dp = response.data.picture;
                if (response.data.gender == 'M') {
                  $scope.settingsData.tabs.profile.info.gender.data = "Male";
                  $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/muscular.svg";
                }else {
                  $scope.settingsData.tabs.profile.info.gender.data = "Female";
                  $scope.settingsData.tabs.profile.info.gender.icon = "flaticons/svg/femenine.svg";
                }
              }


            }, function errorCallback(response) {

            });










}]);


 app.controller('Request', function ($scope,$timeout,$q,$http) {

         var datasource = {};
         var big =-1,max = -1;
         var page = [];
         var getCount = function (big) {
           var deferred = $q.defer();
           if (big === 0) {

                 $http({
                   method: 'GET',
                   url: 'req/frnd/count',
                 }).then(function successCallback(response) {
                     // this callback will be called asynchronously
                     // when the response is available

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
           index2 = index-1;

           if(index2 > big){
             big = index2;


               getCount(big).then(function (response) {
                 $http({
                     method: 'GET',
                     url: 'req/frnd/'+big,
                   }).then(function successCallback(response) {

                     response.data.forEach(function (item,index3) {
                       page.push(item);
                     });
                       deferred.resolve(response);
                     }, function errorCallback(response) {
                       deferred.reject({ message: "Really bad" });
                     });
               });
           }
           else {
             deferred.resolve({ message: "no http needed" });
           }
           return deferred.promise;
         };

         datasource.get = function (index, count, success) {
           $timeout(function () {


             setBig(index).then(function (response) {
               var result = [];
               for (var i = index; i <= index + count - 1; i++) {

                 if(i < 0 || i >= max) {
                             continue;
                         }
                         //
                 result.push(page[i]);
               }
               success(result);
             },function (error) {

             });

           }, 100);
         };

         $scope.datasource = datasource;
         $scope.adapter = {
           remain: true
         };

         $scope.k = function () {

           $scope.adapter.reload();
         };
         $scope.accept = function (user) {
           $http({
               method: 'GET',
               url: 'req/frnd/action/0/'+user.mem_id,
             }).then(function successCallback(response) {
                 //
                 var index = page.indexOf(user);
                 max--;
                 page.splice(index, 1);
                 $scope.adapter.reload();

               }, function errorCallback(response) {
               });
         };
         $scope.reject = function (user) {
           $http({
               method: 'GET',
               url: 'req/frnd/action/1/'+user.mem_id,
             }).then(function successCallback(response) {

                 var index = page.indexOf(user);
                 max--;
                 page.splice(index, 1);
                 $scope.adapter.reload();
               }, function errorCallback(response) {
               });
         };

   });
app.controller('PostView', function ($scope, $timeout,$http,$q) {
          var datasource = {};
          var big =-1,max = 500;
          var page = [];
          var getCount = function (big) {
            var deferred = $q.defer();
            if (big === 0) {
                  $http({
                    method: 'GET',
                    url: 'post/count',
                  }).then(function successCallback(response) {
                      // this callback will be called asynchronously
                      // when the response is available

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
              big = (big === -1)? 0 : big+10;
              //big = index;


                getCount(big).then(function (response) {

                  $http({
                      method: 'GET',
                      url: 'post/get/'+big,
                    }).then(function successCallback(response) {

                      response.data.forEach(function (item,index3) {
                        page.push(item);
                      });
                        deferred.resolve(response);
                      }, function errorCallback(response) {
                        deferred.reject({ message: "Really bad" });
                      });
                });
            }
            else {
              deferred.resolve({ message: "no http needed" });
            }
            return deferred.promise;
          };

          datasource.get = function (index, count, success) {
            $timeout(function () {

                //
              setBig(index).then(function (response) {
                var result = [];
                for (var i = index; i <= index + count - 1; i++) {

                  if(i < 0 || i >= max) {
                              continue;
                          }
                          //
                 result.push(page[i]);
                //result.push("page : "+i);
                }
                success(result);
              },function (error) {

              });

            }, 100);
          };

          $scope.datasource = datasource;
          $scope.adapter = {
            remain: true
          };
          $scope.onRating = function(rating,id){

            $http({
                method: 'GET',
                url: 'post/onrating/'+id+"/"+rating,
              }).then(function successCallback(response) {

                }, function errorCallback(response) {

                });
          };
          $scope.getMyRating = function (id) {
            $http({
                method: 'GET',
                url: 'rating/get/'+id,
              }).then(function successCallback(response) {

                  //return response.data.rating;
                }, function errorCallback(response) {

                });
          };
});
app.controller('ToolbarController', function ($scope, $timeout, $mdSidenav,$log,chatSidenav,$http,$rootScope, $location) {

    var self = this;

    self.simulateQuery = false;
    self.isDisabled    = false;

    // list of `state` value/display objects
    self.querySearch   = querySearch;
    self.selectedItemChange = selectedItemChange;
    self.searchTextChange   = searchTextChange;
    self.newState = newState;

    var checkRegex = function (string) {
      hash = /#+([a-zA-Z0-9_]+)/;
      email = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/gm;
      var isHash = hash.exec(string);
      var isEmail = email.exec(string);
      if (isHash !== null ) {

        self.type = 'hash';
        return {
          type : '0',
          data : isHash[1],
        };
      }
      else if (isEmail !== null ) {

        self.type = 'email';
        return {
          type : '1',
          data : isEmail[0],
        };
      }
      else {

        self.type = 'other';
        return {
          type : '2',
          data : string,
        };
      }
    };

    function newState(state) {
      alert("Sorry! You'll need to create a Constitution for " + state + " first!");
    }

    // ******************************
    // Internal methods
    // ******************************

    /**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     */
    function querySearch (query) {
      var url;
      info = checkRegex(query);

      if (info.type == '1') {
        return $http({
            method: 'POST',
            url: 'search/tool/'+info.type,
            data : {
              email : info.data
            }
          }).then(function successCallback(response) {

              self.isHash = (response.data.type === "0")? true :false;
              self.isEmail = (response.data.type === "1")? true :false;
              self.isOther = (response.data.type === "2")? true :false;
              return response.data.data;
            }, function errorCallback(response) {
                return response;
            });
      }else {
        return $http({
            method: 'GET',
            url: 'search/tool/'+info.type+'/'+info.data,
          }).then(function successCallback(response) {

              self.isHash = (response.data.type === "0")? true :false;
              self.isEmail = (response.data.type === "1")? true :false;
              self.isOther = (response.data.type === "2")? true :false;
              return response.data.data;
            }, function errorCallback(response) {
                return response;
            });
      }

    }


    function searchTextChange(text) {
      $log.info('Text changed to ' + text);
    }

    function selectedItemChange(item) {
      //$log.info('Item changed to ' + JSON.stringify(item));
      if (self.type == 'email') {
          $location.path( "/users/"+item.mem_id );
      }
      else if (self.type == 'hash') {
          $location.path( "tbs/hash/"+item.label );
      }
    }


    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
      var lowercaseQuery = angular.lowercase(query);

      return function filterFn(state) {
        return (state.value.indexOf(lowercaseQuery) === 0);
      };
    }

});
app.controller('ToolbarSearch', function ($scope,$http,$routeParams,$timeout,$q) {


      var datasource = {};
      var big =-1,max = 500;
      var page = [];
      var getCount = function (big) {
        var deferred = $q.defer();
        if (big === 0) {
              $http({
                method: 'GET',
                url: 'tbs/'+$routeParams.type+'/count/'+$routeParams.data,
              }).then(function successCallback(response) {
                  // this callback will be called asynchronously
                  // when the response is available

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
          big = (big === -1)? 0 : big+10;
          //big = index;


            getCount(big).then(function (response) {

              $http({
                  method: 'GET',
                  url: 'tbs/'+$routeParams.type+"/"+$routeParams.data+"/"+big,
                }).then(function successCallback(response) {

                  response.data.forEach(function (item,index3) {
                    page.push(item);
                  });
                    deferred.resolve(response);
                  }, function errorCallback(response) {
                    deferred.reject({ message: "Really bad" });
                  });
            });
        }
        else {
          deferred.resolve({ message: "no http needed" });
        }
        return deferred.promise;
      };

      datasource.get = function (index, count, success) {
        $timeout(function () {

            //
          setBig(index).then(function (response) {
            var result = [];
            for (var i = index; i <= index + count - 1; i++) {

              if(i < 0 || i >= max) {
                          continue;
                      }
                      //
             result.push(page[i]);
            //result.push("page : "+i);
            }
            success(result);
          },function (error) {

          });

        }, 100);
      };

      $scope.datasource = datasource;
      $scope.adapter = {
        remain: true
      };
      $scope.click = function () {

        $scope.adapter.reload();
      };
      $scope.onRating = function(rating,id){

        $http({
            method: 'GET',
            url: 'post/onrating/'+id+"/"+rating,
          }).then(function successCallback(response) {

            }, function errorCallback(response) {

            });
      };
      $scope.getMyRating = function (id) {
        $http({
            method: 'GET',
            url: 'rating/get/'+id,
          }).then(function successCallback(response) {

              //return response.data.rating;
            }, function errorCallback(response) {

            });
      };

});
app.controller('notiCtrl', function ($scope, $http,chatSidenav,MyWebSocket) {

  $http({
      method: 'GET',
      url: 'noti/get',
    }).then(function successCallback(response) {

        $scope.msgButton = parseInt( response.data.message);
        $scope.globeButton = parseInt( response.data.rating);
        $scope.handButton = parseInt( response.data.friend_req);
        //return response.data.rating;
      }, function errorCallback(response) {

      });
      $scope.onClick = function (type) {
          //
          $http({
              method: 'GET',
              url: 'noti/seen/'+type,
            }).then(function successCallback(response) {
                if (response.data === "1") {
                  if (type === 'message') {
                    $scope.msgButton = 0;
                  }else if (type === 'rating') {
                    $scope.globeButton = 0;
                  }else if (type === 'friend_req') {
                    $scope.handButton = 0;
                  }else {

                  }
                }else {

                }
                //return response.data.rating;
              }, function errorCallback(response) {

              });
      };



});
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
  $scope.tbClass = ['hide_xs'];
  $scope.searchButtonClass = ['show_xs'];
  $scope.searchButton = function () {

    $scope.tbClass = [''];
    $scope.logoClass = ['hide'];
    $scope.searchButtonClass = ['hide'];
  };

});

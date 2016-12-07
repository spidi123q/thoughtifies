/**
 * ng-chatbox - Chat box component for angular
 * @version v1.0.1
 * @link https://github.com/Liksu/ng-chatbox#readme
 * @license MIT
 */
'use strict';

angular.module('ngChatbox', []).directive('ngChatbox', function () {
	return {
		templateUrl: 'chatbox',
		replace: true,
		scope: {
			messages: '=ngModel'
		},
		link: function link($scope, element, attrs, ctrl) {
			$scope.wrap = element[0].querySelector(".wrap");
			$scope.holder = element[0].querySelector(".scroller");
		},
		controller: ["$scope", function controller($scope) {
			$scope.$watch('messages.length', function (val) {
				if (!val) return void 0;
				setTimeout(function () {
					$scope.holder.scrollTop = $scope.wrap.scrollHeight + 1000;
				}, 0);
			});
		}]
	};
}).filter('chatboxExtractText', function () {
	return function (msg) {
		return msg instanceof Object ? msg.text : msg;
	};
});

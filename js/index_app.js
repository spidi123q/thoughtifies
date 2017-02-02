var app = angular.module('IndexApp', ['ngMaterial','ngRoute','ui.scroll', 'ui.scroll.jqlite']);
app.controller('AppCtrl', function ($scope,$http) {
    console.log("hi");
    $scope.onSignIn =  function (googleUser) {
      // Useful data for your client-side scripts:
      var profile = googleUser.getBasicProfile();
      console.log("ID: " + profile.getId()); // Don't send this directly to your server!
      console.log('Full Name: ' + profile.getName());
      console.log('Given Name: ' + profile.getGivenName());
      console.log('Family Name: ' + profile.getFamilyName());
      console.log("Image URL: " + profile.getImageUrl());
      console.log("Email: " + profile.getEmail());

      // The ID token you need to pass to your backend:
      var id_token = googleUser.getAuthResponse().id_token;
      //login(id_token);
      //console.log("ID Token: " + id_token);
    };
    $scope.login = function (id_token) {
      $http({
      method: 'POST',
      url: 'data/3',
      data : {
        id_token : id_token,
      },
    }).then(function successCallback(response) {
            console.log(response.data);
      }, function errorCallback(response) {
      });
    };
});

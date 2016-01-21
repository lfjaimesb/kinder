'use strict';
/*** app.js **/

var KinderApp = angular.module("KinderApp", ['ui.bootstrap', 'ngStorage', 'ngRoute', 'angular-loading-bar', 'ngAnimate', 'ngSanitize']);

KinderApp.constant('urls', {
   BASE: 'http://localhost/kinder/',
   BASE_API: 'http://localhost/kinder/api'
});

KinderApp.config(function($routeProvider, $locationProvider,  $httpProvider) {
    $routeProvider
    .when('/', {
        templateUrl:'views/home.html',
        controller: 'HomeCtrl'
    })
    .otherwise({
        redirectTo: '/'
    });

    $locationProvider.html5Mode(true);

    $httpProvider.interceptors.push(function($q, $location, $localStorage) {
        return {
            'request': function (config) {
                config.headers = config.headers || {};

                if ($localStorage.sicToken) {
                    config.headers.Authorization = 'Bearer ' + $localStorage.sicToken;
                }

                return config;
            },
            'responseError': function(response) {
                if(response.status === 401 || response.status === 403) {
                    $location.path('/');
                }
                return $q.reject(response);
            }
        };
    });
});

KinderApp.directive('uploaderModel', function($parse){
    return {
        restrict: 'A',
        link: function(scope, iElement, iAtrrs){
            iElement.on("change", function(e){
                $parse(iAtrrs.uploaderModel).assign(scope, iElement[0].files[0]);
            });
        }
    };
});

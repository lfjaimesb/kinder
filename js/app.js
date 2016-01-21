'use strict';
/*** app.js **/

var SicApp = angular.module("SicApp", ['ui.bootstrap', 'ngStorage', 'ngRoute', 'angular-loading-bar', 'ngAnimate', 'ngSanitize', 'ui.select', 'ui.mask']);

SicApp.constant('urls', {
   BASE: 'http://localhost/sic/',
   BASE_API: 'http://localhost/sic/api'
});

SicApp.run(function($rootScope, Api, $location, $interval, urls, $templateCache) {
    $rootScope.usuario = false;
    $rootScope.swMenu = false;
    $rootScope.alerts = [];
    $rootScope.base = urls.BASE;

    if(Api.getToken()){
        var tmp = $location.path();

        if(tmp == "/"  || tmp == "/login") $location.path("/load");
        else if(tmp != "/load") Api.getInfo();
    }else $location.path("/");

    $rootScope.closeAlert = function(index) {
      $rootScope.alerts.splice(index, 1);
    };

    $rootScope.addAlert = function(index) {
        return $rootScope.alerts[index].val;
    };


    $rootScope.addAlert = function(typ, mesg) {
        var nv = {type:typ, msg: mesg, val: 0};
        $rootScope.alerts.push(nv);

        $interval(function(){
            nv.val ++;
        },100, 100);
    };

    $rootScope.$on('$viewContentLoaded', function() {
      console.log($templateCache.get()); //.removeAll();
    });
});

SicApp.config(function($routeProvider, $locationProvider,  $httpProvider) {
    $routeProvider
    .when('/', {
        templateUrl:'views/login.html',
        controller: 'LoginCtrl'
    })
    .when('/load', {
        templateUrl:'views/load.html',
        controller: 'LoadCtrl'
    })
    .when('/home', {
        templateUrl:'views/home.html',
        controller: 'HomeCtrl'
    })
    .when('/empresas', {
        templateUrl:'views/empresas.html',
        controller: 'EmpresasCtrl'
    })
    .when('/cuentas', {
        templateUrl:'views/cuentas.html',
        controller: 'CuentasCtrl'
    })
    .when('/addcuentas', {
        templateUrl:'views/addcuentas.html',
        controller: 'AddCuentasCtrl'
    })
    .when('/polizas', {
        templateUrl:'views/polizas.html',
        controller: 'PolizasCtrl'
    })
    .when('/periodo/nvo', {
        templateUrl:'views/periodo.html',
        controller: 'PeriodoCtrl'
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

SicApp.directive('uploaderModel', function($parse){
    return {
        restrict: 'A',
        link: function(scope, iElement, iAtrrs){
            iElement.on("change", function(e){
                $parse(iAtrrs.uploaderModel).assign(scope, iElement[0].files[0]);
            });
        }
    };
});

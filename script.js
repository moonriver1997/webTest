var app = angular.module('myApp', ['ui.router', 'ui.bootstrap']);

app.config(function ($stateProvider, $urlRouterProvider) {
    'use strict';
    $urlRouterProvider.otherwise("/home");

    $stateProvider
    .state('background', {
        url: "/",
        views: {
            '': {
                templateUrl: 'com/views/main.html',
                controller: "MainCtrl as mainCtrl"
            },
            'menu@background': {
                templateUrl: 'com/views/menu.html'
            },
            'header@background': {
                templateUrl: 'com/views/header.html'
            }
        }
    })
    .state('home',{
        parent: 'background',
        url: "home",
        views: {
            'content@background': {
                templateUrl: 'com/views/content.html'
            }
        }
//        resolve: {
//            'loginState': function ($q, $location, $http, $rootScope) {
//                var def = $q.defer();
//                $http.get('php/logService.php?fn=loginCheck').then(function (resp) {
//                    if (resp.data.result != "logged_in"){
//                        $rootScope.logState = resp.data.result;
//                        console.log($rootScope.logState);
//                        $location.path("/home/");
//                    }
//                    else {
//                        console.log(resp.data);
//                        d.resolve('loginState');
//                    }
//                });
//                return def.promise;
//            }
//        }
    })
    .state('MoonRiver', {
        parent: 'background',
        url: 'MoonRiver',
        views: {
            'content@background': {
                templateUrl: 'com/views/moonriver.html'
            }
        }
    })
    .state('Experiment', {
        parent: 'background',
        url: 'Experiment',
        views: {
            'content@background': {
                templateUrl: 'com/views/data.html'
            }
        }
    })
    .state('Data', {
        parent: 'background',
        url: 'Data',
        views: {
            'content@background': {
                templateUrl: 'com/views/data.html'
            }
        }
    })
    .state('Code', {
        parent: 'background',
        url: 'Code',
        views: {
            'content@background': {
                templateUrl: 'com/views/data.html'
            }
        }
    })
    .state('Charts', {
        parent: 'background',
        url: 'Charts',
        views: {
            'content@background': {
                templateUrl: 'com/views/data.html'
            }
        }
    })
});

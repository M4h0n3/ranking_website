//use angluar for routing
var eloApp = angular.module('eloApp', ['ngRoute']);

    // configure our routes
    eloApp.config(function($routeProvider) {
        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl : 'pages/home.html',
                controller  : 'mainController'
            })

            // route for the about page
            .when('/donate', {
                templateUrl : 'pages/donate.html',
                controller  : 'mainController'
            })

            // route for the top100 page
            .when('/players', {
                templateUrl : 'pages/players.html',
                controller  : 'mainController'
            })

            // route for the top100 page
            .when('/test', {
                templateUrl : 'pages/test.html',
                controller  : 'mainController'
            })

            // route for the tournaments page
            .when('/tournaments', {
                templateUrl : 'pages/tournaments.html',
                controller  : 'mainController'
            })
            // route for the player page
            .when('/data/:id', {
                templateUrl: function ($routeParams) {
                    return 'pages/eloapi.php?player=' + $routeParams.id;
                },
                controller  : 'mainController'
            })

            .otherwise({
                redirectTo: '/'
            });
        })

    // create the controller and inject Angular's $scope
    eloApp.controller('mainController', function($scope, $http) {

        $scope.players = [];
        $scope.search_string = '';

        this.getPlayers = function(){
            $http.get("http://meleeinfo.net/geteloplayers.php")
            .success(function(data){
                $scope.players = data;
            });
        }

        this.getPlayers();

    });



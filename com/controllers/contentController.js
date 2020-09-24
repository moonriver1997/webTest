app.controller('ContentCtrl', function($scope, $state, $rootScope) {
    'use strict';
    $scope.root = $rootScope;
    $('#menu-'+$rootScope.state.stateName).prop('checked', true);
    console.log('controller log');
})
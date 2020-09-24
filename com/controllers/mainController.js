app.controller('MainCtrl', function($scope, $state, $rootScope) {
    'use strict';
    $scope.root = $rootScope;
    $rootScope.menuItem = ['MoonRiver', 'Experiment', 'Data', 'Code', 'Charts'];
    $rootScope.css = {
        main_bgColor: '#7FB3D5'
    };
    $rootScope.state = {
        stateName: ''
    };
    
    $scope.getMenuUrl = function (idx) {
        return "#/" + $rootScope.menuItem[idx];
    }
    

    $scope.$on('$stateChangeSuccess', function () {
        $rootScope.state.stateName = $state.current.name;
        console.log('#menu-'+$rootScope.state.stateName);
        $('#menu-'+$rootScope.state.stateName).prop('checked', true);
    })

    
//    $(document).ready(function(){
//            $(window).resize(function() {
//                resizeCircle();
//                barChart();
//                treeChart();
//            });
//        });
})
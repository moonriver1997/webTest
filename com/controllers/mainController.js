app.controller('MainCtrl', ['$scope', '$state', '$rootScope', 'WebData', function($scope, $state, $rootScope, WebData) {
    'use strict';
    $scope.root = $rootScope;
    $rootScope.menuItem = ['MoonRiver', 'Experiment', 'Data', 'Code', 'Charts'];
    $rootScope.css = {
        main_bgColor: '#7FB3D5'
    };
    $rootScope.state = {
        stateName: '',
        stateShow: 0,
    };
    $rootScope.data = ''
    
    $scope.getMenuUrl = function (idx) {
        return "#/" + $rootScope.menuItem[idx];
    }

    $scope.buttonClick = function () {
        $rootScope.state.stateShow ++;
        let tmp = WebData.get().then(function (response) {
            $rootScope.data = response;
            console.log(response);
            console.log(typeof(response))
        })
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
}])
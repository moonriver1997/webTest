(function() {
    function WebData($http) {

        let obj = {};

        obj.get = function () {
            return $http.get('https://histock.tw/stock/chip/chartdata.aspx?no=2443&days=400&m=dailyk,close,volume,mean5,mean10,mean20,mean60,mean120,mean240,mean5volume,mean20volume,k9,d9,rsi6,rsi12,william20,dif,macd,osc').then(function (response) { return response.data;})
        }

        // obj.post = function (q, object) {
        //     return $http.post('php/dbData.php?fn=' + q, object).then(function (response) { return response.data;});
        // };
        
        // obj.get = function (q) {
        //     return $http.get('php/dbData.php?fn=' + q).then(function (response) { return response.data;})
        // };
        
        return obj;
    }
    angular.module('myApp')
        .factory('WebData', [ '$http', WebData ]);
})();
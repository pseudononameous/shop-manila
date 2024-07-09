app.controller('OrdersReportCtrl', ['$scope', '$http',
    function ($scope, $http) {

        $scope.data = {
            id: 123
        };


        //$scope.export = function () {
        //
        //    $http.post(siteUrl + 'admin/export/excel', $scope.data).success(function (returnValue) {
        //        console.info(returnValue);
        //    });
        //
        //};

        //$scope.export = function () {
        //
        //    var redirect = function(url, method) {
        //        $('<form>', {
        //            method: method,
        //            action: url,
        //            data: $scope.data
        //        }).submit();
        //    };
        //
        //
        //
        //    redirect(siteUrl + 'admin/export/excel', 'post');
        //};

    }
]);
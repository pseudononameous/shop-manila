app.controller('ChangePasswordCtrl', ['$scope', '$http', 'Record', 'Swal', 
    function($scope, $http, Record, Swal) {

        $scope.data = {};

        $scope.data.id = js.customerId;

        var moduleRoute = 'account/change-password';
        var ajaxRoute = 'customer/changePassword';
        
        $scope.changePassword = function() {

            function cb() {
                window.location.href = siteUrl + moduleRoute;
            }

            
            $scope.data.fields = ['new_password', 'confirm_password'];

            $http.post(siteUrl + ajaxRoute, $scope.data ).success(function(returnValue) {

                angular.forEach($scope.data.fields, function(i) {
                    $scope.data.errorMsg[i] = returnValue[i];
                });

                if (returnValue == 'true') {
                    Swal.update(cb);
                }
            });
            

        };

    }
]);
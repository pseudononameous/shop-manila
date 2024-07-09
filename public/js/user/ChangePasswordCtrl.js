app.controller('ChangePasswordCtrl', ['$scope', '$http', 'Swal',
    function($scope, $http, Swal) {

        $scope.data = {};

        $scope.data.id = js.userId;

        $scope.changePassword = function() {

            function cb() {
                window.location.href = siteUrl + 'dashboard';
            }

            
            $scope.data.fields = ['new_password', 'confirm_password'];

            $http.post(siteUrl + 'user/change-password', $scope.data ).success(function(returnValue) {

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
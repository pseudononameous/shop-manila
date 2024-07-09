app.controller('RegisterCtrl', ['$scope', 'Record', 'Swal',
    function($scope, Record, Swal) {

        var moduleRoute = 'admin/customers';
        var ajaxRoute = 'customer/register';

        $scope.data = {};

        $scope.data.errorMsg = [];

        $scope.submit = function() {

            function cb() {
                window.location.href = siteUrl;
            }


            $scope.data.fields = ['email', 'password', 'confirm_password', 'first_name', 'last_name', 'billing_address', 'shipping_address', 'telephone_number'];

            Record.store(ajaxRoute, $scope.data).then(function(returnValue) {

                angular.forEach($scope.data.fields, function(i) {
                    $scope.data.errorMsg[i] = returnValue.data[i];
                });

                if (returnValue.data == 'true') {
                    Swal.save(cb);
                }

            });

        };

    }
]);
app.controller('EditCustomerMngtCtrl', ['$scope', 'Initialize', 'Record', 'Swal',
    function($scope, Initialize, Record, Swal) {

        $scope.data = {
            errorMsg: [],
            title: 'Edit',

        };
        $scope.data.id = xp.id;

        var moduleRoute = 'admin/customers';
        var ajaxRoute = 'ajax/customers';


        Initialize.retrieveRecord(ajaxRoute, $scope.data.id).then(function(returnValue){

            var res = returnValue.data;

            $scope.data.email = res.email;
            $scope.data.firstName = res.first_name;
            $scope.data.lastName = res.last_name;
            $scope.data.billingAddress = res.billing_address;
            $scope.data.shippingAddress = res.shipping_address;
            $scope.data.telephoneNumber = res.telephone_number;
            $scope.data.mobileNumber = res.mobile_number;
            $scope.data.status = res.status;

        });

        $scope.save = function() {

            function cb() {
                window.location.href = siteUrl + moduleRoute;
            }

            $scope.data.fields = ['email', 'first_name', 'last_name', 'billing_address', 'shipping_address', 'telephone_number', 'mobile_number'];

            Record.update(moduleRoute, $scope.data.id, $scope.data).then(function(returnValue) {

                angular.forEach($scope.data.fields, function(i) {
                    $scope.data.errorMsg[i] = returnValue.data[i];
                });
                
                if (returnValue.data == 'true') {
                    Swal.update(cb);
                }

            });

        };


        

    }
]);
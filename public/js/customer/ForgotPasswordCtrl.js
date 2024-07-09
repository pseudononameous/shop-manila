app.controller('ForgotPasswordCtrl', ['$scope', '$http', 'Record',
    function($scope, $http, Record) {

        $scope.data = {};

        $scope.data.id = xp.customerId;

        function cb(){
            window.location.href = siteUrl;
        }
        
        $scope.submit = function() {

            $http.post('customer/resetPassword',$scope.data).success(function(returnValue) {

                if(returnValue == 'true'){

                    swal('Please check your email for your new password');

                }

            });
        

        };

    }
]);
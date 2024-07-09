app.controller('LoginCtrl', ['$scope', '$http',
    function($scope, $http) {

        $scope.data = {};

        $scope.data.inputs = ['email', 'password'];

        if (typeof(xp) != 'undefined'){
            $scope.data.authenticate = xp.authenticate;
            $scope.data.message = 'You must be logged in to continue.';
        }

        $scope.submit = function() {

            $http.post('customer/login', $scope.data).success(function(returnValue) {
            
                if(returnValue){
                    window.location.href = siteUrl + 'account/orders';
                }else{
                    $scope.data.authenticate = 1;
                    $scope.data.message = 'Invalid email/password';
                }

            });
        };
    }
]);
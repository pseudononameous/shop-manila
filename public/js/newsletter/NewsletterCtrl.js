app.controller('NewsletterCtrl', ['$scope', '$http', 'Swal', 'Newsletter',
    function($scope, $http, Swal, Newsletter) {

        $scope.data = {};

        $scope.sign = function(sign){

            Newsletter.sign($scope.data).then(function(){

                function cb(){
                    window.location.reload();
                }

                Swal.sign(cb);
            });

        }

        ////$scope.option = {};
        //
        //$scope.subscribe = true;
        //
        //console.info($scope.subscribe);
        //
        //$scope.select = console.info($scope.subscribe);

    }

]);
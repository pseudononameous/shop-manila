app.controller('SignUpCtrl', ['$scope', '$http', 'Swal', 'Newsletter',
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

        //$scope.option = {};

        $scope.subscribe = false;
        $scope.data = {};


        $scope.selected = function(){

            $scope.selected = $scope.subscribe;

            if(!$scope.selected){
               console.info($scope.data.email);
            }
        }
    }

]);
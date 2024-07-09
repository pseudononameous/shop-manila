app.controller('CustomerListCtrl', ['$scope', 'CustomerResource', 'Swal',
    function($scope, CustomerResource, Swal) {


        $scope.delete = function(id) {

            function cb() {

                CustomerResource.delete({id: id});

            }

            Swal.del(cb);

        };



    }
]);
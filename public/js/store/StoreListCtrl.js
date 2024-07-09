app.controller('StoreListCtrl', ['$scope', 'Swal', 'StoreResource',
    function($scope, Swal, StoreResource) {

        $scope.delete = function(id) {

             function cb() {

                StoreResource.delete({id: id});

            }

            Swal.del(cb);
    
        };




    }
]);
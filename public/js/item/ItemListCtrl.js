app.controller('ItemListCtrl', ['$scope', 'Initialize', 'Swal', 'ItemResource',
    function($scope, Initialize, Swal, ItemResource) {

        $scope.delete = function(id) {

             function cb() {

                ItemResource.delete({id: id});

            }

            Swal.del(cb);
    
        };


    }
]);
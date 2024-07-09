app.controller('ShipmentListCtrl', ['$scope', 'Swal', 'ShipmentResource',
    function($scope, Swal, ShipmentResource) {

        $scope.delete = function(id) {

             function cb() {

                 ShipmentResource.delete({id: id});

            }

            Swal.del(cb);

        };

    }
]);
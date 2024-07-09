app.controller('EventListCtrl', ['$scope', 'EventResource', 'Swal',
    function($scope, EventResource, Swal) {


        $scope.delete = function(id) {

            function cb() {

                EventResource.delete({id: id});

            }

            Swal.del(cb);

        };



    }
]);
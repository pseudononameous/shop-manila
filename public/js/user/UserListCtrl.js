app.controller('UserListCtrl', ['$scope', 'Initialize', 'Swal', 'UserResource',
    function($scope, Initialize, Swal, UserResource) {

        $scope.delete = function(id) {

             function cb() {


                UserResource.delete({id: id});
                 setTimeout(function(){ location.reload(); }, 1000);
                 

            }

            Swal.del(cb);
    
        };

    }
]);
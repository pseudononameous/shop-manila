app.controller('NewsListCtrl', ['$scope', 'Swal', 'NewsResource',
    function($scope, Swal, NewsResource) {

        $scope.delete = function(id) {

            function cb() {

                NewsResource.delete({id: id});

            }

            Swal.del(cb);

        };

    }
]);
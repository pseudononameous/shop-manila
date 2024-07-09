app.controller('CouponListCtrl', ['$scope', 'Swal', 'CouponResource',
    function($scope, Swal, CouponResource) {

        $scope.delete = function(id) {

            function cb() {

                CouponResource.delete({id: id});

            }

            Swal.del(cb);

        };

    }
]);
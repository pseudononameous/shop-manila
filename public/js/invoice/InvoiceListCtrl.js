app.controller('InvoiceListCtrl', ['$scope', 'Swal', 'InvoiceResource',
    function($scope, Swal, InvoiceResource) {

        $scope.delete = function(id) {

             function cb() {

                 InvoiceResource.delete({id: id});

            }

            Swal.del(cb);

        };

    }
]);
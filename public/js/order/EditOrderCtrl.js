app.controller('EditOrderCtrl', ['$scope', 'Swal', 'OrderResource', 'Initialize', 'Order',
    function ($scope, Swal, OrderResource, Initialize, Order) {

        $scope.data = {
            id: js.id
        };

        $scope.options = {};

        $scope.invoice = function (orderHeaderId) {

            window.location.href = siteUrl + 'admin/invoices/create?orderHeaderId=' + orderHeaderId;

        };

        $scope.ship = function (orderHeaderId) {
            window.location.href = siteUrl + 'admin/shipments/create?orderHeaderId=' + orderHeaderId;
        };

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/orders';
            }

            OrderResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        $scope.delete = function (id) {

            function cb() {

                Order.delete({orderHeaderId: id});

            }

            Swal.delete(cb);

        };

        var getRecord = function () {

            return Initialize.getRecord('order', $scope.data.id).then(function (returnValue) {

                var res = returnValue.data;

                $scope.data = res;

            });

        };

        getRecord();

    }
]);
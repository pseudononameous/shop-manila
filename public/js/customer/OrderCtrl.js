app.controller('OrderCtrl', ['$scope', '$filter', 'Initialize', 'Record', 'Customer', 'ngTableParams',
    function($scope, $filter, Initialize, Record, Customer, ngTableParams) {

        $scope.data = {};

        $scope.data.id = xp.customerId;


        Customer.getOrders($scope.data.id).then(function(returnValue){

            var data = returnValue.data;

            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 10
            }, {
                total: data.length,
                getData: function($defer, params) {
 
                    var orderedData = params.filter() ? $filter('filter')(data, params.filter()) :data;
                    $scope.data.tableRecords = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    params.total(orderedData.length);
                    $defer.resolve($scope.data.tableRecords);

                }
            }); 

        });

        $scope.view = function(id) {
            window.location.href = siteUrl + 'account/orders/view/' + id;
        };



        

    }
]);
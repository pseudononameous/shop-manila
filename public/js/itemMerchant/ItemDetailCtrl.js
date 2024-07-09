app.controller('ItemDetailCtrl', ['$scope', 'Initialize', 'Cart', 'Swal', 'Item',
    function ($scope, Initialize, Cart, Swal, Item) {

        $scope.data = {
            id: js.id,
            itemEvent: js.itemEvent,
            qty: 0
        };
        $scope.tempData = {};

        $scope.config = {
            stockPerSize: []
        };

        $scope.add = function (itemId) {

            
            Cart.add(itemId, $scope.data).then(function () {
                Swal.addToCart();
            });

        };

        $scope.getAllowedQty = function () {

            $scope.config.allowedQty = $scope.config.stockPerSize[$scope.data.sizeId];

        };

        var getItemSizes = function () {

            return Item.getAssignedItemSize($scope.data.id).success(function (returnValue) {
                $scope.config.sizes = returnValue;
                $scope.config.hasSizes = 1;
                if ($scope.config.sizes.length == 0) {
                    $scope.config.hasSizes = 0;
                }
            });

        },
            getRecord = function () {

                return Initialize.getRecord('item', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.tempData = res;

                });

            },
        preLoadOptions = function(){

            $scope.config.allowedQty = $scope.tempData.qty;

            angular.forEach($scope.config.sizes, function (i, key) {
                $scope.config.stockPerSize[i.option_size_id] = i.stock;
            });

            //console.info($scope.config.sizes);

        };

        getItemSizes().then(getRecord).then(preLoadOptions);

    }
]);
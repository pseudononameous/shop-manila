app.controller('ItemCategoryListCtrl', ['$scope', '$http', 'Initialize', 'Cart', 'Item',
    function($scope, $http, Initialize, Cart, Item) {

        var url = 'items';
        $scope.data = {
            products: [],
            successAdd: 0
        };
        $scope.offset = 0;
        $scope.limit = 2;

        $scope.data.storeUrl = xp.storeUrl;
        $scope.data.category = xp.category;

        $scope.loadMore = function() {

            $scope.offset += $scope.limit;

            $scope.limit += $scope.limit;
            displayProductsByCategory();

        };

        // $scope.setPage = function(pageNo) {
        //     $scope.currentPage = pageNo;
        // };

        // $scope.pageChanged = function() {
        //     Item.displayProducts($scope.data.storeUrl, $scope.currentPage).then(function(returnValue) {

        //         $scope.data.products = returnValue.data;
        //     });

        // };

        $scope.addToCart = function(id) {

            Cart.addToCart(id).then(function(returnValue) {
                $scope.data.successAdd = 1;
                // window.location.href = siteUrl + 'cart';
            });
        };


        var displayProductsByCategory = function() {

                return Item.displayProductsByCategory($scope.data.category, $scope.offset, $scope.limit).then(function(returnValue) {

                    angular.forEach(returnValue.data, function(i) {
                        $scope.data.products.push(i);
                    });

                    /*Set primary image and price of product*/
                    angular.forEach($scope.data.products, function(pr, key) {

                        $scope.data.products[key].price = (pr.on_sale == 1) ? pr.discounted_price : pr.selling_price;

                        angular.forEach(pr.item.item_image, function(i) {
                            if (i.primary) {
                                $scope.data.products[key].primaryImage = siteUrl + 'uploads/items/' + i.file_name;
                            }

                        });

                    });

                });
            },
            countRecords = function() {

                return $http.get(siteUrl + 'items/countDisplayProductsByCategory/' + $scope.data.category).success(function(returnValue) {
                    $scope.totalItems = returnValue;
                });

            };

        displayProductsByCategory().then(countRecords);
    }
]);
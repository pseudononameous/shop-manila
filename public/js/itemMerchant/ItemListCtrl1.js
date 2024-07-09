app.controller('ItemListCtrl', ['$scope', '$http', 'Initialize', 'Cart',  'Item', 'Swal',
    function($scope, $http, Initialize, Cart, Item, Swal) {
        var url = 'items';
        $scope.data = {};
        $scope.currentPage = 1;

        $scope.data.storeUrl = xp.storeUrl;

        $scope.setPage = function(pageNo) {
            $scope.currentPage = pageNo;
        };

        $scope.pageChanged = function() {
            Item.displayProducts($scope.data.storeUrl, $scope.currentPage).then(function(returnValue){
                
                $scope.data.products = returnValue.data;
            });

        };

        $scope.addToCart = function(id) {

            Cart.addToCart(id).then(function(returnValue) {
                window.location.href = siteUrl + 'cart';
            });
        };


        var displayProducts = function(){

            return Item.displayProducts($scope.data.storeUrl, $scope.currentPage).then(function(returnValue){
                $scope.data.products = returnValue.data;

            });
        },
        countRecords = function(){

            return $http.get(siteUrl + 'items/countDisplayProducts/' + $scope.data.storeUrl).success(function(returnValue) {
                $scope.totalItems = returnValue;
            });
    
        };

       displayProducts().then(countRecords);
    }
]);
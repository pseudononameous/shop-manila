app.controller('WishlistCtrl', ['$scope', 'Initialize', 'WishlistResource', 'Swal', 'Cart',
    function($scope, Initialize, WishlistResource, Swal, Cart) {

        $scope.data = {};

        $scope.addToWishlist = function(itemId) {
            Swal.loading();

            var data = {
                item_id : itemId
            }

            WishlistResource.save(data, function (returnValue) {
                Swal.addToWishlist();
            });

        };

        $scope.addToCart = function(itemId) {

            var data = {
                item_id: itemId,
                qty: 1,
            }

            Cart.add(itemId, data).then(function() {
                Swal.addToCart();
            });

        };

        $scope.delete = function(id) {

            function cb() {
                WishlistResource.delete({id: id});
                setTimeout(function(){ location.reload() }, 1000);
            }
            swal({
                title: "",
                type: "warning",
                text: "Remove item from wishlist?",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then(function () {
                cb();
            });

        };

    }
]);
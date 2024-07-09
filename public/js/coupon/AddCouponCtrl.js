app.controller('AddCouponCtrl', ['$scope', 'Swal', 'CouponResource', 'Coupon', 'Store',
    function ($scope, Swal, CouponResource, Coupon, Store) {

        $scope.data = {};
        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/coupons';
            }

            CouponResource.save($scope.data, function () {
                Swal.save(cb);
            }, function (errors) {
                $scope.data.errors = errors.data;
            });

        };

        var getCouponTypes = function () {

            return Coupon.getCouponTypes().then(function (returnValue) {
                $scope.options.couponTypes = returnValue.data;

            })
        },
        getStores = function () {
            return Store.getStores().then(function (returnValue) {
                $scope.options.stores = returnValue.data;
            });
        };
        getCouponTypes().then(getStores);


    }
]);
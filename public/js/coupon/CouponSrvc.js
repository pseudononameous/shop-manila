app.factory('Coupon', function($http) {
    return {

        getCoupon: function(data) {

            var promise = $http.post(siteUrl + 'coupon/get-coupon', data);
            return promise;

        },

        useCoupon: function(data) {
            var promise = $http.post(siteUrl + 'coupon/use-coupon', data);
            return promise;
        },

        disableCoupon: function() {
            var promise = $http.post(siteUrl + 'coupon/disable-coupon');
            return promise;
        },

        getDiscount: function() {
            var promise = $http.get(siteUrl + 'coupon/get-discount');
            return promise;
        },
        getAppliedCoupon: function() {
            var promise = $http.get(siteUrl + 'coupon/get-applied-coupon');
            return promise;
        },

        getCouponTypes: function() {

            var promise = $http.get(siteUrl + 'coupon/get-coupon-types');

            return promise;

        }
    };
});

app.factory('CouponResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/coupons/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);
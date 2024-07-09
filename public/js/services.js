/* ==========================================================================
 Services
 reusable functions
 ========================================================================== */


/**
 * Swal
 *
 * Use sweet alert plugin to display messages
 *
 */
app.factory('Swal', function () {
    return {
        save: function (cb) {
            swal({
                title: "Saved",
                text: "Record successfully saved!",
                type: "success",
            }).then(function () {
                cb();
            });
        },

        update: function (cb) {
            swal({
                title: "Updated",
                text: "Record successfully updated!",
                type: "success",
            }).then(function () {
                cb();
            });
        },

        del: function (cb) {
            swal({
                title: "Are you sure to delete record?",
                type: "warning",
                text: "You will not be able to recover the data once deleted",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
            }).then(function () {
                cb();

                swal({
                    title: "Deleted",
                    text: "Record sucessfully deleted!",
                    type: "success",
                }, function () {
                    location.reload();
                });

            });
        },
        cancel: function (cb) {

            console.log('cancel order');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the data once voided.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Void it!",
            }).then(function () {
                cb();

                swal({
                    title: "Voided",
                    text: "Record sucessfully voided!",
                    type: "success",
                }, function () {
                    location.reload();
                });

            });
        },

        sign: function (cb) {
            swal({
                title: "Thank You!",
                text: "Successfully subscribed to our newsletter!",
                type: "success",
            }).then(function () {
                cb();
            });
        },

        addToCart: function () {

            swal({
                title: "Item added to cart!",
                text: "Go to bag?",
                type: "success",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No, continue shopping",
                confirmButtonColor: "#A5DC86",
                closeOnCancel: true,
                reverseButtons : true
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.href = siteUrl + 'cart';
                }
            });
        },
        
        loading: function () {

            swal({
                title: "Loading",
                text: "Please wait...",
                showConfirmButton: false,
                allowEscapeKey: false,
                imageUrl: siteUrl + "images/loader.gif"
            });

        },

        addToWishlist: function () {
            swal({
                title: "Success!",
                text: "Successfully added to wishlist!",
                type: "success",
            });
        },
        accept: function (cb) {
            swal({
                title: "Are you sure you want to accept this order?",
                text: "You will not be able to change the data once accepted.",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#17A98C",
                confirmButtonText: "Yes, we accept!",
            }).then(function () {
                cb();

                swal({
                    title: "Accepted",
                    text: "Order sucessfully accepted!",
                    type: "success",
                }, function () {
                    location.reload();
                });

            });
        },
        reject: function (cb) {
            swal({
                title: "Are you sure you want to reject this order?",
                text: "You will not be able to change the data once rejected.",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, we reject!",
            }).then(function () {
                cb();

                // swal({
                //     title: "Rejected",
                //     closeOnConfirm: true,
                //     text: "Order sucessfully rejected!",
                //     type: "success",
                // }, function () {
                //     location.reload();
                // });

            });
        },

        ship: function (cb) {
            swal({
                title: "Are you sure you want to ship this order?",
                text: "You will not be able to change the data once shipped.",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#17A98C",
                confirmButtonText: "Yes, ship it!",
            }).then(function () {
                cb().then(function () {

                    swal({
                        title: "Shipped",
                        text: "Order sucessfully shipped!",
                        type: "success",
                    }, function () {
                        location.reload();
                    });

                });

            });
        },
    };
});

/**
 * Initialize
 *
 * Initialize fetching of data from database
 *
 */

app.factory("Initialize", function ($http) {

    return {

        getRecord: function (url, id) {

            var promise = $http.get(siteUrl + url + '/get-record/' + id);
            return promise;
        },


    };

});


app.factory('ImageUpload', function ($http) {

    return {


        /**
         * Save multiple images to database
         * @param  {object} imgData          contains primary image data
         * @param  {object} images           contains filename of images
         * @param  {string} model what model to use when saving
         * @return {object}                  promise
         */
        saveMultipleImages: function (imgData, images, model, foreignKeyField, foreignKeyId) {

            angular.forEach(images, function (i, key) {

                images[key].primaryImage = 0;

                if (i.fileName == imgData.primaryImage) {
                    images[key].primaryImage = 1;
                }

            });

            var data = {
                images: images,
                model: model,
                foreignKeyField: foreignKeyField,
                foreignKeyId: foreignKeyId
            };

            var promise = $http.post(siteUrl + 'upload/saveMultipleImages', data);

            return promise;

        },

        deleteImage: function (data) {

            var promise = $http.post(siteUrl + 'upload/deleteImage', data);

            return promise;

        }
    };
});

app.factory('ItemCategory', function ($http) {

    return {

        getCategories: function () {

            var promise = $http.get(siteUrl + 'item-category/get-categories');

            return promise;

        },

        saveItemCategories: function (itemId, data) {

            var promise = $http.post(siteUrl + 'item-category/save-item-categories/' + itemId, data);
            return promise;
        },
    };
});

app.factory('ItemSize', function ($http) {

    return {

        getSizes: function () {

            var promise = $http.get(siteUrl + 'item-size/get-sizes');

            return promise;

        },

        saveItemSizes: function (itemId, data) {

            var promise = $http.post(siteUrl + 'item-size/save-item-sizes/' + itemId, data);
            return promise;
        },
    };
});

app.factory('City', function ($http) {

    return {

        getCities: function () {

            var promise = $http.get(siteUrl + 'city/get-cities');

            return promise;

        },
    };
});

app.factory('GoogleAnalytics', function ($http) {

    return {

        sendEcommerce: function (orderHeaderId, res) {

            ga('ecommerce:addTransaction', {
                'id': orderHeaderId,
                'affiliation': 'Shop Manila',
                'revenue': res.grand_total,
                'shipping': res.shipping_rate,
            });

            angular.forEach(res.order_detail, function (value, key) {

                var itemObj = {
                    'id': orderHeaderId,
                    'name': value.item.name,
                    'sku': value.item.sku,
                    'price': value.price,
                    'quantity': value.qty,
                }

                ga('ecommerce:addItem', itemObj);

            });

            ga('ecommerce:send');

            console.info('ga sent');

        },
    };
});
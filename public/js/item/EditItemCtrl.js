app.controller('EditItemCtrl', ['$scope', '$http', 'Initialize', 'Swal', 'ItemResource', 'ItemCategory', 'ItemSize', 'ItemEvent', 'Upload', 'ImageUpload', 'Store', 'Tag', 'Event',
    function ($scope, $http, Initialize, Swal, ItemResource, ItemCategory, ItemSize, ItemEvent, Upload, ImageUpload, Store, Tag, Event) {

        $scope.data = {
            id: js.id
        };

        $scope.tags = [];

        $scope.size = {
            stock: []
        };

        $scope.event = {
            event: [],
            price: []
        };

        $scope.config = {
            imageLimit: 6,
            events: []
        };

        $scope.options = {};
        $scope.imgData = {};
        $scope.images = [];
        $scope.deletedImages = [];

        /*Multi event item*/
        $scope.addEvent = function () {

            var c = $scope.config.events.length;
            $scope.config.events.push([c]);

        };


        $scope.removeEvent = function () {

            var lastItemIndex = ($scope.config.events.length - 1);

            $scope.config.events.splice(lastItemIndex, 1);

            $scope.event.event[lastItemIndex] = '';
            $scope.event.price[lastItemIndex] = '';

        };

        $scope.$watch('config.events', function (newValue, oldValue) {

            $scope.config.eventInLimit = false;
            $scope.config.eventIsMinimum = false;

            if(newValue.length == 4){
                $scope.config.eventInLimit = true;
            }

            if(newValue.length == 0){
                $scope.config.eventIsMinimum = true;
            }
        }, true);
        /*End*/


        $scope.$watch('files', function () {
            $scope.upload($scope.files);
        });


        $scope.deleteImage = function (fileName, key) {

            var data = {
                fileName: fileName,
            };

            $scope.deletedImages.push(data);

            $scope.images.splice(key, 1);

        };

        $scope.upload = function (files) {
            if (files && files.length) {

                Swal.loading();

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    Upload.upload({
                        url: siteUrl + 'upload/upload',

                        file: file
                    }).success(function (data) {
                        $scope.images.push(data);
                        swal.close();
                    }).error(function () {
                        Swal.error();
                    });
                }
            }
        };

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/items';
            }

            ItemResource.update($scope.data, function () {

                var foreignKeyField = 'item_id';
                var model = 'App\\ItemImage';

                var saveImages = function () {
                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
                    },
                    saveItemCategories = function () {
                        return ItemCategory.saveItemCategories($scope.data.id, $scope.options.categories);
                    },
                    saveItemSizes = function () {

                        var data = {
                            sizes: $scope.options.sizes,
                            stock: $scope.size.stock
                        };

                        // return ItemSize.saveItemSizes($scope.data.id, $scope.options.sizes);
                        return ItemSize.saveItemSizes($scope.data.id, data);
                    },
                    saveItemTags = function(){

                        var data = {
                            itemId: $scope.data.id,
                            tags: $scope.tags
                        }

                        return Tag.saveItemTags(data);
                    },
                    updateItemEvents = function(){

                        return ItemEvent.saveItemEvents($scope.data.id, $scope.event);
                    },
                    success = function () {
                        Swal.update(cb);
                    };

                saveImages()
                    .then(saveItemCategories)
                    .then(saveItemSizes)
                    .then(saveItemTags)
                    .then(updateItemEvents)
                    .then(success);

            }, function (errors) {
                $scope.config.errors = errors.data;
                swal.close();
            });

        };


        var getCategories = function () {
                Swal.loading();

                return ItemCategory.getCategories().then(function (returnValue) {
                    $scope.options.categories = returnValue.data;
                });

            },
            getSizes = function () {

                return ItemSize.getSizes().then(function (returnValue) {
                    $scope.options.sizes = returnValue.data;
                });

            },
            getStores = function () {
                return Store.getStores().then(function (returnValue) {
                    $scope.options.stores = returnValue.data;
                });
            },
            getEvents = function () {
                return Event.getEvents().then(function (returnValue) {
                    $scope.options.events = returnValue.data;
                });
            },

            getRecord = function () {

                return Initialize.getRecord('item', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;
                    $scope.data.is_featured = (res.is_featured == 1) ? true : false;
                    $scope.data.on_sale = (res.on_sale == 1) ? true : false;
                    $scope.options.sCategory = res.item_category;
                    $scope.options.sSize = res.item_size;
                    $scope.sTags = res.item_tag;

                    $scope.data.discounted_price_start_date = (res.discounted_price_start_date == null) ? null : new Date(res.discounted_price_start_date);
                    $scope.data.discounted_price_end_date = (res.discounted_price_end_date == null) ? null : new Date(res.discounted_price_end_date);


                    /*Pre load item sizes stock*/
                    angular.forEach(res.item_size, function (i, key) {
                        $scope.size.stock[i.option_size_id - 1] = i.stock;
                    });
                    
                    angular.forEach(res.item_event, function (value, key) {

                        $scope.config.events.push(value);

                        $scope.event.event[key] = value.event;
                        $scope.event.price[key] = value.event_price;
                        
                    });

                });

            },
            preLoadOptions = function () {

                /*Pre load categories*/
                var categories = $scope.options.sCategory;
                var categoriesLen = $scope.options.categories.length;

                angular.forEach(categories, function (i) {

                    var categoryId = i.category_detail_id;

                    for (var ctr = 0; ctr < categoriesLen; ctr++) {
                        if ($scope.options.categories[ctr].hasOwnProperty('id') && $scope.options.categories[ctr].id === categoryId) {
                            $scope.options.categories[ctr].selected = true;
                        }
                    }

                });


                /*Pre load sizes*/
                var sizes = $scope.options.sSize;
                var sizesLen = $scope.options.sizes.length;

                angular.forEach(sizes, function (i) {

                    var sizeId = i.option_size_id;

                    for (var ctr = 0; ctr < sizesLen; ctr++) {
                        if ($scope.options.sizes[ctr].hasOwnProperty('id') && $scope.options.sizes[ctr].id === sizeId) {
                            $scope.options.sizes[ctr].selected = true;
                        }
                    }

                });

                /*Pre load stores*/
                angular.forEach($scope.options.stores, function (i) {

                    if ($scope.data.store_id == i.id) {
                        $scope.data.store = i;
                    }
                });

                /*Pre load events*/
                angular.forEach($scope.options.events, function (i) {

                    if ($scope.data.event_id == i.id) {
                        $scope.data.event = i;
                    }
                });

                /*Pre load tags*/
                angular.forEach($scope.sTags, function (value, key) {
                    $scope.tags[key] = {'text': value.name}
                });

                /*Pre load images*/
                angular.forEach($scope.data.item_image, function (i) {

                    var obj = {
                        key: i.id,
                        fileName: i.file_name,
                        path: i.path
                    };

                    $scope.images.push(obj);

                    if (i.is_primary == 1) {
                        $scope.imgData.primaryImage = obj.fileName;
                    }

                });

                delete $scope.data.item_image;

                swal.close();

            };

        getCategories().then(getSizes).then(getStores).then(getEvents).then(getRecord).then(preLoadOptions);
    }
]);
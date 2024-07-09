app.controller('AddItemCtrl', ['$scope', 'Swal', 'ItemResource', 'ItemCategory', 'ItemSize', 'ItemEvent' , 'Upload', 'ImageUpload', 'Store', 'Tag', 'Event',
    function ($scope, Swal, ItemResource, ItemCategory, ItemSize, ItemEvent, Upload, ImageUpload, Store, Tag, Event) {


        $scope.data = {
            option_status_id: 1
        };

        $scope.tags = [];

        $scope.size = {
            stock: []
        };

        $scope.config = {
            imageLimit : 6,
            //events: [0]
            events: []
        };


        $scope.event = {};
        $scope.imgData = {};
        $scope.images = [];
        $scope.options = {};

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

        //To check if uploaded image is in limit
        $scope.$watch('images', function() {

            $scope.config.inLimit = false;

            if ($scope.images.length >= $scope.config.imageLimit) {
                $scope.config.inLimit = true;
            }

        }, true);

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
                        swal.error();
                    });
                }
            }
        };

        $scope.deleteImage = function (fileName, key) {

            var data = {
                fileName: fileName,
            };

            ImageUpload.deleteImage(data).then(function (returnValue) {
                $scope.images.splice(key, 1);
            });

        };


        $scope.save = function () {

            Swal.loading();


            function cb() {
                window.location.href = siteUrl + 'admin/merchant-items';
            }


            ItemResource.save($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

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

                        return ItemSize.saveItemSizes($scope.data.id, data);
                    },
                    
                    saveItemTags = function(){

                        var data = {
                            itemId: $scope.data.id,
                            tags: $scope.tags
                        }

                        return Tag.saveItemTags(data);
                    },
                    saveItemEvents = function(){
                        // var data = {
                        //     event: $scope.options.events,
                        //     price: $scope.event.price
                        // };

                        return ItemEvent.saveItemEvents($scope.data.id, $scope.event);
                    },
                    success = function () {
                        Swal.save(cb);
                    };

                saveImages().then(saveItemCategories).then(saveItemSizes).then(saveItemTags).then(saveItemEvents).then(success);


            }, function (errors) {
                $scope.config.errors = errors.data;
            });

        };


        var getCategories = function () {

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
            };

        //getStores().then(getCategories).then(getSizes).then(getEvents);
        getCategories().then(getSizes).then(getEvents);


    }
]);
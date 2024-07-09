app.controller('EditStoreCtrl', ['$scope', 'Initialize', 'Swal', 'StoreResource', 'Upload', 'ImageUpload', 'StoreVideo',
    function ($scope, Initialize, Swal, StoreResource, Upload, ImageUpload, StoreVideo) {

        $scope.data = {
            id: js.id
        };

        $scope.videos = {
            video_link: []
        }

        $scope.config = {};
        $scope.options = {};
        $scope.imgData = {};
        $scope.images = [];
        $scope.logos = [];
        $scope.deletedImages = [];

        $scope.$watch('files', function () {
            $scope.upload($scope.files);
        });

        $scope.$watch('logoFiles', function () {
            $scope.uploadLogo($scope.logoFiles);
        });

        $scope.$watch('images', function () {

            $scope.config.photoInLimit = false;

            if ($scope.images.length > 0) {
                $scope.config.photoInLimit = true;
            }

        }, true);

        $scope.$watch('logos', function () {

            $scope.config.logoInLimit = false;

            if ($scope.logos.length > 0) {
                $scope.config.logoInLimit = true;
            }

        }, true);

        $scope.deleteImage = function (fileName, key) {

            var data = {
                fileName: fileName,
            };

            $scope.deletedImages.push(data);

            $scope.images.splice(key, 1);

        };

        $scope.deleteLogo = function (fileName, key) {

            var data = {
                fileName: fileName,
            };

            $scope.deletedImages.push(data);

            $scope.logos.splice(key, 1);

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

        $scope.uploadLogo = function (files) {

            if (files && files.length) {

                Swal.loading();

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    Upload.upload({
                        url: siteUrl + 'upload/upload',
                        file: file
                    }).success(function (data) {

                        $scope.logos.push(data);
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
                window.location.href = siteUrl + 'admin/stores';
            }

            StoreResource.update($scope.data, function () {


                var saveBanners = function () {
                        var foreignKeyField = 'store_id';
                        var model = 'App\\StoreImage';
                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
                    },

                    saveLogos = function () {

                        var foreignKeyField = 'store_id';
                        var model = 'App\\StoreLogo';

                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.logos, model, foreignKeyField, $scope.data.id);
                    },
                    saveStoreVideos = function () {

                        var data = {
                            video_link: $scope.videos.video_link
                        };

                        // return ItemSize.saveItemSizes($scope.data.id, $scope.options.sizes);
                        return StoreVideo.saveStoreVideos($scope.data.id, data);
                    },
                    success = function () {
                        Swal.update(cb);
                    }

                saveBanners().then(saveLogos).then(saveStoreVideos).then(success);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        var getRecord = function () {

                Swal.loading();

                return Initialize.getRecord('store', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                    angular.forEach(res.store_video, function (value, key) {

                        $scope.videos.video_link.push(value.video_link);

                    });


                });

            },
            preLoadOptions = function () {

                angular.forEach($scope.data.store_image, function (i) {

                    var obj = {
                        key: i.id,
                        fileName: i.file_name,
                        path: i.path
                    };

                    $scope.images.push(obj);

                    if (i.is_primary) {
                        $scope.imgData.primaryImage = obj.fileName;
                    }

                });

                delete $scope.data.store_image;

                angular.forEach($scope.data.store_logo, function (i) {

                    var obj = {
                        key: i.id,
                        fileName: i.file_name,
                        path: i.path
                    };

                    $scope.logos.push(obj);

                    if (i.is_primary) {
                        $scope.imgData.primaryImage = obj.fileName;
                    }

                });

                delete $scope.data.store_logo;

                swal.close();

            }

        getRecord().then(preLoadOptions);

    }
]);
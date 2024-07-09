app.controller('EditNewsCtrl', ['$scope', 'Swal', 'NewsResource', 'Initialize', 'Upload', 'ImageUpload',
    function ($scope, Swal, NewsResource, Initialize, Upload, ImageUpload) {

        $scope.data = {
            id: js.id
        };
        $scope.config = {
            imageLimit: 1
        };


        $scope.options = {}
        $scope.imgData = {};
        $scope.images = [];
        $scope.deletedImages = [];

        $scope.$watch('files', function () {
            $scope.upload($scope.files);
        });

        $scope.$watch('images', function() {

            $scope.config.inLimit = false;

            if ($scope.images.length >= $scope.config.imageLimit) {
                $scope.config.inLimit = true;
            }

        }, true);


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
                window.location.href = siteUrl + 'admin/news';
            }

            NewsResource.update($scope.data, function () {

                var foreignKeyField = 'news_id';
                var model = 'App\\NewsImage';

                var saveImages = function () {
                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
                    },
                    success = function () {
                        Swal.update(cb);
                    }

                saveImages().then(success);

            }, function (errors) {
                $scope.config.errors = errors.data;
                swal.close();
            });

        };


        var getRecord = function () {

                return Initialize.getRecord('news', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                });

            },
            preLoadOptions = function () {

                /*Pre load images*/
                angular.forEach($scope.data.news_image, function (i) {

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

                delete $scope.data.news_image;

                swal.close();

            }

        getRecord().then(preLoadOptions);

    }
]);
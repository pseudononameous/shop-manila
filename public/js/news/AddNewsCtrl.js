app.controller('AddNewsCtrl', ['$scope', 'Swal', 'NewsResource', 'Upload', 'ImageUpload',
    function ($scope, Swal, NewsResource, Upload, ImageUpload) {

        $scope.data = {};
        $scope.config = {};


        $scope.config = {
            imageLimit : 1
        };

        $scope.imgData = {};
        $scope.images = [];
        $scope.options = {};

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
                        Swal.error();
                    });
                }
            }
        };

        $scope.deleteImage = function (fileName, key) {

            var data = {
                fileName: fileName,
            };

            ImageUpload.deleteImage(data).then(function () {
                $scope.images.splice(key, 1);
            });

        };

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/news';
            }

            NewsResource.save($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                var foreignKeyField = 'news_id';
                var model = 'App\\NewsImage';

                var saveImages = function () {

                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
                    },
                    success = function(){
                        Swal.save(cb);

                    };

                saveImages().then(success);

            }, function (errors) {
                $scope.config.errors = errors.data;
                swal.close();
            });

        };

    }
]);
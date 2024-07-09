app.controller('EditEventCtrl', ['$scope', 'Initialize', 'Swal', 'EventResource', 'Upload', 'ImageUpload',
    function ($scope, Initialize, Swal, EventResource, Upload, ImageUpload) {

        $scope.data = {
            id: js.id
        };

        $scope.config = {
            imageLimit: 2
        };

        $scope.options = {};
        $scope.imgData = {};
        $scope.images = [];
        $scope.deletedImages = [];

        $scope.$watch('files', function () {
            $scope.upload($scope.files);
        });

        /*Disable upload button if number of images reaches the imageLimit*/
        $scope.$watch('images', function () {

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
                window.location.href = siteUrl + 'admin/events';
            }

            EventResource.update($scope.data, function () {

                var foreignKeyField = 'event_id';
                var model = 'App\\EventImage';

                var saveImages = function () {
                        return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
                    },
                    success = function () {
                        Swal.update(cb);
                    };

                saveImages().then(success);

            }, function (errors) {
                $scope.config.errors = errors.data;
                swal.close();
            });

        };


        var getRecord = function () {

                Swal.loading();

                return Initialize.getRecord('event', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                    $scope.data.start_date = new Date(res.start_date);
                    $scope.data.end_date = new Date(res.end_date);

                    var arrStartDayTime = [];
                    var arrEndDayTime = [];

                    if (res.start_day_time) {
                        arrStartDayTime = (res.start_day_time.split(':'));
                        arrEndDayTime = res.end_day_time.split(':');
                    }

                    $scope.data.start_day_time = new Date(1970, 0, 1, arrStartDayTime[0], arrStartDayTime[1], 0)
                    $scope.data.end_day_time = new Date(1970, 0, 1, arrEndDayTime[0], arrEndDayTime[1], 0)

                });

            },
            preLoadOptions = function () {

                /*Pre load images*/
                angular.forEach($scope.data.event_image, function (i) {

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

                delete $scope.data.event_image;

                swal.close();

            };

        getRecord().then(preLoadOptions);

    }
]);
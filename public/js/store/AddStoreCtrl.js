app.controller('AddStoreCtrl', ['$scope', 'Swal', 'StoreResource', 'Upload', 'ImageUpload', 'StoreVideo',
    function($scope, Swal, StoreResource, Upload, ImageUpload, StoreVideo) {


        $scope.data = {
        	option_status_id: 1
        };
		$scope.videos = {
			video_link: []
		}

		$scope.imgData = {};
		$scope.images = [];
		$scope.logos = [];
		$scope.options = {};
		$scope.config = {};


		$scope.$watch('files', function () {
			$scope.upload($scope.files);
		});

		$scope.$watch('logoFiles', function () {
			$scope.uploadLogo($scope.logoFiles);
		});

		$scope.$watch('images', function() {

			$scope.config.photoInLimit = false;

			if($scope.images.length > 0){
				$scope.config.photoInLimit = true;
			}

		}, true);

		$scope.$watch('logos', function() {

			$scope.config.logoInLimit = false;

			if($scope.logos.length > 0){
				$scope.config.logoInLimit = true;
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

		$scope.deleteImage = function (fileName, key) {

			var data = {
				fileName: fileName,
			};

			ImageUpload.deleteImage(data).then(function () {
				$scope.images.splice(key, 1);
			});

		};

		$scope.deleteLogo = function (fileName, key) {

			var data = {
				fileName: fileName,
			};

			ImageUpload.deleteImage(data).then(function () {
				$scope.logos.splice(key, 1);
			});

		};


		$scope.save = function () {

			Swal.loading();

			function cb() {
				window.location.href = siteUrl + 'admin/stores';
			}

			StoreResource.save($scope.data, function (returnValue) {

				$scope.data.id = returnValue.id;



				var saveBanners = function () {

						var foreignKeyField = 'store_id';
						var model = 'App\\StoreImage';

						return ImageUpload.saveMultipleImages($scope.imgData, $scope.images, model, foreignKeyField, $scope.data.id);
					},
					saveLogos = function(){

						var foreignKeyField = 'store_id';
						var model = 'App\\StoreLogo';

						return ImageUpload.saveMultipleImages($scope.imgData, $scope.logos, model, foreignKeyField, $scope.data.id);
					},
					saveStoreVideos = function () {

						var data = {
							video_link: $scope.videos.video_link
						};

						return StoreVideo.saveStoreVideos($scope.data.id, data);
					},
					success = function () {
						Swal.save(cb);
					}

				saveBanners().then(saveLogos).then(saveStoreVideos).then(success);


			}, function (errors) {
				$scope.data.errors = errors.data;
				swal.close();
			});

		};
        	

        


    }
]);
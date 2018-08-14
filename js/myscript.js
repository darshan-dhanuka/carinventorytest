var app = angular.module("myapp",['ngFileUpload']);
app.controller("carController",function($scope,APIServices,$http,Upload,$window){
	//toggle loader
	$scope.toggleLoader = function (loaderval) {
		if(loaderval == '1'){
			$scope.loader = true;
			$scope.overlay = true; 
		}else if(loaderval == '2'){
			$scope.loader = false;
			$scope.overlay = false; 
		}
	}
    $scope.heading = "Welcome to your mini car inventory";
    $scope.model_heading = "Welcome to your model details";
	$scope.man_name = "";
	$scope.reg_num = "";
	$scope.model_name = "";
	$scope.selectedModelName ="";
	$scope.color_name="";
	$scope.man_year ="";
	$scope.man_names = [];
	$scope.image_upload = 0;
	$scope.insertModelPage = function(){
		$window.location.href = '/model_details.html'
	}
	$scope.goToInventory = function(){
		$window.location.href = '/inventory.html'
	}
	$scope.insertManufacturer = function(){
		if($scope.man_name == ''){
			$scope.man_name_req = true;
			return false;
		}
		$scope.man_name_req = false;
		$scope.toggleLoader(1);
		APIServices.insertManufacturerName($scope.man_name).then(function(response){
			$scope.toggleLoader(2);
            if(response.data.errorCode == 0){
                alert(response.data.msg);
                $window.location.href = '/model_details.html'
            }else{
				alert(response.data.msg);
			}
        });
	}
	$scope.upload = function (file) {
		if(file == undefined || file == '' || file == null){
			return false;
		}
		var ext = file.name.split('.').pop();
		if(ext !== 'png' && ext !== 'jpg' && ext !== 'jpeg'){
			alert("Please upload only png or jpg images file");
			return false;
		}
		if($scope.reg_num == ''){
			alert("Please fill registration number of the car");
			return false;
		}
		$scope.upload_data = true;
		$scope.toggleLoader(1);
		Upload.upload({
			url: 'services/index.php',
			method:'POST',
			data: {file: file,model_id:$scope.reg_num,task:"upload_file"}
		}).then(function (resp) {
			$scope.toggleLoader(2);
			$scope.image_upload = 1;
			$scope.isDisabled = true;
			if(resp.data.errorCode == '0'){
				alert(resp.data.msg);
			}else{
				alert(resp.data.msg);
				$scope.isDisabled = false;
			}
		}, function (resp) {
			$scope.toggleLoader(2);
			console.log('Error status: ' + resp.status);
		});
	};
	$scope.fetchManufacturer = function(){
		APIServices.fetchManufacturerName().then(function(response){
            console.log(response.data);
            if(response.data.errorCode == 0){
				$scope.man_names = response.data.data;
            }
        });
	}
	$scope.fetchManufacturer();
	$scope.insertModel = function(){
		if($scope.model_name == ''){
			alert('Model name is required');
			return false;
		}
		if($scope.selectedModelName == ''){
			alert('Please select Manufacturer');
			return false;
		}
		if($scope.color_name == ''){
			alert('Please put color');
			return false;
		}
		if($scope.man_year == ''){
			alert('Please put manufacture year');
			return false;
		}
		if($scope.reg_num == ''){
			alert('Please put registration number');
			return false;
		}
		if($scope.image_upload == 0){
			alert('Please upload atleast one image');
			return false;
		}
		$scope.toggleLoader(1);
		APIServices.insertModelName($scope.model_name,$scope.selectedModelName,$scope.color_name,$scope.man_year,$scope.reg_num,$scope.note).then(function(response){
			$scope.toggleLoader(2);
            if(response.data.errorCode == 0){
                alert(response.data.msg);
                $window.location.href = '/inventory.html';
            }else{
				alert(response.data.msg);
			}
        });
	}
	$scope.first_page = function(){
		$window.location.href = '/angular.html'
	}

});
app.controller("inventoryController",function($scope,APIServices,$http,Upload,$window){
	$scope.toggleLoader = function (loaderval) {
		if(loaderval == '1'){
			$scope.loader = true;
			$scope.overlay = true; 
		}else if(loaderval == '2'){
			$scope.loader = false;
			$scope.overlay = false; 
		}
	}
	$scope.model_heading = "Welcome to your inventory";
	$scope.first_page = function(){
		$window.location.href = '/angular.html'
	}
	$scope.fetchModelList = function(){
		APIServices.getModelList().then(function(response){
            console.log(response.data);
            if(response.data.errorCode == 0){
				$scope.no_data = 0;
                $scope.table_data = response.data.data;
            }else{
				$scope.no_data = 1;
			}
        });
	}
	$scope.fetchModelList();
	$scope.get_details = function(record_id){
		APIServices.getModelDetails(record_id.manufacture_id,record_id.model_name).then(function(response){
			$scope.showModal = true;
			if(response.data.errorCode == 0){
				$scope.details_no_data = 0;
                $scope.details_table_data = response.data.data;
            }else{
				$scope.details_no_data = 1;
			}
		});
	}
	$scope.modal_close = function(){
		$scope.showModal = false;
	}
	$scope.sold = function(sold_id){
		$scope.toggleLoader(1);
		APIServices.soldModel(sold_id.id).then(function(response){
			$scope.toggleLoader(2);
			if(response.data.errorCode == 0){
				alert(response.data.msg);
				$scope.get_details(sold_id);
				$scope.fetchModelList();
            }else{
				alert(response.data.msg);
			}
		});
	}
	$scope.dwn_img = function(sold_id){
		console.log(sold_id);
		APIServices.downloadImages(sold_id.id,sold_id.registration_number).then(function(response){
			
		});
	}
});

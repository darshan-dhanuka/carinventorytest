
	app.factory('APIServices', function($http,$window) {
		var APIService = {};
		APIService.insertManufacturerName = function(man_name) {
		  return $http({
			method: 'POST', 
			url: '../services/index.php',
			data : {
					task:'insert_man',
					man_name:man_name
				}	
		  });
		}
		APIService.fetchManufacturerName = function() {
			return $http({
				method: 'POST', 
				url: 'services/index.php',
				data : {
						task:'fetch_man'
					}	
			});
		}
		APIService.insertModelName = function(model_name,selectedModelName,color_name,man_year,reg_num,note_details) {
			return $http({
				method: 'POST', 
				url: 'services/index.php',
				data : {
						task:'insert_model',
						model_name:model_name,
						selectedModelName:selectedModelName,
						color_name:color_name,
						man_year:man_year,
						reg_num:reg_num,
						note_details:note_details
					}	
			});
		}
		APIService.getModelList = function() {
			return $http({
				method: 'POST', 
				url: 'services/index.php',
				data : {
						task:'get_model'
					}	
			});
		}
		APIService.getModelDetails = function(manufacture_id,model_name) {
			return $http({
				method: 'POST', 
				url: 'services/index.php',
				data : {
						task:'get_model_details',
						manufacture_id:manufacture_id,
						model_name:model_name
					}	
			});
		}
		APIService.soldModel = function(sold_id) {
			return $http({
				method: 'POST', 
				url: 'services/index.php',
				data : {
						task:'sold_model',
						sold_id:sold_id
					}	
			});
		}
		APIService.downloadImages = function(sold_id,registration_number) {
			$window.location.href = 'services/index.php?task=dwn_img&sold_id='+sold_id+'&registration_number='+registration_number;
		}
		return APIService;
	});

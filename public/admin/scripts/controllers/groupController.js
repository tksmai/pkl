angular.module('sbAdminApp')
  .controller('Group',['$scope', '$http', function($scope, $http, $stateParams){
  	console.log($stateParams);
  	$scope.page_title = '分组管理';
	$scope.list_data = [];
	var _httpdata = {
		url:'/index.php/Group/index',
		method:'get',
		timeout:10000,
		responseType:"json",
	}
	$http(_httpdata).success(function(rpdata){
		console.log(rpdata);
		if (rpdata.status = 1){
			$scope.list_data = rpdata.data;
		}
	});
	$scope.forbid = function($event, $item, $index){
		console.log($item);
		alert($item.id);
	};
  }]);

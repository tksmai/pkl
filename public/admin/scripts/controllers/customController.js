angular.module('sbAdminApp')
  .controller('CustomPage',['$scope', '$http', function($scope, $http){
  	$scope.page_title = 'Hello Tsukasa';
	$scope.list_data = [];
	var _httpdata = {
		url:'http://zg.mahuayun.cn/Api/Test/fetchList',
		method:'get',
		timeout:10000,
		responseType:"json",
		params:{
			'device_id':'1',
			'token':'2'
		}
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

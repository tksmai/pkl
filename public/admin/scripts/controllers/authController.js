angular.module('sbAdminApp')
  .controller('Auth',['$scope', '$http', '$state', function($scope, $http, $state){
  	console.log(window.localStorage.sbAdminToken);
  	var authFlag = false;
  	var sbAdminToken = window.localStorage.sbAdminToken;
  	if (sbAdminToken) {
  		var _httpdata = {
			url:'index.php/Admin/session',
			method:'get',
			timeout:10000,
			responseType:"json",
			params:{
				'device_id':'1',
				'token':sbAdminToken
			}
		}
		$http(_httpdata).then(function successCallback(response){
			console.log(response);
			if (response.status === 200){
				authFlag = true;
			}
		}, function errorCallback(response){
			console.log('error request');
			console.log(response);
		});
  	}
  	if (authFlag === false){
  		$state.go('login');
  	}
  }]);

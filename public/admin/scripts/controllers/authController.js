angular.module('sbAdminApp')
	.controller('Auth',['$scope', '$http', '$state', function($scope, $http, $state){
		var sbAdminToken = window.localStorage.sbAdminToken;
		if (sbAdminToken) {
			var _httpdata = {
				url:'/index.php/Admin/session',
				method:'get',
				timeout:1000,
				responseType:"json",
				params:{
					'device_id':'1',
					'token':sbAdminToken
				}
			}
			$http(_httpdata).then(function successCallback(response){
				if (response.status != 200){
					redirectLogin();
				}
			}, function errorCallback(response){
				// console.log('error request');
				// console.log(response);
			});
		} else {
			redirectLogin();
		}
		var redirectLogin = function(){
			$state.go('login');
		};
		
	}]);

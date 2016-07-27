angular.module('sbAdminApp')
	.controller('Auth',['$scope', '$http', '$state', function($scope, $http, $state){
		var redirectLogin = function(){
			$state.go('login');
		};
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
				console.log('success');
			}, function errorCallback(response){
				if(response.status != 401) {
					console.log(response.statusText);
				}
				redirectLogin();
			});
		} else {
			redirectLogin();
		}	
	}]);
angular.module('sbAdminApp')
	.controller('Login',['$scope', '$http', '$state', function($scope, $http, $state){
		$scope.form = {
			account:"",
			password:""
		}
		$scope.loginAction = function($event){
			console.log($scope.form);
		}
		
	}]);
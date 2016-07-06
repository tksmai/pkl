/**
 * @ngdoc directive
 * @name izzyposWebApp.directive:adminPosHeader
 * @description
 * # adminPosHeader
 */

angular.module('sbAdminApp')
	.directive('sidebar',['$location', '$http',function() {
		return {
			templateUrl:'scripts/directives/sidebar/sidebar.html',
			restrict: 'E',
			replace: true,
			scope: {
			},
			controller:function($scope, $http){
				$scope.selectedMenu = 'dashboard';
				$scope.collapseVar = 0;
				$scope.multiCollapseVar = 0;
				var _httpdata = {
					// url:'http://vincentmai.f3322.org/pkl/public/Index/fetchNode',
					// url:'http://pkl.0n0.win/Index/fetchNode',
					url:'/Index/fetchNode',
					method:'get',
					timeout:10000,
					responseType:"json"
					// params:{
					// 	'device_id':'1',
					// 	'token':'2'
					// }
				}
				$scope.menuList = [];
				$http(_httpdata).success(function(rpdata){
					console.log(rpdata);
					if (rpdata.status = 1){
						$scope.menuList = rpdata.data;
					}
				});
				$scope.check = function(x){
					
					if(x==$scope.collapseVar)
						$scope.collapseVar = 0;
					else
						$scope.collapseVar = x;
				};
				
				$scope.multiCheck = function(y){
					
					if(y==$scope.multiCollapseVar)
						$scope.multiCollapseVar = 0;
					else
						$scope.multiCollapseVar = y;
				};
			}			
		}
	}]);

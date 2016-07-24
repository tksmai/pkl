/**
 * @ngdoc overview
 * @name sbAdminApp
 * @description
 * # sbAdminApp
 *
 * Main module of the application.
 */
// window.localStorage.sbAdminSession = ''; // 保存session id
angular
	.module('sbAdminApp', [
		'oc.lazyLoad',
		'ui.router',
		'ui.bootstrap',
		'angular-loading-bar',
	])
	.config(['$stateProvider','$urlRouterProvider','$ocLazyLoadProvider',function ($stateProvider,$urlRouterProvider,$ocLazyLoadProvider) {
		
		$ocLazyLoadProvider.config({
			debug:false,
			events:true,
		});

		$urlRouterProvider.otherwise('/admin/home');

		$stateProvider
			.state('admin', {
				url:'/admin',
				templateUrl: 'views/admin/main.html',
				controller: 'Auth', // 打算将登陆验证的controller放这里
				resolve: {
						loadMyDirectives:function($ocLazyLoad){
								return $ocLazyLoad.load(
								{
										name:'sbAdminApp',
										files:[
										'scripts/directives/header/header.js',
										'scripts/directives/header/header-notification/header-notification.js',
										'scripts/directives/sidebar/sidebar.js',
										'scripts/directives/sidebar/sidebar-search/sidebar-search.js',
										'scripts/controllers/authController.js'
										]
								}),
								$ocLazyLoad.load(
								{
									 name:'toggle-switch',
									 files:["bower_components/angular-toggle-switch/angular-toggle-switch.min.js",
													"bower_components/angular-toggle-switch/angular-toggle-switch.css"
											]
								}),
								$ocLazyLoad.load(
								{
									name:'ngAnimate',
									files:['bower_components/angular-animate/angular-animate.js']
								})
								$ocLazyLoad.load(
								{
									name:'ngCookies',
									files:['bower_components/angular-cookies/angular-cookies.js']
								})
								$ocLazyLoad.load(
								{
									name:'ngResource',
									files:['bower_components/angular-resource/angular-resource.js']
								})
								$ocLazyLoad.load(
								{
									name:'ngSanitize',
									files:['bower_components/angular-sanitize/angular-sanitize.js']
								})
								$ocLazyLoad.load(
								{
									name:'ngTouch',
									files:['bower_components/angular-touch/angular-touch.js']
								})
						}
				}
		})
			.state('admin.home',{
				url:'/home',
				controller: 'MainCtrl',
				templateUrl:'views/admin/home.html',
				resolve: {
					loadMyFiles:function($ocLazyLoad) {
						return $ocLazyLoad.load({
							name:'sbAdminApp',
							files:[
							'scripts/controllers/main.js',
							'scripts/directives/timeline/timeline.js',
							'scripts/directives/notifications/notifications.js',
							'scripts/directives/chat/chat.js',
							'scripts/directives/admin/stats/stats.js'
							]
						})
					}
				}
			})
			.state('admin.form',{
				templateUrl:'views/form.html',
				url:'/form'
		})
			.state('admin.blank',{
				templateUrl:'views/pages/blank.html',
				url:'/blank'
		})
			.state('login',{
				templateUrl:'views/pages/login.html',
				url:'/login'
		})
			.state('admin.chart',{
				templateUrl:'views/chart.html',
				url:'/chart',
				controller:'ChartCtrl',
				resolve: {
					loadMyFile:function($ocLazyLoad) {
						return $ocLazyLoad.load({
							name:'chart.js',
							files:[
								'bower_components/angular-chart.js/dist/angular-chart.min.js',
								'bower_components/angular-chart.js/dist/angular-chart.css'
							]
						}),
						$ocLazyLoad.load({
								name:'sbAdminApp',
								files:['scripts/controllers/chartContoller.js']
						})
					}
				}
		})
			.state('admin.table',{
				templateUrl:'views/table.html',
				url:'/table'
		})
			.state('admin.panels-wells',{
					templateUrl:'views/ui-elements/panels-wells.html',
					url:'/panels-wells'
			})
			.state('admin.buttons',{
				templateUrl:'views/ui-elements/buttons.html',
				url:'/buttons'
		})
			.state('admin.notifications',{
				templateUrl:'views/ui-elements/notifications.html',
				url:'/notifications'
		})
			.state('admin.typography',{
			 templateUrl:'views/ui-elements/typography.html',
			 url:'/typography'
	 })
			.state('admin.icons',{
			 templateUrl:'views/ui-elements/icons.html',
			 url:'/icons'
	 })
			.state('admin.grid',{
			 templateUrl:'views/ui-elements/grid.html',
			 url:'/grid'
	 })
		.state('admin.custom', {
			templateUrl:'views/custom.html',
			controller:'CustomPage',
			url:'/custom',
			resolve: {
				loadMyFiles:function($ocLazyLoad) {
					return $ocLazyLoad.load({
						name:'sbAdminApp',
						files:[
							'scripts/controllers/customController.js'
						]
					})
				}
			}
		})
		.state('admin.Group', {
			templateUrl:'views/group.html',
			controller:'Group',
			url:'/Group',
			resolve:{
				loadMyFiles:function($ocLazyLoad) {
					return $ocLazyLoad.load({
						name:'sbAdminApp',
						files:[
							'scripts/controllers/groupController.js'
						]
					})
				}
			}
		})
	}]);

		

/**
 * Created by Administrator on 2016/1/13.
 */
$(document).on('pagecreate',function(event){
//	if(event.target.id==='pageStart'){
//		$(event.target).on('swipeleft',function(){
//			$.mobile.changePage('main.html',{transition:'slide'});
//		})
//	}else if (event.target.id==='pageMain'){
//		$(event.target).on('swiperight',function(){
//			$.mobile.changePage('index.html',{transition:'slide'});
//		})
//	}else if (event.target.id==='pageDetail'){
//		$(event.target).on('swiperight',function(){
//			$.mobile.changePage('main.html',{transition:'slide'});
//		})
//	}
	$('#img1').on('taphold', function () {
		console.log('触摸');
		$('#mypop').popup('open');
	});
});


angular.module('myModule',['ng','ngTouch'])
	.controller('parentCtrl',function($scope,$rootScope){
		//console.log('parentCtrl控制器对象的被创建了');
		//监听新page被加载这一事件
		//只要心page被挂到DOM树上，就要重新编译并连接其中的ng内容
		$scope.jump=function(url,trans){
			if(!trans){
				var trans='slide';
			}
			$.mobile.changePage(url,{transition:trans});
		};
		$scope.jumpWidthData=function(url,key,value){
			$rootScope[key]=value;
			$.mobile.changePage(url,{transition:'slide'});
		};
		$(document).on('pagecreate',function(event){
			var page=event.target;
			var scope=$(page).scope();
			$(page).injector().invoke(function($compile){
				$compile(page)(scope);
				scope.$digest();
			});

		})
	})
	.controller('startCtrl',function($scope){
		//console.log('startCtrl控制器对象的被创建了...')
	})
	.controller('mainCtrl',function($scope,$http){
		//console.log('mainCtrl控制器对象的被创建了...')

		$scope.listdid = [];
		$http.get('data/dish_listbypage.php').success(function (data) {
			$scope.listdid = $scope.listdid.concat(data);
		});
		$scope.loadMore = function () {
			$http.get('data/dish_listbypage.php?start='+$scope.listdid.length).success(function (data) {
				$scope.listdid = $scope.listdid.concat(data);
				$scope.more=true;
				if (data.length==0){
					$scope.more=false;
				}
			});
		};
		$scope.$watch('kw',function(){
			if( $scope.kw){
				$http.get('data/dish_listbykw.php?kw='+$scope.kw).success(function(data){
					$scope.listdid=data;
				})
			}
		})
	})
	.controller('detailCtrl',function($scope,$rootScope,$http){
		//console.log('detailCtrl控制器对象的被创建了...');
		var did = $rootScope['did'];
		//delete $rootScope.did;
		$http.get('data/dish_listbydid.php?did='+did).success(function(data){
			$scope.dish=data[0];
		})
	})
	.controller('orderCtrl',function($scope,$http,$rootScope){
		//console.log('orderCtrl控制器对象的被创建了...')
		$scope.order={};
		$scope.order.did= $rootScope['did'];
		$scope.clicked=false;
		$scope.submitOrder=function(){
			$scope.clicked = true;
			//真正的项目不会这么做
			$rootScope.phone=$scope.order.phone;
			//用post方法时要把数据改成对象{}
			//$rootScope.phone={'phone':$scope.order.phone};
			//console.log($rootScope.phone);
			//把客户端提交数据转换成 请求参数：k=v&&k=v&&k=v格式  ，只能转换对象{}格式
			var str=jQuery.param($scope.order);
			//console.log(str);
			//$http.get('data/order_add.php?'+str).success(function(data){});
			$http.post('data/order_add.php',str).success(function(data){
				//console.log(data);
				$scope.result = data[0];
				//console.log($scope.result)
			})
		}
	})
	.controller('myorderCtrl',function($scope ,$rootScope,$http){
		//console.log('myorderCtrl控制器对象的被创建了...')
		$http.get('data/order_listbyphone.php?phone='+$rootScope.phone).success(function(data){
			$scope.listphone=data;
			console.log(data);
		});


		//
		$scope.delete=function(oid){
			console.log(oid);
			$http.get('data/order_delete.php?oid='+oid).success(function(data){

				console.log(data);
				if(data.msg=='succ'){
					//$scope.listphone.splice($scope.listphone['oid'],1);
					for (var i=0;i<$scope.listphone.length;i++){
						var order=$scope.listphone[i];
						if(order.oid==oid){
							$scope.listphone.splice(i,1);
							break;
						}
					}
				}
			});
		}
	})
	.run(function($http){	//设置$http.post请求的默认请求消息头部
		$http.defaults.headers.post = {'Content-Type':'application/x-www-form-urlencoded'}
	});
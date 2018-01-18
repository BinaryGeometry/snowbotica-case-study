// window.tzSliderSystemApiUrl   = treeline_api_object.ajax_url;
// window.tzSliderUrlDomainPath  = treeline_api_object.url_domain_path;
window.snowboticaSlidesPartialsPath   = snowbotica_slides_config_object.partials_path;
// window.tzSliderImagePath      = treeline_api_object.image_path;

// Declare app level module which depends on filters, and services
var SnowboticaSlidesConfig = angular.module('SnowboticaSlidesConfig', []);

console.log('bal')

/* 
* Makes everything better
*/
SnowboticaSlidesConfig.directive('tzEditSlideshow', ['$parse', function($parse){
    return {
        replace: true,
        templateUrl: snowboticaSlidesPartialsPath+'/backend/config-template.html',
        scope: {
          data: '=slideshowValue',
          name: '@slideshowName',
          id:   '@slideshowId'
        },
        link: function(scope, element, attr) {
        	console.log('data compiled from php')
        	console.log('slideshowName', scope.name);
        	console.log('slideshowData', scope.data);
        	console.log('slideshowId', scope.id);
        },
        controller: function($scope){

        	$scope.addSlide = function(){
        		$scope.data.slides.push({"image_id": 1, "caption":"change caption" })
        	}
        	$scope.removeSlide = function(index){
        		$scope.data.slides.splice(index, 1)
        	}

        	// $scope.value = $scope.data //JSON.stringify($scope.data);        
        }
    };
}]);
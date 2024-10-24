window.snowboticaSlidesPartialsPath   = snowboticaCaseStudy_slides_config_object.partials_path;

// Declare app level module which depends on filters, and services
var SnowboticaSlidesConfig = angular.module('SnowboticaCaseStudySlidesConfig', []);

/* 
* Makes everything better
*/
SnowboticaSlidesConfig.directive('tzEditSlideshow', ['$parse', function($parse){
    return {
        replace: true,
        templateUrl: snowboticaSlidesPartialsPath+'/dashboard/config-template.html',
        scope: {
          data: '=slideshowValue',
          name: '@slideshowName',
          id:   '@slideshowId'
        },
        link: function(scope, element, attr) {
        	console.log('data compiled from php')
        	console.log('slideshowName', scope.name);
        	console.log('slideshowData', scope.data);
        	console.log('slides', scope.data.slides);
            // <tz-edit-slideshow 
            // slideshow-name="location"
            // slideshow-value='<?php  echo $location; ?>'
            // ></tz-edit-slideshow>
        	console.log('slideshowId', scope.id);
        },
        controllerAs: 'Ctrl',
        controller: function($scope){
            let vm = $scope;


            

            $scope.selectedView = 0

            $scope.logIt = function(){
                console.log('change', $scope.selectedView);
                console.log($scope.selectedView);
            }

        	$scope.addSlide = function(){
        		$scope.data.slides.push({"image_id": 1, "caption":"change caption" });
        	}
        	$scope.removeSlide = function(index){
        		$scope.data.slides.splice(index, 1);
        	}

            function returnToNow(form_item, event_name, callback_function, settings){ 
                // closure
                // this.formItem = form_item || formItem();
                // this.eventName = event_name || 'losefocus';
                // this.callbackFunction = event_name || formCallback();
                // this.formCallback = function(){
                // }
                // }
                // this.setting = settings || 'is the one we have to do'; 
                // $(form_item).on(event_name, callback_function)
            } 

            function callbackFunction()
            {
                var cf = new Object;
                cf.InputBeingWatched = $(formItem);

            }
        	// $scope.value = $scope.data //JSON.stringify($scope.data);        
        }
    };
}]);
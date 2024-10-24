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
          options: '=slideshowOptions',
          name: '@slideshowName',
          id:   '@slideshowId'
        },
        link: function(scope, element, attr) {
        // 	console.log('data compiled from php')
        // 	console.log('slideshowName', scope.name);
        // 	console.log('slideshowData', scope.data);
        // 	console.log('slides', scope.data.slides);
        // 	console.log('options', typeof scope.options);
        // 	console.log('options[0', scope.options[0]);
        // 	console.log('options[0', scope.options[0].url);
        // 	console.log('options', typeof scope.options);
        //    console.log('slideshowId', scope.id);
        },
        // controllerAs: 'Ctrl',
        controller: function($scope){
            let vm = $scope;

            $scope.imageById = (id, options) => {
                let image = options.find((iteree) => parseInt(iteree.id) === parseInt(id));
                if(undefined !== image){
                    return image.url
                }
                return ''
            }

            $scope.selectedView = 0

            $scope.toggleTracker = [];
           
            $scope.data.slides.forEach((i)=>{
                $scope.toggleTracker[i] = {open:false}
            })

            $scope.toggler = (index) => {
                console.log('index', index)
                $scope.toggleTracker.forEach(() => {
                    $scope.toggleTracker.open = false
                });

                console.log($scope.toggleTracker)

                if($scope.toggleTracker[index].open === false){
                    $scope.toggleTracker[index].open = true;
                } else {
                    $scope.toggleTracker[index].open = false;
                }
            }

            $scope.logIt = function(){
                console.log('change', $scope.selectedView);
                console.log($scope.selectedView);
            }

        	$scope.addSlide = function(){
        		$scope.data.slides.push({"image_id": 18, "caption":"change caption" });
                $scope.toggleTracker.push({open:false})
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
                slideshow-options
            }
        	// $scope.value = $scope.data //JSON.stringify($scope.data);        
        }
    };
}]);
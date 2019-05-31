//TODO:Навести порядок в этом файле и объединить с handler.js

var apiParams;


BX24.init(function () {

	apiParams =  BX24.getAuth();

	//console.log(apiParams);






	//VUE
	var app = new Vue({

		el: "#handler-root",
		data: {
			showingModal:false,
			showingeditModal: false,
			showingdeleteModal: false,
			errorMessage : "",
			successMessage : "",
			points: [],
			newPoint: {name: "", comment: "", cords: ""},
			clickedPoint: {},
			apiParams: {},
			cordsVal: "",




		},
		mounted: function () {
			console.log("Hi KK1");
			this.apiParams = apiParams;
			console.log(this.apiParams);





			this.getAllPoints();
		},
		methods: {
			getAllPoints: function(){
				console.log('xxx');
				console.log(this.apiParams);
				request = this.addParams({action:'read'});
				axios.get("../api.php", {
					params: request
				})
					.then(response => (this.points = response.data.points)).then(function () {
						//sconsole.log(app.points);
					app.createDealersOnMap();
					app.resizeFrame();
				});


			},
			createDealersOnMap: function (){

				if(typeof myMap !== 'undefined') {
					myMap.geoObjects.removeAll();

					//$('input[type=radio][name=coord]').removeAttr('checked');
					$('.the-point').each(function () {
						cords = $(this).find('.cords').text();
						name_text = $(this).find('.name').text();
						user_text = $(this).find('.user').text();
						comment_text = $(this).find('.comment').text();
						console.log(cords);
						if (cords.length > 0) {
							var cord;
							cord = cords.split(',');
							var myPlace = new ymaps.Placemark(
								[cord[0], cord[1]],
								{},
								{
									balloonPanelMaxMapArea: 0,
									preset: 'islands#darkOrangeDotIcon',
									openEmptyBalloon: true
								}
							);
							var newContent = "";
							newContent = '<h4>'+ name_text +'</h4>';
							newContent += '<p style="color: #c0c0c0; font-size: 11px;">добавил:'+ user_text +'</p>';
							newContent += '<p>'+ comment_text +'</p>';


							myPlace.events.add('balloonopen', function (e) {

								myPlace.properties.set('balloonContent', newContent);
							});

							myMap.geoObjects.add(myPlace);
						}


					});
				}
			},

			addParams: function(value){
				function extend(obj, src) {
					var obj2 = obj;
					for (var key in src) {
						if (src.hasOwnProperty(key)) obj2[key] = src[key];
					}
					return obj2;
				}
				var c = extend(this.apiParams, value);
				return c;




			},
			savePoint:function(){

				var formData = app.toFormData(app.newPoint);
				formData.set("action","create");

				axios.post("../api.php", formData)
					.then(function(response){
						console.log(response);
						app.newPoint = {name: "", comment: "", cords: ""};
						if (response.data.error) {
							app.errorMessage = response.data.message;
						}else{
							app.successMessage = response.data.message;
							app.getAllPoints();
						}
					});
			},
			updatePoint:function(){

				var formData = app.toFormData(app.clickedPoint);
				formData.set("action","update");
				axios.post("api.php", formData)
					.then(function(response){
						console.log(response);
						app.clickedPoint = {};
						if (response.data.error) {
							app.errorMessage = response.data.message;
						}else{
							app.successMessage = response.data.message;
							app.getAllPoints();
						}
					});
			},
			deletePoint:function(){

				var formData = app.toFormData(app.clickedPoint);
				formData.set("action","delete");
				axios.post("api.php", formData)
					.then(function(response){
						console.log(response);
						app.clickedPoint = {};
						if (response.data.error) {
							app.errorMessage = response.data.message;
						}else{
							app.successMessage = response.data.message;
							app.getAllPoints();
						}
					});
			},
			selectPoint(point){
				app.clickedPoint = point;
			},

			toFormData: function(odbj){
				var form_data = new FormData();
				for ( var key in obj ) {
					form_data.append(key, obj[key]);
				}
				for(var key in this.apiParams){
					form_data.append(key, this.apiParams[key]);
				}
				return form_data;
			},
			clearMessage: function(){
				app.errorMessage = "";
				app.successMessage = "";
			},
			resizeFrame: function () {



				var currentSize = BX24.getScrollSize();
				minHeight = currentSize.scrollHeight;


				BX24.resizeWindow(this.FrameWidth, 10000);


			}

		}
	});


});
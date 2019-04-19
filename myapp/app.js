var apiParams;


BX24.init(function () {

	apiParams =  BX24.getAuth();

	//console.log(apiParams);






//VUE
var app = new Vue({

	el: "#root",
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
			axios.get("api.php", {
				params: request
			})
				.then(response => (this.points = response.data.points)).then(function () {
				createDealersOnMap();
				app.resizeFrame();
			});


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

			axios.post("api.php", formData)
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

			toFormData: function(obj){
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
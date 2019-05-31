
apiParams = {};
ymaps.ready(function(){
	// Указывается идентификатор HTML-элемента.
	myMap = new ymaps.Map("handler_map", {
		center: [55.76, 37.64],
		zoom: 10
	});
	// Ссылка на элемент.


	myMap2 = new ymaps.Map("add_modal_map", {
		center: [55.76, 37.64],
		zoom: 10
	});

	$('#addModal').on('show.bs.modal', function (event) {

		var placemark;
		var cordsInput = "input[name='cords']";



		function SetCoord(cord,selectMap){


			if (placemark) {
				selectMap.geoObjects.remove(placemark);
			}


			if( typeof cord === 'string' ) {
				cord = cord.split(",");
			}




			placemark = new ymaps.Placemark(cord,{ }, {
				// Задаем стиль метки (метка в виде круга).
				preset: "islands#dotCircleIcon",
				// Задаем цвет метки (в формате RGB).
				iconColor: '#2381d6',
				draggable: true
			});
			selectMap.geoObjects.add(placemark);

			placemark.events.add('dragend', function (e) {
				var cords = placemark.geometry.getCoordinates();
				console.log(cords);
				console.log(app.data.cordsVal);
				app.data.cordsVal = cords;
			});


		}
		myMap2.events.add('click', function (e) {

			var coords = e.get('coords');
			//alert(coords);
			// Вот тут заполняйте нужный вам input в форме координатами
			// Или отправляйте AJAX, как вам больше нравится
			// У Яндекса сначала долгота --> coords[0].toPrecision(4)
			// Потом широта  --> coords[1].toPrecision(4)
			// Почти у всех остальных Картографических сервисов наоборот.
			// Точности по опыту хватает до 4 знаков
			$(cordsInput).val(coords);
			//alert($("input[name='REGISTER[ORG_MAP][0][VALUE]']").val());
			SetCoord(coords,myMap2);



		});




	});

	$(document).ready(function () {
		$('#save-btn').click(function () {


				var $form = $("#addForm");

			BX24.init(function () {
				apiParams =  BX24.getAuth();
				form_data = $form.serialize() + '&' + $.param(apiParams);
				console.log(form_data);
				$.ajax({
					type: 'POST',
					url: $form.attr('action'),
					data: form_data,
					success: function(response) { //Данные отправлены успешно
						console.log(response);
					}
				});
			});

		});
	});
});
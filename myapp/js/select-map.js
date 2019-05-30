//#select-map
//input.cordscreate

function showSelectMap () {
	console.log('ok');

	ymaps.ready(function() {

		var selectMap = "#selectmap";
		var cordsInput = "input.cordscreate";


		var coordinate = "55.76,37.64";

		//Загружаем карту
		//var coordinate = "55.76,37.64";
		var myMap2 = new ymaps.Map("select_map", {
			center: [55.76,37.64],
			//center: coordinate.split(','),
			zoom: 12,
			controls: ['zoomControl', 'rulerControl', 'fullscreenControl']
		});

		var placemark;


		function SetCoord(cord){

			if (placemark) {
				myMap2.geoObjects.remove(placemark);
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
			myMap2.geoObjects.add(placemark);

			placemark.events.add('dragend', function (e) {
				var cords = placemark.geometry.getCoordinates();
				// alert(cords)
				$(cordsInput).val(cords);
			});

			myMap2.setCenter(cord);
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
			SetCoord(coords);



		});



	});
}


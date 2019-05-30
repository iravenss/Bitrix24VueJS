//создаем точки по дилерам
createDealersOnMap = function (){

	if(typeof myMap !== 'undefined') {
		myMap.geoObjects.removeAll();

		//$('input[type=radio][name=coord]').removeAttr('checked');
		$('tr.the-point').each(function () {
			cords = $(this).find('td.cords').text();
			name_text = $(this).find('td.name').text();
			user_text = $(this).find('td.user').text();
			comment_text = $(this).find('td.comment').text();
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
}


ymaps.ready(function(){
	// Указывается идентификатор HTML-элемента.
	myMap = new ymaps.Map("first_map", {
		center: [55.76, 37.64],
		zoom: 10
	});
	// Ссылка на элемент.



	createDealersOnMap();






});







function showSelectMap () {

	if (typeof selectMap !== 'undefined') {
		selectMap.destroy();
		selectMap = null;

	}
		selectMap = new ymaps.Map("select_map", {
			center: [55.76, 37.64],
			//center: coordinate.split(','),
			zoom: 12,

		});





	var placemark;
	var cordsInput = "input.cordscreate";



	function SetCoord(cord){

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
			// alert(cords)
		//	$(cordsInput).val(cords);
			console.log(cords);
			console.log(app.data.cordsVal);
			app.data.cordsVal = cords;
		});

		selectMap.setCenter(cord);
	}


	selectMap.events.add('click', function (e) {

		var coords = e.get('coords');
		//alert(coords);
		// Вот тут заполняйте нужный вам input в форме координатами
		// Или отправляйте AJAX, как вам больше нравится
		// У Яндекса сначала долгота --> coords[0].toPrecision(4)
		// Потом широта  --> coords[1].toPrecision(4)
		// Почти у всех остальных Картографических сервисов наоборот.
		// Точности по опыту хватает до 4 знаков
		$(cordsInput).val(coords);
		$(cordsInput)[0].dispatchEvent(new Event('input'));

		// console.log(coords);
		// cordsVal = coords;
		// console.log(app.data.cordsVal);

		//alert($("input[name='REGISTER[ORG_MAP][0][VALUE]']").val());
		SetCoord(coords);



	});



}
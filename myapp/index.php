<?
//cho "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<br>";


require_once("api.php");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>VueJS CRUD project By KK</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
    <script src="//api.bitrix24.com/api/v1/"></script>
    <script
            src="https://code.jquery.com/jquery-3.4.0.slim.min.js"
            integrity="sha256-ZaXnYkHGqIhqTbJ6MB4l9Frs/r7U4jlx7ir8PJYBqbI="
            crossorigin="anonymous"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=fca40238-7aa6-4bb5-b055-7a4d62509696&lang=ru_RU"
            type="text/javascript">
    </script>
  
</head>
<body>

<div id="first_map" style="width:100%; height:400px"></div>
<script type="text/javascript">

</script>

	<div id="root">

		<div class="">
			<div class="crud_header">
				<h1 class="left">VueJS CRUD WITH PHP AND MySQL</h1>
				<button class="right addnew" @click="showingModal = true;">Add New</button>
				<div class="fix"></div>
			</div>
			
			<hr>
			<p class="errorMessage" v-if="errorMessage">{{errorMessage}}</p>
			<p class="successMessage" v-if="successMessage">{{successMessage}}</p>

			<table class="list">
				<tr>
					<th>ID</th>
					<th>Название</th>
					<th>Комментарий</th>
					<th>-</th>
					<th>-</th>
					<th>Удалить</th>
				</tr>
				<tr v-for="point in points" class="the-point">
					<td>{{point.ID}}</td>
					<td>{{point.NAME}}</td>
					<td>{{point.COMMENT}}</td>
					<td class="cords">{{point.CORDS}}</td>
					<td>
						<!--<button @click="showingeditModal = true; selectUser(user)">Edit</button>-->
					</td>
					<td><button @click="showingdeleteModal = true; selectPoint(point)" >Удалить</button></td>
				</tr>
			</table>
			<div class="fix"></div>
			<div class="modal col-md-6" id="addmodal" v-if="showingModal">
				<div class="modalheading">
					<p class="left">Добавить новую точку</p>
					<p class="right close" @click="showingModal = false;">x</p>
					<div class="fix"></div>
				</div>
				<div class="modalbody">
					<div class="modalcontent">
                       
                        <div id="select_map" style="width: 300px; height: 200px;background: #ccc;"></div>
                        <a href="#" onclick="showSelectMap();">Выбрать на карте</a>
						<table class="form">
							<tr>
								<th>Название</th>
								<th>:</th>
								<td><input type="text" placeholder="" v-model="newPoint.name"></td>
							</tr>
							<tr>
								<th>Координата</th>
								<th>:</th>
								<td><input class="cordscreate" type="text" value="" placeholder="" v-model="newPoint.cords"></td>
							</tr>
							<tr>
								<th>Комментарий</th>
								<th>:</th>
								<td><input type="text" placeholder="" v-model="newPoint.comment"></td>
							</tr>
						</table>
						<div class="margin"></div>
						<button class="center"  @click="showingModal = false; savePoint();" >Добавить точку</button>
					</div>
				</div>
			</div>
		<div class="modal col-md-6" id="editmodal" v-if="showingeditModal">
				<div class="modalheading">
					<p class="left">Edit point</p>
					<p class="right close" @click="showingeditModal = false;">x</p>
					<div class="fix"></div>
				</div>
				<div class="modalbody">
					<div class="modalcontent">
						<table class="form">
							<tr>
								<th>Название</th>
								<th>:</th>
								<td><input type="text" placeholder="" v-model="clickedPoint.name"></td>
							</tr>
							<tr>
								<th>cords</th>
								<th>:</th>
								<td><input type="email" placeholder="s" v-model="clickedPoint.cords"></td>
							</tr>
							<tr>
								<th>Коммент</th>
								<th>:</th>
								<td><input type="text" placeholder=""  v-model="clickedPoint.comment"></td>
							</tr>
						</table>
						<div class="margin"></div>
						<button class="center"  @click="showingeditModal = false; updatePoint()">Update Point</button>
					</div>
				</div>
			</div>
			<div class="modal col-md-6" id="deletemodal" v-if="showingdeleteModal">
				<div class="modalheading">
					<p class="left">Удаалить точку</p>
					<p class="right close" @click="showingdeleteModal = false;">x</p>
					<div class="fix"></div>
				</div>
				<div class="modalbody">
					<div class="modalcontent">
						
						<div class="margin"></div>
						<h3 class="center">Are you sure to Delete?</h3>
						<div class="margin"></div>
						<h4 class="center">{{clickedPoint.name}}</h4>
						<div class="margin"></div>
						<div class="col-md-6 center">
							<button class="left" @click="showingdeleteModal = false; deletePoint()">YES</button>
							<button class="right" @click="showingdeleteModal = false;">NO</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>

    <script>

		console.log('index');
		var apiParams;
			BX24.init(function () {
				
				apiParams =  BX24.getAuth();

				//console.log(apiParams);

			
   
			});
		

    </script>

<script type="text/javascript" src="app.js"></script>
<script type="text/javascript" src="maps.js"></script>


	

</body>
</html>
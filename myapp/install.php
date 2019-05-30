<?
//Установщик.
require_once __DIR__ . '/vendor/autoload.php';
require_once("api.php");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Установка приложения с картами</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
    <script src="//api.bitrix24.com/api/v1/"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<main role="main" class="container">
    <h1 class="mt-5">Установка приложения</h1>
    <p class="lead">К каким сущностям CRM добавить вкладку с картами</p>
    <div class="handler-checkboxes mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="leads" name="leads">
            <label class="form-check-label" for="leads">Лиды</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="deals" name="deals">
            <label class="form-check-label" for="deals">Сделки</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="companies" name="companies">
            <label class="form-check-label" for="companies">Компании</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="contacts" name="contacts">
            <label class="form-check-label" for="contacts">Контакты</label>
        </div>
    </div>
    <button id="save-btn" class="btn btn-primary">Сохранить и установить</button>
</main>
<script>
	$(document).ready(function () {
		BX24.init(function () {
			authParams = BX24.getAuth();
			$('#save-btn').click(function () {
				params = authParams;
				params.install = 'Y';
				params.handlers = {};
				$('.handler-checkboxes input[type=checkbox]').each(function () {
					if ($(this).is(':checked')) {
						params.handlers[$(this).prop('name')] = 'Y';
					}
				});
				$.post(
					'api.php',
					params,
					function (data) {
						console.log(data);
						if (data.error === true) {
							alert('К сожалению, произошла ошибка. Попробуйте перезапустить приложение');
						}
						else {
							BX24.installFinish();
						}
					}
				);
			});
		});
	});
</script>
</body>
</html>
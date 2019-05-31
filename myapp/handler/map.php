<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once("../api.php");
// TODO:Написать обработчик
	?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"  crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script type="text/javascript" src="//api.bitrix24.com/api/v1/"></script>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=<?=MAPS_API_KEY?>&lang=ru_RU"
                type="text/javascript">
        </script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
        <script type="text/javascript" src="../js/handler.js"></script>
        <script type="text/javascript" src="../js/v-handler.js"></script>
    </head>
<body>
<div>

    
        <div id="handler_map" style="width:100%; height:400px"></div>


    <div id="handler-root" style="">
        <div v-for="point in points" class="the-point" style="">
            
                <div>{{point.ID}}</div>
                <div class="name">{{point.NAME}}</div>
                <div class="comment">{{point.COMMENT}}</div>
                <div class="user">{{point.CONTACT_ID }}</div>
                <div class="user">{{point.USER}}</div>
                <div class="cords">{{point.CORDS}}</div>
                <div>
                    <!--<button @click="showingeditModal = true; selectUser(user)">Edit</button>-->
                </div>
            
        </div>
        
        
    </div>
        <?
		//[PLACEMENT] => CRM_CONTACT_LIST_MENU
		//[PLACEMENT_OPTIONS] => {"ID":"2"}
        $options = json_decode($_REQUEST['PLACEMENT_OPTIONS']);
		//print_r($options); echo $options->ID;
        $data = $application->getHandlerData($_REQUEST['PLACEMENT'],$options->ID);
        
        ?>
    
  
        <h1><?=$data['H1']?></h1>
    <div>
        <button class="btn btn-primary"  data-toggle="modal" data-target="#addModal">Добавить</button>
        
    </div>
    <?// echo "<pre>"; print_r($_REQUEST); echo "</pre>";?>
		

</div>


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Добавление новой точки на карту</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="addForm" action="../api.php">
                    <div id="add_modal_map" style="height: 300px; width: 100%;"></div>
                    <input type="hidden" name="comment">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="cords">
                    <input type="hidden" name="PLACEMENT" value="<?=$_REQUEST['PLACEMENT'];?>">
                    <input type="hidden" name="ID" value="<?=$options->ID?>">
					<?/* TODO:Сделать типы точек
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Тип точки</label>
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                        <option value="1" selected>Основное расположение</option>
                       
                        <option value="2">Место встречи</option>
                        <option value="3">Пункт выдачи</option>
                    </select> */?>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Комментарий</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div>  <button id="save-btn" type="button" class="btn btn-primary">Сохранить</button></div>
                </form>
            </div>
            
        </div>
    </div>
</div>
</body>
</html>

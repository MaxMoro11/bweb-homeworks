<?
//подключаем пролог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//устанавливаем заголовок страницы
$APPLICATION->SetTitle("AJAX");
//Метод для подключения библиотеки. Метод подключает ядро, стили и языковые сообщения библиотеки.
   CJSCore::Init(array('ajax'));
//Создает переменную $sidAjax со значением testAjax
   $sidAjax = 'testAjax';
/*
Условие проверяет пришел ли в запросе ajax_form не равен ли он NULL и равен ли он $sidAjax
Если да, то очищаем буфер
И преобразуем PHP массив в js
 */
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
   $GLOBALS['APPLICATION']->RestartBuffer();
   echo CUtil::PhpToJSObject(array(
            'RESULT' => 'HELLO',
            'ERROR' => ''
   ));
   die();
}

?>
//Создаем блок для загрузки
<div class="group">
   <div id="block"></div >
   <div id="process">wait ... </div >
</div>
<script>
//включить отладку
   window.BXDEBUG = true;
//Определяем функцию DEMOLoad, которая скрывает блок  и показывает показать wait ...
function DEMOLoad(){
   BX.hide(BX("block"));
   BX.show(BX("process"));
// Делаем запрос и передаем полученный результат в фукцию DEMOResponse
   BX.ajax.loadJSON(
      '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
      DEMOResponse
   );
}
//Определяем функцию которая выводит в консоль значение и стек.
function DEMOResponse (data){
   BX.debug('AJAX-DEMOResponse ', data);
// В div id="block" добавим data.RESULT . Покажем этот облок и скроем  wait ...
   BX("block").innerHTML = data.RESULT;
   BX.show(BX("block"));
   BX.hide(BX("process"));
//сообщаем о нашем событии
   BX.onCustomEvent(
      BX(BX("block")),
      'DEMOUpdate'
   );
}
// Когда документ загружен скрыть блоки block и process
BX.ready(function(){
   /*
   BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
      window.location.href = window.location.href;
   });
   */
   BX.hide(BX("block"));
   BX.hide(BX("process"));
// Добавить в body событие click для класса css_ajax. Который click Me
    BX.bindDelegate(
      document.body, 'click', {className: 'css_ajax' },
//Функция обработчика события вызывающая DEMOLoad
      function(e){
         if(!e)
            e = window.event;
         DEMOLoad();
         return BX.PreventDefault(e);
      }
   );
   
});

</script>
<div class="css_ajax">click Me</div>
<?
//подключаем эпилог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

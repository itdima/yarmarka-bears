<?php
use yii\widgets\Pjax;
use yii\web\JsExpression;
//use timurmelnikov\widgets\ShowLoading;

$this->title = \Yii::t('app', 'Сообщения');
$this->params['breadcrumbs'][] = $this->title;
//new JsExpression("var selectuser=0;");
$this->registerJs(new JsExpression("
var selecteduser=0;
function getUser(){
    return selecteduser;
};
function setUser(value){
   selecteduser=value;
};
"));
?>

<div class="contacts">
    <div class="row">
        <div class="col-sm-4">
            <div>
                <?php foreach ($users as $user) {
                    //$text = \yii\helpers\Html::img($user->getImage()->getUrl('50x50'), ['alt' => 'Photo', 'class' => 'img-circle']).'123';
                    echo \yii\bootstrap\Html::a(
                        "<div class='message well'>" .
                        \yii\helpers\Html::img($user->getImage()->getUrl('50x50'), ['alt' => 'Photo', 'class' => 'img-circle']) .
                        $user->fname .
                        "</div>",
                        ['cabinet/message/index'],
                        [
                            'data-pjax' => '1',
                            'title' => $user->id_user,
                        ]); ?>

                <?php }; ?>
            </div>
        </div>


        <div class="col-sm-8">
            <?php  Pjax::begin([
                'id' => 'pjaxid', //контеинер
                'clientOptions' => ['method' => 'POST', 'data' => ['user' => new JsExpression("function(){return getUser()}")]],
                //  'enablePushState' => true, //обновлять url
                'timeout' => 10000, //время выполнения запроса
                'linkSelector' => 'a[data-pjax]', //обрабатывать через pjax только отдельные ссылки
            ]);


            Pjax::end(); ?>
        </div>
    </div>
</div>


<?php
//echo ShowLoading::widget(['loadingType' => 1]);
$this->registerJs(new JsExpression("
    //при нажатии на ссылку заполняем переменную selecteduser
$('a[data-pjax]').click(function(){setUser(this.title);})

    //loading для pjax
$(document).on('pjax:send', function() {
  $('#pjaxid').showLoading();
})
$(document).on('pjax:complete', function() {
   $('#pjaxid').hideLoading();
})

"));

?>

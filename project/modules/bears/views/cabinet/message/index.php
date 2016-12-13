<?php
use yii\widgets\Pjax;
use yii\web\JsExpression;
use \app\modules\bears\models\Message;


$this->title = \Yii::t('app', 'Сообщения');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(new JsExpression("
var activeConversationUser = 0;
var showLoading=true;

//проверка выбран ли собеседник
function setDisabled(){
    if(activeConversationUser==0){
        $('[setdisabled]').attr('disabled','disabled');
    } else {
        $('[setdisabled]').attr('disabled',null);
    }
}

//Обновить количество новых сообщений
function refreshCountMessages(){
    $.ajax({
        url: '" . \yii\helpers\Url::toRoute(['cabinet/message/refresh-count']) . "',
        type: 'POST',
        data: {user: activeConversationUser},
        beforeSend: function () {},
        success: function (result) {
               $('span[title='+activeConversationUser+']').text(result.userMessageCount);
               $('span[title=\'menu_message_count\']').text(result.totalMessageCount);
               hideEmptyBadges();
        },
  });
}

//Обновляем окно чата с использованием activeConversationUser
function refreshConversation(isShowLoading){
    showLoading = isShowLoading;
    if (activeConversationUser !== 0){
        $('a[title='+activeConversationUser+']').trigger('click');
    }
    showLoading=true;
}

//Скрываем span с нулевыми значениями
function hideEmptyBadges(){
    $('span[class~=\'badge\']').each(function() {
        if (parseInt($(this).text())==0){
            $(this).addClass('hidden');
        } else {
            $(this).removeClass('hidden');
        }
    });
}



"));

?>

<div class="contacts">
    <div class="row">
        <div class="col-sm-4">
            <div class="scrolluserdiv">
                <?php
                if (!empty($users)) {
                    foreach ($users as $user) {
                        //$text = \yii\helpers\Html::img($user->getImage()->getUrl('50x50'), ['alt' => 'Photo', 'class' => 'img-circle']).'123';
                        echo \yii\bootstrap\Html::a(
                            "<div class='userwell well'>" .
                            \yii\helpers\Html::img($user->getImage()->getUrl('50x50'), ['alt' => 'Photo', 'class' => 'img-circle']) . "&nbsp" .
                            $user->fname .
                            $user->sname .
                            "&nbsp" . "<span title='$user->id_user' class='badge hidden'>" .
                            Message::getNewMessageCount($user->id_user).
                            "</span>".
                            "</div>",
                            ['cabinet/message/index'],
                            [
                                'data-pjax' => '1',
                                'title' => $user->id_user,
                            ]);

                    };
                } else {
                    echo \Yii::t('app','У вас нет бесед с пользователями.');
                };
                ?>
            </div>
        </div>


        <div class="col-sm-8">
            <div class="panel panel-default mypanel">
                <div class="panel-body">
                    <?php Pjax::begin([
                        'id' => 'pjaxid', //контеинер
                        'clientOptions' => ['method' => 'POST', 'data' => ['user' => new JsExpression("function(){return activeConversationUser}")]],
                        //'enablePushState' => true, //обновлять url
                        'timeout' => 10000, //время выполнения запроса
                        'linkSelector' => 'a[data-pjax]', //обрабатывать через pjax только отдельные ссылки
                    ]);
                    Pjax::end(); ?>
                </div>
            </div>


            <div class="input-group" >
                <input id="send-message-input" setdisabled  type="text" class="form-control"
                       placeholder="<?= \Yii::t('app', 'Сообщение') ?>">
                <span class="input-group-btn">
                    <button id="send-message-button" setdisabled class="btn btn-default"
                            type="button"><?= \Yii::t('app', 'Отправить') ?><span id="load"></span></button>
                </span>
            </div>


        </div>
    </div>
</div>


<?php

$this->registerJs(new JsExpression("
    //---при нажатии на ссылку заполняем переменную
$('a[data-pjax]').click(function(){
    activeConversationUser = $(this).attr('title');
});


    //---loading для pjax
$(document).on('pjax:send', function() {
    if (showLoading){
        $('#pjaxid').showLoading();
    }
})
$(document).on('pjax:complete', function() {
    if (showLoading){
        $('#pjaxid').hideLoading();
    } else {
        showLoading=true;
    };
    refreshCountMessages();
    setDisabled();

})

    //---Отправка сообщения
$('#send-message-button').on('click', function (e) {
    var message = $('#send-message-input').val();
    e.preventDefault();
  $.ajax({
   url: '" . \yii\helpers\Url::toRoute(['cabinet/message/send']) . "',
   type: 'POST',
   data: {text: message, receiver: activeConversationUser},
   beforeSend: function () {
        $('#send-message-input').showLoading();
    },
   success: function (result) {
        $('#send-message-input').hideLoading();
        $('#send-message-input').val('');
        refreshConversation(false);
    },
  });
});

refreshConversation(false);
setDisabled();
hideEmptyBadges();
"));

?>


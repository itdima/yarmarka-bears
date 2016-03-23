<?php
namespace app\modules\bears\controllers;

use Yii;


/**
 * Common bears controller
 */
class CommonController extends \app\controllers\CommonController
{
    /*
     * Вывод всплывающих сообщений
     *
     * @param string $text
     * @param string $type
     * @param string $title
     * @return mixed
     */
    public function setFlash($text, $type = 'success', $icon = 'glyphicon glyphicon-ok-sign')
    {
        Yii::$app->getSession()->setFlash('common', [
            'type' => $type,
            'title' => $text,
            'icon' => $icon,
        ]);
    }
}
<?php

namespace app\modules\bears\models;


class BlogSearch extends commonModel
{

    public $title;
    public $article;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['date_from','date_to'], 'date', 'format' => 'dd.mm.yyyy'],
            [['article'], 'safe'],
        ];
    }

    public function search($postParams=null){
        $query = Blog::find();
        $query->andWhere('user = :user', [':user' => \Yii::$app->user->id]);
        if (!empty($postParams)){
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['like', 'article', $this->article]);
            if ($this->date_from) {
                $query->andWhere('created_at >= :date_from', [':date_from' => \Yii::$app->formatter->asTimestamp($this->date_from)]);
            }
            if ($this->date_to) {
                $query->andWhere('created_at <= :date_to', [':date_to' => (\Yii::$app->formatter->asTimestamp($this->date_to) + 86399)]);
            }
            //$query->andFilterWhere(['between', 'created_at', \Yii::$app->formatter->asTimestamp($this->date_from), \Yii::$app->formatter->asTimestamp($this->date_to)]);
        }
        return $query;

    }

}
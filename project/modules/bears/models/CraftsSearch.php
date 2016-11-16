<?php

namespace app\modules\bears\models;


class CraftsSearch extends commonModel
{

    public $priceMin;
    public $priceMax;
    public $title;
    public $description;
    public $tag;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['user'], 'integer'],
            [['priceMin','priceMax'], 'number'],
      //      [['currency'], 'string', 'max' => 3],
            [['title','tag'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
          //  [['tags'],'safe'],
        ];
    }

    public function search($postParams=null){
        $query = Crafts::find();
        $query->andWhere('user = :user', [':user' => \Yii::$app->user->id]);
        if (!empty($postParams)){
            $query->andWhere('user = :user', [':user' => \Yii::$app->user->id]);
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['like', 'description', $this->description]);
            if (!empty($this->priceMin)){
                $query->andWhere('price >= :priceMin',[':priceMin'=>$this->priceMin]);
            }
            if (!empty($this->priceMax)){
                $query->andWhere('price <= :priceMax',[':priceMax'=>$this->priceMax]);
            }
        }
        return $query;

    }

}
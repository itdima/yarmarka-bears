<?php

namespace app\modules\bears\models;


class Catalog extends commonModel
{

    public $priceMin;
    public $priceMax;
    public $title;
    public $description;
    public $tag;
    public $type;
    public $date;
    public $fName;
    public $sName;
    public $currency;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priceMin','priceMax','type'], 'number'],
            [['title','tag','fName','sName', 'date'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['description'], 'string', 'max' => 1024],
        ];
    }

    public function search($postParams=null){
        $query = Crafts::find();
        //$query->andWhere('user = :user', [':user' => \Yii::$app->user->id]);
        if (!empty($postParams)){
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['like', 'description', $this->description]);
            if (!empty($this->priceMin)){
                $query->andWhere('price >= :priceMin',[':priceMin'=>$this->priceMin]);
            }
            if (!empty($this->priceMax)){
                $query->andWhere('price <= :priceMax',[':priceMax'=>$this->priceMax]);
            }
            if (!empty($this->type)){
                $query->andWhere('type = :type',[':type'=>$this->type]);
            }
            //в§уш
            $query->joinWith([
                'tagsRel'=> function ($q) {
                    $q->andFilterWhere(['like', 'tagname', $this->tag]);
                }
            ]);
        }
        return $query;

    }

}
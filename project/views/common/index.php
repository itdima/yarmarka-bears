<?php
use \yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-4">
        <a href="<?=Url::to('bears/')?>">
            <div class="data-block-dark thumbnail text-center">
                <span>Teddy Bears and other friends</span>
                <img src="<?= Yii::getAlias('@web') . '/images/bears/bears2.jpg' ?>" alt="bears_foto">
                <span>Welcome!</span>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <div class="data-block-light thumbnail text-center">
            <span>Scrapbooking</span>
            <img src="<?= Yii::getAlias('@web') . '/images/scrap/scrap.jpg' ?>" alt="bears_foto">
            <span>Coming soon...</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="data-block-dark thumbnail text-center">
            <span>Beading</span>
            <img src="<?= Yii::getAlias('@web') . '/images/bead/bead.jpg' ?>" alt="bears_foto">
            <span>Coming soon...</span>
        </div>
    </div>

</div>


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Apple $model */
/** @var ActiveForm $form */
?>
<div class="site-apple">
    <h2>Добавить яблоко</h2>

    <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'color') ?>
        
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-apple -->

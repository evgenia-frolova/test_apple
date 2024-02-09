<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Apple;

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
    
    <?php if ($appleArray) { ?>
        <div class="row">
            <?php foreach ($appleArray as $item) {?>
                <div class="col-lg-4">
                    <h3>Яблоко 
                        <?php if ($item->color == 'green') {
                            echo Apple::COLOR_GREEN;
                        } else {
                            echo Apple::COLOR_RED;
                        }?>
                    </h3>
                    <div>
                        <?php if ($item->status == Apple::STATUS_ON_TREE) { ?>
                            <table>
                                <tr>
                                    <td>
                                        <b>Статус</b>: <?php echo Apple::STATUS_ON_TREE_TEXT; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?= Html::a('Упасть', ['site/fall', 'id' => $item->id], ['class' => 'profile-link']) ?>

                                    </td>
                                </tr>
                            </table>   
                            
                        <?php } elseif ($item->status == Apple::STATUS_FALL) { ?>
                            <table>
                                <tr>
                                    <td>
                                        <b>Статус</b>: <?php echo Apple::STATUS_FALL_TEXT; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?= Html::beginForm(['site/eat'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                            <?= Html::input('text', 'balance', $item->balance) ?>
                                            <?= Html::input('hidden', 'id', $item->id) ?>
                                            <?php echo Html::submitButton('Съесть(%)', ['class' => 'btn btn-primary']); ?>
                                        <?= Html::endForm() ?>
                                    </td>
                                </tr>
                            </table> 
                            
                        <?php } else { ?>
                            <table>
                                <tr>
                                    <td>
                                        <b>Статус</b>: <?php echo Apple::STATUS_ROT_TEXT; ?>
                                    </td>
                                </tr>
                            </table> 
                        <?php } ?>
                    </div>
                        
                </div>    
            <?php } ?>
        </div>    
    <?php } ?>

</div><!-- site-apple -->

<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $status
 * @property int $balance
 * @property string $created_at
 * @property string|null $fall_at
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATUS_ON_TREE = 1; //на дереве
    const STATUS_FALL = 2; //упало
    const STATUS_ROT= 3; //сгнило
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'balance'], 'integer'],
            [['created_at'], 'required'],
            [['created_at', 'fall_at'], 'safe'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'status' => 'Статус',
            'balance' => 'Остаток в процентах',
            'created_at' => 'Дата появления',
            'fall_at' => 'Дата падения',
        ];
    }
    
    /**
     * падение яблока
     * @return bool
     */
    public function fall()
    {
        $this->fall_at = new Expression('NOW()');
        $this->status = self::STATUS_FALL;
        if (!$this->save()) {
            return false;
        }
        
        return true;
    }
    
    /*
     * сколько съедено от яблока в процентах
     */
    public function eat(int $percent)
    {
        //яблоко можно съесть только если оно упало
        if (self::STATUS_FALL){
            $this->balance = $this->balance - $percent;
            
            //удалить, если съедено полностью
            if($this->balance == 0 && $this->delete()) {
                return 'Яблоко съедено полностью';
            }
            
            if(!$this->save())
                return false;
        } elseif (self::STATUS_ON_TREE){
            return 'Яблоко на дереве съесть нельзя';
        } else {
            return 'Яблоко сгнило. Съесть нельзя';
        }
            
        return true;
    }        
}

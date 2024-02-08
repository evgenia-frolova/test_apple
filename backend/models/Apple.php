<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;

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
class Apple extends ActiveRecord
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
        //яблоко можно съесть только если оно упало и не сгнило
        if (self::STATUS_FALL){
            //Здесь проверяем сгнило ли яблоко. Если сгнило,
            //то поставить статус 3 и вернуть сообщение, что яблоко сгнило и есть его нельзя.
            //яблоко сгнило если лежит >= 5 часов. Нужно сравнить текущее время со временем падения яблока.
            $nowTime = date('Y-m-d H:i:s');
            $fallTime = $this->fall_at; 
            $interval = (int)((strtotime($nowTime) - strtotime($this->fall_at))/3600);
            
            if ($interval >= 5) {
                $this->status = self::STATUS_ROT;
                if ($this->save) {
                    return 'Яблоко сгнило. Съесть нельзя';
                }
            }
            
            $this->balance = $this->balance - $percent;
            
            //удалить, если съедено полностью
            if($this->balance <= 0 && $this->delete()) {
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

<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property integer $date
 * @property string $status
 */
class Notification extends \yii\db\ActiveRecord
{

    const STATUS_UNREAD = 1;
    const STATUS_READ = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'user_id' => 'Получатель',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'date' => 'Дата',
            'status' => 'Статус',
        ];
    }

    public function read() {
        $this->status = Notification::STATUS_READ;
        $this->save();
    }

}

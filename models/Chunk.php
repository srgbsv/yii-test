<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "chunk".
 *
 * @property string $name
 * @property string $value
 */
class Chunk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chunk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    public static function getChunks() {
        $result = (new \yii\db\Query())->select(['name', 'value'])->from(Chunk::tableName())->all();
        return ArrayHelper::map($result, 'name', 'value');
    }
}

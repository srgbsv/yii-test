<?php

namespace app\models;

use app\components\Eventable\EventableInterface;
use app\components\Eventable\EventableTrait;
use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property integer $author
 * @property string $content
 */
class Article extends \yii\db\ActiveRecord
 	implements EventableInterface
{
    use EventableTrait;

    public static $EVENTS = [
        'PUBLICATE' => 'publicate',
        'DELETE' => 'delete',
        'UPDATE' => 'update'
    ];

    public static function getEvents() {
        return self::$EVENTS;
    }

    public static function getRecipientList() {
        return [
            'author'
        ];
    }

    public function getRecipient($name) {
        switch($name) {
            case 'author':
            default:
                return $this->author;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'author' => 'Author',
            'content' => 'Content',
        ];
    }
}

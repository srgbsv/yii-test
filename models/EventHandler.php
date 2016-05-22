<?php

namespace app\models;

use app\models\User;
use app\models\Chunk;
use app\components\Transport\Transport;
use Yii;
use yii\twig;
use yii\twig\Extension;

/**
 * This is the model class for table "event_handler".
 *
 * @property integer $id
 * @property string $model
 * @property string $event
 * @property integer $notification_id
 * @property string $event_handlerscol
 */
class EventHandler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_handler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient', 'event_model', 'event_name', 'transport'], 'string', 'max' => 45],
            [['template', 'params'], 'string'],
            [['recipient', 'event_model', 'event_name', 'template'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_model' => 'Модель',
            'event_name' => 'Название события',
            'recipient' => 'Получатель',
            'transport' => 'Транспорт',
            'template' => 'Шаблон',
        ];
    }

    public function findByEvent($event_model, $event_name) {
        return EventHandler::find()->where(['event_model' => $event_model, 'event_name' => $event_name])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification() {
        return $this->hasMany(Notification::className(), ['id' => 'notification_id']);
    }

    /**
     * Обработкса события
     *
     * @param event - событие
     * @return \yii\db\ActiveQuery
     */
    public function fire_event($event) {
        $params_array = [];
        if ($this->params) {
            $params = unserialize($this->params);
            foreach($params as $param) {
                if ($param['type'] == 'model') {
                    $params_array[$param['name']] = $event->sender->$param['value'];
                } else {
                    $params_array[$param['name']] = $param['value'];
                }
            }
        }
        $params_array['chunks'] = Chunk::getChunks();  // получение глобальных параметров сайта
        $loader = new \Twig_Loader_Filesystem('/'); //для парсинга шаблонов используется шаблонизатор Twig
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new Extension());
        $tmp = $twig->createTemplate($this->template);
        $msg = $tmp->render($params_array);
        $recipient = $this->recipient;
        $recipients = [];
        if ($recipient == '0') {
            $recipients = User::find()->all();
        } else if (is_numeric($recipient)) {
            $recipients[] = User::findOne($recipient);
        } else {
            $recipient_tmp = User::findOne($event->sender->getRecipient('same'));
            if (is_array($recipient_tmp)) {
                foreach($recipient_tmp as $row) {
                    $recipients[] = $row;
                }
            } else {
                $recipients[] = $recipient_tmp;
            }
        }
        $transport = new Transport($this->transport);
        $transport->send($recipients, $this->title, $msg);
    }

    /**
     * Перегрузка Model:: load() добавлен парсинг дополнительных параметров
     * шаблона оповещения, которые добавляются с помощью jQuery
     *
     * @param event - событие
     * @return \yii\db\ActiveQuery
     */
    public function load($data, $formName = null) {
        $params =[];
        foreach($data as $key=>$value) {
            if (preg_match('/^param\-([A-Za-z0-9]+)$/', $key, $res)) {
                $param['name'] = $res[1];
                $param['type'] = $data['param-'.$res[1].'-type'];
                $param['value'] = $data['param-'.$res[1]];
                $params[] = $param;
            }
        }
        $data['EventHandler']['params'] = serialize($params);
        return parent::load($data, $formName);
    }
}

<?php

namespace ricco\ticket\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use ricco\ticket\Module;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ticket_head".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $department
 * @property string $topic
 * @property integer $status
 * @property string $date_update
 */
class TicketHead extends \yii\db\ActiveRecord
{
    
    /**
     * Статусы тикетов
     * EGS: be carefull to not translate or change this constants
     */
    const STATUS_OPEN = 10;
    const STATUS_WAIT = 1;
    const STATUS_ANSWER = 2;
    const STATUS_CLOSED = 3;
    const STATUS_VIEWED = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ticket_head}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['date_update'], 'safe'],
            [['department', 'topic'], 'string', 'max' => 255],
            [['department', 'topic'], 'filter', 'filter' => 'strip_tags']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_update',
                'updatedAtAttribute' => 'date_update',
                'value' => new Expression('NOW()')
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ticket', 'ID'),
            'user_id' => Yii::t('ticket', 'User'),
            'department' => Yii::t('ticket', 'Department'),
            'topic' => Yii::t('ticket', 'Тopic'),
            'status' => Yii::t('ticket', 'Status'),
            'date_update' => Yii::t('ticket', 'Updated')
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Yii::$app->ticket->userModel, ['id' => 'user_id']);
    }

    public function getBody()
    {
        return $this->hasOne(TicketBody::className(), ['id_head' => 'id'])->orderBy('date DESC');
    }

    /**
     * @return int|string Возвращает количество новых тикетов статус которых OPEN или WAIT
     */
    public static function getNewTicketCount()
    {
        return TicketHead::find()->where('status = 0 OR status = 1')->count();
    }

    /**
     * Возвращает количество тикетов в по статусам
     *
     * @param int $status int Статус тикета
     * @return int|string
     */
    public static function getNewTicketCountUser($status = 0)
    {
        return TicketHead::find()->where("status = $status AND user_id = " . Yii::$app->user->id . " ")->count();
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $files = TicketFile::find()
            ->joinWith('idBody', false)
            ->where(['id_head' => $this->id])
            ->all();
        foreach($files as $file) {
            @unlink(Yii::getAlias(Yii::$app->ticket->uploadFilesDirectory) . '/' . $file->fileName);
            @unlink(Yii::getAlias(Yii::$app->ticket->uploadFilesDirectory) . '/reduced/' . $file->fileName);
        }

        return parent::beforeDelete();
    }

    public function getDepartmentName()
    {
        return ArrayHelper::getValue($this->departmentList, $this->department);
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue($this->statusList, $this->status);
    }

    public function getStatusList()
    {
        return [
            static::STATUS_OPEN => Yii::t('ticket', 'Opened'),
            static::STATUS_WAIT => Yii::t('ticket', 'In progress'), 
            static::STATUS_ANSWER => Yii::t('ticket', 'Answered'),
            static::STATUS_CLOSED => Yii::t('ticket', 'Closed'),
            static::STATUS_VIEWED => Yii::t('ticket', 'Viewed')
        ];
    }

    public function getDepartmentList()
    {
        return Yii::$app->ticket->qq;
    }

    public function getStatusLabel()
    {
        switch ($this->status)
        {
            case static::STATUS_OPEN:
                return 'default';
            case static::STATUS_WAIT:
                return 'warning';
            case static::STATUS_ANSWER:
                return 'success';
            case static::STATUS_CLOSED:
                return 'info';
            default:
                return 'default';
        }
    }

    public function getUserName()
    {
        return $this->user ? $this->user->username : null;
    }

}

<?php

namespace ricco\ticket\controllers;

use ricco\ticket\Mailer;
use ricco\ticket\forms\admin\TicketBodyForm as TicketBody;
use ricco\ticket\forms\admin\TicketHeadForm as TicketHead;
use Yii;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * @property Module $module
 */
class AdminController extends \ricco\ticket\components\BaseAdminController
{
    /**
     * Выдорка всех тикетов
     * Сортировка по полю дата в обратном порядке
     * Постраничная навигация по 20 тикетов на страницу
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = TicketHead::find()->joinWith('user');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date_update' => SORT_ASC
                ]
            ],
            'pagination' => [
                'pageSize' => Yii::$app->ticket->pageSize
            ]
        ]);

        Url::remember();

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Функция вытаскивает данные тикета по id и отображает данные
     * После получения пост данных id тикущего тикета присваевается к ответу и сохраняется
     * Потом идет выборка данных по шапке тикета, меняем ему статус и сохраняем
     * Проверяем если $mailSendAnswer === true значит делаем отправку уведомления од ответе пользователю создавшему тикет
     *
     * @param $id int
     * @return string|\yii\web\Response
     */
    public function actionAnswer($id)
    {
        $ticketHead = TicketHead::findOne($id);

        if (!$ticketHead)
        {
            throw new NotFoundHttpException('Ticket not found.');
        }

        $thisTicket = TicketBody::find()->where(['id_head' => $ticketHead->id])->joinWith('file')->orderBy('date ASC')->all();
        
        $newTicket = new TicketBody();

        if (Yii::$app->request->post())
        {
            $newTicket->load(\Yii::$app->request->post());
        
            $newTicket->id_head = $ticketHead->id;

            if ($newTicket->save())
            {        
                $ticketHead->status = TicketHead::STATUS_ANSWER;

                if ($ticketHead->save())
                {
                    return $this->redirect(Url::to()); 
                }
            }
        }

        return $this->render('answer', [
            'thisTicket' => $thisTicket, 
            'newTicket' => $newTicket,
            'ticketHead' => $ticketHead
        ]);
    }

    /**
     * Делаем выборку шапки тикета, меняем ему статус на закрытый и сохоаняем
     * Если $mailSendClosed === true, делаем отправку уведомления на email о закрытии тикета
     *
     * @param $id int id
     * @return \yii\web\Response
     */
    public function actionClose($id)
    {
        $model = TicketHead::findOne($id);

        $model->status = TicketHead::STATUS_CLOSED;

        $model->save();
		
		if (Yii::$app->ticket->mailSend !== false) {
            (new Mailer())
                ->sendMailDataTicket($model->topic, $model->status, $model->id, '')
                ->setDataFrom(Yii::$app->params['adminEmail'], Yii::$app->ticket->subjectAnswer)
                ->senda('closed');
        }

        return $this->redirect(Url::previous());
    }

    /**
     * @param $id int
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        TicketHead::findOne($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOpen()
    {
        $ticketHead = new TicketHead;

        $ticketBody = new TicketBody;

        $userModel = Yii::$app->ticket->userModel;

        $users = $userModel::find()->select(['username as value', 'username as label', 'id as id'])->asArray()->all();

        if ($post = Yii::$app->request->post()) {
            
            $ticketHead->load($post);

            $ticketBody->load($post);
            
            if ($ticketHead->validate() && $ticketBody->validate())
            {
                $ticketHead->status = TicketHead::STATUS_ANSWER;
                
                if ($ticketHead->save())
                {
                    $ticketBody->id_head = $ticketHead->primaryKey;
                    
                    $ticketBody->save();

                    $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('open', [
            'ticketHead' => $ticketHead,
            'ticketBody' => $ticketBody,
            'users' => $users
        ]);
    }

    public function actionView($id)
    {
        return $this->redirect(['answer', 'id' => $id]);
    }

}
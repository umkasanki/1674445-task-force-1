<?php

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_IN_PROGRESS = 'inProgress';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUSED = 'refused';

    public const ACTION_START_TASK = 'action_start';
    public const ACTION_RESPOND_TASK = 'action_respond';
    public const ACTION_ADD_TASK_DEVELOPER = 'action_add';
    public const ACTION_REFUSE_TASK = 'action_refuse';
    public const ACTION_CANCEL_TASK = 'action_cancel';
    public const ACTION_CLOSE_TASK = 'action_close';

    public $customerId;
    public $developerId;

    public $status;
    public $allowedActions;

    public $publishDate;
    public $dueDate;
    public $category;
    public $budget;
    public $location;
    public $remote;

    public $title;
    public $description;
    public $attachments;
    public $comments;

    public $responseList;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
        $this->status = self::STATUS_NEW;
    }

    // метод для возврата «карты» статусов
    public function getStatuses()
    {
        return array(
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_FAILED => 'Провалено',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_REFUSED => 'Разработчик отказался',
        );
    }

    // метод для возврата «карты» действий
    public function getActionses()
    {
        return array(
            self::ACTION_START_TASK => 'Добавить',
            self::ACTION_RESPOND_TASK => 'Откликнуться',
            self::ACTION_ADD_TASK_DEVELOPER => 'Назначить исполнителя',
            self::ACTION_CANCEL_TASK => 'Отменить',
            self::ACTION_CLOSE_TASK => 'Завершить',
            self::ACTION_REFUSE_TASK => 'Отказаться',
        );
    }

    // метод для получения статуса, в которой он перейдёт после выполнения указанного действия
    public function getNextStatus($actionName)
    {
        switch ($actionName) {
            case self::ACTION_START_TASK:
                return self::STATUS_NEW;
            case self::ACTION_ADD_TASK_DEVELOPER:
                return self::STATUS_IN_PROGRESS;
            case self::ACTION_REFUSE_TASK:
                return self::STATUS_REFUSED;
            case self::ACTION_CANCEL_TASK:
                return self::STATUS_CANCEL;
            case self::ACTION_CLOSE_TASK:
                return self::STATUS_DONE;
        }
    }

    // метод для получения доступных действий для указанного статуса
    public function getNextActions($user)
    {
        if ($this->status == self::STATUS_NEW) {
            if ($user->role == $user::ROLE_CUSTOMER) {
                return self::ACTION_CANCEL_TASK;
            }

            return self::ACTION_RESPOND_TASK;
        }
        if ($this->status == self::STATUS_IN_PROGRESS) {
            if ($user->role == $user::ROLE_CUSTOMER) {
                return self::ACTION_CLOSE_TASK;
            }

            return self::ACTION_REFUSE_TASK;
        }
    }
}

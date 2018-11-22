<?php
namespace App\Presenters;

class TeacherNotificationPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function userName()
    {
        if ($this->entity->user_id == 0) {
            return 'Broadcast';
        }

        $user = $this->entity->teacher;
        if (empty($user)) {
            return 'Unknown';
        }

        return $user->name;
    }

    public function sentAt()
    {
        return \DateTimeHelper::changeToPresentationTimeZone($this->entity->sent_at);
    }
}

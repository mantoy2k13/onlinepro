<?php
namespace App\Services\Production;

use App\Models\Notification;
use App\Repositories\UserNotificationRepositoryInterface;
use App\Services\MailServiceInterface;
use App\Services\PointLogServiceInterface;

class PointLogService extends BaseService implements PointLogServiceInterface
{
    /** @var \App\Services\MailServiceInterface */
    protected $mailService;

    /** @var \App\Repositories\UserNotificationRepositoryInterface */
    protected $userNotificationRepository;

    public function __construct(
        UserNotificationRepositoryInterface $userNotificationRepository,
        MailServiceInterface $mailService
    ) {
        $this->userNotificationRepository = $userNotificationRepository;
        $this->mailService                = $mailService;
    }

    public function sendNotification($pointLog)
    {
        $userNotice = ['user_id'=> $pointLog->user->id,
            'category_type'     => Notification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            'type'              => Notification::TYPE_POINT_ALERT,
            'title'             => trans('user.notifications.message.admin_add_point', ['amount' => $pointLog->point_amount]),
            'content'           => trans(
                'user.notifications.message.admin_add_point',
                ['amount' => $pointLog->point_amount]
            ).$pointLog->content,
            'sent_at' => \DateTimeHelper::now(),
            'data'    => json_encode(''),
        ];
        $userNote = $this->userNotificationRepository->create($userNotice);
        $this->mailService->sendEmailNotifyPointFromAdmin($pointLog);
    }
}

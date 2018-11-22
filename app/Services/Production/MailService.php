<?php
namespace App\Services\Production;

use App\Services\MailServiceInterface;
use Aws\Ses\SesClient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MailService extends BaseService implements MailServiceInterface
{
    public function __construct()
    {
    }

    public function sendMail($title, $from, $to, $template, $data)
    {
        if (config('app.offline_mode')) {
            return true;
        }

        if (\App::environment() != 'production' && \App::environment() != 'staging') {
            $title = '['.\App::environment().'] '.$title;
            $to    = [
                'address' => config('mail.tester'),
                'name'    => \App::environment().' Original: '.$to['address'],
            ];
        }

        $client = new SesClient([
            'credentials' => [
                'key'    => config('aws.key'),
                'secret' => config('aws.secret'),
            ],
            'region'  => config('aws.ses_region'),
            'version' => 'latest',
        ]);

        try {
            $body    = \View::make($template, $data)->render();
            $sesData = [
                'Source'      => mb_encode_mimeheader($from['name']).' <'.$from['address'].'>',
                'Destination' => [
                    'ToAddresses' => [$to['address']],
                ],
                'Message' => [
                    'Subject' => [
                        'Data'    => $title,
                        'Charset' => 'UTF-8',
                    ],
                    'Body' => [
                        'Html' => [
                            'Data'    => $body,
                            'Charset' => 'UTF-8',
                        ],
                    ],
                ],
            ];
            $client->sendEmail($sesData);
        } catch (\Exception $e) {
            echo $e->getMessage(), "\n";
        }

        return true;
    }

    public function sendMailVerifyCode($user)
    {
        if (empty($user)) {
            return false;
        }

        $subject  = trans('user.emails.title.verify_email');
        $from     = config('mail.contact');
        $to       = ['address'=>$user->email, 'name'=>$user->name];
        $template = 'emails.user.verify_email';
        $data     = ['subject' => $subject, 'validationCode'=>$user->validation_code,
            'from'             => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendInquiryMailToSekaihe($inquiry)
    {
        if (empty($inquiry)) {
            return false;
        }

        $subject  = trans('user.emails.title.contact', ['inquiryId' => $inquiry->id]);
        $from     = config('mail.from');
        $to       = config('mail.contact');
        $template = 'emails.user.inquiry_received';
        $data     = ['inquiry' => $inquiry, 'subject' => $subject,
            'from'             => $from, 'to' => $to, ];

        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendBookingEmailUser($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.booking_user', ['dateTime' => $booking->timeSlot->present()->dateFormatLightBox]);
        $from     = config('mail.from');
        $to       = ['address' => $booking->user->email, 'name' => $booking->present()->userName];
        $template = 'emails.user.booking_complete_for_user';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'teacher', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendBookingEmailTeacher($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject = trans('user.emails.title.booking_teacher', ['name' => $booking->user->name,
            'dateTime'                                                => $booking->timeSlot->present()->dateFormatLightBox, ]);
        $from     = config('mail.from');
        $to       = ['address' => $booking->teacher->email, 'name' => $booking->present()->teacherName];
        $template = 'emails.user.booking_complete_for_teacher';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'teacher', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendBookingEmailAdmin($userAction, $booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.booking_admin', ['dateTime' => $booking->timeSlot->present()->dateFormatLightBox]);
        $from     = config('mail.from');
        $to       = config('mail.contact');
        $template = 'emails.user.booking_complete_for_admin';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'teacher', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendCancelBookingEmailTeacher($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.cancel_teacher', ['dateTime' => $booking->timeSlot->present()->dateFormatLightBox]);
        $from     = config('mail.from');
        $to       = ['address' => $booking->teacher->email, 'name' => $booking->present()->teacherName];
        $template = 'emails.user.cancel_booking_for_teacher';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'teacher', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendCancelBookingEmailUser($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.cancel_user', ['dateTime' => $booking->timeSlot->present()->dateFormatLightBox]);
        $from     = config('mail.from');
        $to       = ['address' => $booking->user->email, 'name' => $booking->present()->userName];
        $template = 'emails.user.cancel_booking_for_user';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendCancelBookingEmailAdmin($userAction, $booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject = trans(
            'user.emails.title.cancel_admin',
            ['name' => $userAction->name, 'dateTime' => $booking->timeSlot->present()->dateFormatLightBox]
        );
        $from     = config('mail.from');
        $to       = config('mail.contact');
        $template = 'emails.user.cancel_booking_for_admin';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendCancelBookingEmailTeacherSuccess($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.cancel_teacher_success');
        $from     = config('mail.from');
        $to       = ['address' => $booking->teacher->email, 'name' => $booking->teacher->name];
        $template = 'emails.user.cancel_booking_for_teacher_success';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendCancelBookingEmailUserSuccess($booking)
    {
        if (empty($booking)) {
            return false;
        }
        $subject  = trans('user.emails.title.cancel_user_success');
        $from     = config('mail.from');
        $to       = ['address' => $booking->user->email, 'name' => $booking->user->name];
        $template = 'emails.user.cancel_booking_for_user_success';
        $data     = ['booking' => $booking, 'subject' => $subject,
            'from'             => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendEmailNotifyPointFromAdmin($pointLog)
    {
        if (empty($pointLog)) {
            return false;
        }
        $subject  = trans('user.emails.title.admin_add_point', ['amount' => $pointLog->point_amount]);
        $from     = config('mail.from');
        $to       = ['address' => $pointLog->user->email, 'name' => $pointLog->user->name];
        $template = 'emails.user.add_point_by_admin';
        $data     = ['pointLog' => $pointLog, 'subject' => $subject,
            'from'              => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendEmailPurchaseUser($user, $package)
    {
        if (empty($user)) {
            return false;
        }
        $subject  = trans('user.emails.title.purchase');
        $from     = config('mail.from');
        $to       = ['address' => $user->email, 'name' => $user->name];
        $template = 'emails.user.buy_point_complete';
        $data     = ['user' => $user, 'subject' => $subject, 'package' =>$package,
            'from'          => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendEmailExpiredUser($user, $expiredPoints)
    {
        if (empty($user)) {
            return false;
        }
        $subject  = trans('user.emails.title.expired');
        $from     = config('mail.from');
        $to       = ['address' => $user->email, 'name' => $user->name];
        $template = 'emails.user.expired_point';
        $data     = ['user' => $user, 'subject' => $subject, 'expiredPoints' =>$expiredPoints,
            'from'          => $from, 'to' => $to, 'target' => 'user', ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    public function sendEmailForgotPassWord($to, $token)
    {
        $subject  = trans('user.emails.title.reset_email');
        $from     = config('mail.from');
        $to       = ['address' => $to, 'name' => ''];
        $template = 'emails.user.reset_password';
        $data     = ['subject' => $subject, 'token' => $token,
            'from'             => $from, 'to' => $to, ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }

    private function sendEmailCommon($subject, $from, $to, $template, $data)
    {
        if (App::environment() === 'testing') {
            return true;
        } elseif (App::environment() === 'local') {
            $result = $this->sendMailLocal($template, $data);
        } else {
            $result = $this->sendMail($subject, $from, $to, $template, $data);
        }

        return $result;
    }

    private function sendMailLocal($template, $data)
    {
        Mail::queue($template, $data, function ($message) use ($data) {
            $message->from($data['from']['address'], $data['from']['name']);
            $message->sender($data['from']['address'], $data['from']['name']);
            $message->subject($data['subject']);
            $message->to($data['to']['address'], $data['to']['name']);
        });
    }

    public function sendMailVerifyChangeEmail($user, $newEmail, $validationCode)
    {
        if (empty($user)) {
            return false;
        }

        $subject  = trans('user.emails.title.verify_change_email');
        $from     = config('mail.from');
        $to       = ['address'=>$newEmail, 'name'=>$user->name];
        $template = 'emails.user.verify_change_email';
        $data     = ['subject' => $subject, 'validationCode'=>$validationCode,
            'from'             => $from, 'to' => $to, 'newEmail' => $newEmail, ];
        $result = $this->sendEmailCommon($subject, $from, $to, $template, $data);

        return $result;
    }
}

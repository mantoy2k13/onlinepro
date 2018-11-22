<?php
namespace App\Services;

interface MailServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $title
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array  $data
     *
     * @return bool
     */
    public function sendMail($title, $from, $to, $template, $data);

    public function sendInquiryMailToSekaihe($inquiry);

    public function sendMailVerifyCode($user);

    public function sendBookingEmailUser($booking);

    public function sendBookingEmailTeacher($booking);

    public function sendBookingEmailAdmin($userAction, $booking);

    public function sendCancelBookingEmailTeacher($booking);

    public function sendCancelBookingEmailUser($booking);

    public function sendCancelBookingEmailAdmin($userAction, $booking);

    public function sendCancelBookingEmailTeacherSuccess($booking);

    public function sendCancelBookingEmailUserSuccess($booking);

    public function sendEmailNotifyPointFromAdmin($pointLog);

    public function sendEmailPurchaseUser($user, $package);

    public function sendEmailExpiredUser($user, $expiredPoints);

    public function sendMailVerifyChangeEmail($user, $newEmail, $validationCode);

    public function sendEmailForgotPassWord($to, $token);
}

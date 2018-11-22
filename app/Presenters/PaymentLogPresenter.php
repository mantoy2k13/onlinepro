<?php
namespace App\Presenters;

use Carbon\Carbon;

class PaymentLogPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function paidForMonth()
    {
        $paidForMonth = Carbon::parse($this->entity->paid_for_month);
        $locale       = \LocaleHelper::getLocale();
        if ($locale == 'ja') {
            return $paidForMonth->format('Y').'年'.$paidForMonth->format('m').'月分';
        } else {
            return $paidForMonth->format('Y').'/'.$paidForMonth->format('m');
        }
    }

    public function paidAmount()
    {
        return number_format($this->entity->paid_amount);
    }
}

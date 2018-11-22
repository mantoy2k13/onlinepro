<?php
namespace App\Presenters;

use App\Models\PurchaseLog;

class PointLogPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function createdAt()
    {
        $value = 'N/A';
        if (!empty($this->entity->created_at)) {
            $value = \DateTimeHelper::changeToPresentationTimeZone($this->entity->created_at);
        }

        return $value;
    }

    public function package()
    {
        $value = '';
        if (!empty($this->entity->purchaseLog)
            and $this->entity->purchaseLog->purchase_method_type == PurchaseLog::PURCHASE_TYPE_PAYPAL
            and $this->entity->point_amount > 0) {
            if ($this->entity->purchaseLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_LIGHT) {
                $value = '-Light package';
            } elseif ($this->entity->purchaseLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_BASIC) {
                $value = '--Basic package';
            } elseif ($this->entity->purchaseLog->point_amount == PurchaseLog::PURCHASE_PACKAGE_PAYPAL_PREMIUM) {
                $value = '---Premium package';
            }
        } elseif (!empty($this->entity->purchaseLog)
            and $this->entity->purchaseLog->purchase_method_type == PurchaseLog::PURCHASE_TYPE_BY_ADMIN) {
            $value = '-Point add by admin';
        }

        return $value;
    }
}

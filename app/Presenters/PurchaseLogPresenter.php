<?php
namespace App\Presenters;

class PurchaseLogPresenter extends BasePresenter
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
}

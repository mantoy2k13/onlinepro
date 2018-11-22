<?php
namespace App\Presenters;

use App\Models\User;

class UserPresenter extends BasePresenter
{
    public function livingCountry()
    {
        $value = 'N/A';
        if (!empty($this->entity->livingCountry)) {
            $value = $this->entity->livingCountry->name_ja;
        }

        return $value;
    }

    public function livingCity()
    {
        $value = 'N/A';
        if (!empty($this->entity->livingCity)) {
            $value = $this->entity->livingCity->name_ja;
        }

        return $value;
    }

    public function homeProvince()
    {
        $value = 'N/A';
        if (!empty($this->entity->homeProvince)) {
            $value = $this->entity->homeProvince->name_ja;
        }

        return $value;
    }

    public function nationalityCountry()
    {
        $value = 'N/A';
        if (!empty($this->entity->nationalityCountry)) {
            $value = $this->entity->nationalityCountry->name_ja;
        }

        return $value;
    }

    public function createdAt()
    {
        $createdAt = \DateTimeHelper::changeToPresentationTimeZone($this->entity->created_at);

        return $createdAt;
    }

    public function registerType()
    {
        $type = 'Register by email';

        if (!empty($this->entity->userServicesAuthentications)) {
            $type = 'Register by '.$this->entity->userServicesAuthentications->service;
        }

        return $type;
    }

    public function expiredTimePoint($time)
    {
        if (!empty($time)) {
            $value  = \DateTimeHelper::createTimeFromString($time);
            $locale = \LocaleHelper::getLocale();
            if ($locale == 'ja') {
                return $value->format('m').'月'.$value->format('d').'日';
            } else {
                return $value->format('m').'/'.$value->format('d');
            }
        } else {
            return null;
        }
    }

    public function status()
    {
        $status = 'confirmed';
        if ($this->entity->status == User::STATUS_NOT_VALIDATED) {
            $status = 'not_confirmed';
        }
        if (!empty($this->entity->deleted_at)) {
            $status = 'deleted';
        }

        return $status;
    }
}

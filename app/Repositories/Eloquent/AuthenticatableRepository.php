<?php
namespace App\Repositories\Eloquent;

use App\Models\AuthenticatableBase;
use App\Models\EmailLog;
use App\Repositories\AuthenticatableRepositoryInterface;

class AuthenticatableRepository extends SingleKeyModelRepository implements AuthenticatableRepositoryInterface
{
    public function getBlankModel()
    {
        return new AuthenticatableBase();
    }

    public function findByEmail($email)
    {
        $className = $this->getModelClassName();

        return $className::whereEmail($email)->first();
    }

    public function findByFacebookId($facebookId)
    {
        $className = $this->getModelClassName();

        return $className::whereFacebookId($facebookId)->first();
    }

    public function findByEmailLog($email)
    {
        $emailLog = new EmailLog();

        return $emailLog::whereOldEmail($email)->orWhere('new_email', $email)->first();
    }
}

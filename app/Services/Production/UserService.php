<?php
namespace App\Services\Production;

use App\Models\User;
use App\Repositories\EmailLogRepositoryInterface;
use App\Repositories\UserPasswordResetRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\PointServiceInterface;
use App\Services\UserServiceInterface;

class UserService extends AuthenticatableService implements UserServiceInterface
{
    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = 'Reset Password';

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = 'emails.user.reset_password';

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    /** @var EmailLogRepositoryInterface $emailLogRepository */
    protected $emailLogRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordResetRepositoryInterface $userPasswordResetRepository,
        PointServiceInterface $pointService,
        EmailLogRepositoryInterface $emailLogRepository
    ) {
        $this->authenticatableRepository    = $userRepository;
        $this->passwordResettableRepository = $userPasswordResetRepository;
        $this->pointService                 = $pointService;
        $this->emailLogRepository           = $emailLogRepository;
    }

    public function getGuardName()
    {
        return 'web';
    }

    public function confirmUser($validationCode)
    {
        $user = $this->authenticatableRepository->getUserByValidationCode($validationCode);
        if (empty($user)) {
            return false;
        } else {
            $this->authenticatableRepository->update(
                $user,
                ['status' => User::STATUS_VALIDATED, 'validation_code' => '']
            );
            $this->processUserFirstSignUp($user->id);
        }

        return true;
    }

    public function generateValidationCode()
    {
        return str_random(50);
    }

    public function processUserFirstSignUp($userId)
    {
        $user = $this->authenticatableRepository->find($userId);
        $this->authenticatableRepository->update($user, ['status' => User::STATUS_VALIDATED]);
        $this->pointService->addPointSignupUser($user->id);
    }

    public function confirmChangeEmail($validationCode)
    {
        $emailLog = $this->emailLogRepository->getEmailLogByValidationCode($validationCode);

        if (empty($emailLog)) {
            return false;
        } else {
            $user = $this->authenticatableRepository->find($emailLog->user_id);
            if (empty($user)) {
                return false;
            }
            $this->authenticatableRepository->update($user, ['email' => $emailLog->new_email]);
            $this->emailLogRepository->update($emailLog, ['status' => User::STATUS_VALIDATED, 'validation_code' => '']);
        }

        return true;
    }
}

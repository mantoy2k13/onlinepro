<?php
namespace App\Services\Production;

use App\Repositories\AuthenticatableRepositoryInterface;
use App\Repositories\ServiceAuthenticationRepositoryInterface;
use App\Services\ServiceAuthenticationServiceInterface;
use App\Services\UserServiceInterface;

class ServiceAuthenticationService extends BaseService implements ServiceAuthenticationServiceInterface
{
    /** @var \App\Repositories\ServiceAuthenticationRepositoryInterface */
    protected $serviceAuthenticationRepository;

    /** @var \App\Repositories\AuthenticatableRepositoryInterface */
    protected $authenticatableRepository;

    /** @var UserServiceInterface $userService */
    protected $userService;

    public function __construct(
        AuthenticatableRepositoryInterface $authenticatableRepository,
        ServiceAuthenticationRepositoryInterface $serviceAuthenticationRepository,
        UserServiceInterface $userService
    ) {
        $this->authenticatableRepository       = $authenticatableRepository;
        $this->serviceAuthenticationRepository = $serviceAuthenticationRepository;
        $this->userService                     = $userService;
    }

    /**
     * @param string $service
     * @param array  $input
     *
     * @return \App\Models\AuthenticatableBase
     */
    public function getAuthModelId($service, $input)
    {
        $columnName = $this->serviceAuthenticationRepository->getAuthModelColumn();

        $authInfo = $this->serviceAuthenticationRepository->findByServiceAndId(
            $service,
            array_get($input, 'service_id')
        );
        if (!empty($authInfo)) {
            return $authInfo->$columnName;
        }

        $authUser = $this->authenticatableRepository->findByEmail(array_get($input, 'email'));
        $emailLog = $this->authenticatableRepository->findByEmailLog(array_get($input, 'email'));
        if (!empty($authUser) || !empty($emailLog)) {
            return null;
        } else {
            $authUser = $this->authenticatableRepository->create($input);
            $this->userService->processUserFirstSignUp($authUser->id);
            $input[$columnName] = $authUser->id;
            $this->serviceAuthenticationRepository->create($input);
        }

        return $authUser->id;
    }
}

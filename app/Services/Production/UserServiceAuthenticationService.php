<?php
namespace App\Services\Production;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserServiceAuthenticationRepositoryInterface;
use App\Services\PointServiceInterface;
use App\Services\UserServiceAuthenticationServiceInterface;
use App\Services\UserServiceInterface;

class UserServiceAuthenticationService extends ServiceAuthenticationService implements UserServiceAuthenticationServiceInterface
{
    /** @var \App\Repositories\UserServiceAuthenticationRepositoryInterface */
    protected $serviceAuthenticationRepository;

    /** @var \App\Repositories\UserRepositoryInterface */
    protected $authenticatableRepository;

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    /** @var UserServiceInterface $userService */
    protected $userService;

    public function __construct(
        UserRepositoryInterface $authenticatableRepository,
        UserServiceAuthenticationRepositoryInterface $serviceAuthenticationRepository,
        PointServiceInterface $pointService,
        UserServiceInterface $userService
    ) {
        $this->authenticatableRepository       = $authenticatableRepository;
        $this->serviceAuthenticationRepository = $serviceAuthenticationRepository;
        $this->pointService                    = $pointService;
        $this->userService                     = $userService;
    }
}

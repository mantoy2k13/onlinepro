<?php
namespace App\Services;

interface UserServiceInterface extends AuthenticatableServiceInterface
{
    public function confirmUser($validationCode);

    public function generateValidationCode();

    public function confirmChangeEmail($validationCode);

    public function processUserFirstSignUp($userId);
}

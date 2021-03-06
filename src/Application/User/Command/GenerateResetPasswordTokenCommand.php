<?php
declare(strict_types=1);

namespace TSwiackiewicz\AwesomeApp\Application\User\Command;

use TSwiackiewicz\AwesomeApp\DomainModel\User\UserLogin;

/**
 * Class GenerateResetPasswordTokenCommand
 * @package TSwiackiewicz\AwesomeApp\Application\User\Command
 */
class GenerateResetPasswordTokenCommand implements UserCommand
{
    /**
     * @var UserLogin
     */
    private $login;

    /**
     * GenerateResetPasswordTokenCommand constructor.
     * @param UserLogin $login
     */
    public function __construct(UserLogin $login)
    {
        $this->login = $login;
    }

    /**
     * @return UserLogin
     */
    public function getLogin(): UserLogin
    {
        return $this->login;
    }
}
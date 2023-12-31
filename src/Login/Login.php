<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Request;
use App\Core\Session\{Session, SessionUsage};
use App\User\User;

class Login
{
    use SessionUsage;
    use Request;
    use Config {
        SessionUsage::get insteadof Config;
        SessionUsage::get insteadof Request;
        Config::get as getConfig;
        Request::get as getRequest;
    }

    public function doLogin(
        ?string $userName,
        ?string $userPassword,
        ?bool $rememberMeCookie = null,
        LoginValidate $loginValidate = new LoginValidate()
    ): bool {
        $validationResult = $loginValidate->validateUser(userName: $userName, userPassword: $userPassword);
        if (!$validationResult) {
            return false;
        }

        return true;
    }

    public function doLogout(): bool
    {
        $userId = $this->get(key: 'user_id');

        $this->deleteCookie($userId);
        (new Session())->destroy();
        $this->updateSessionId($userId);
        return true;
    }

    private function deleteCookie(?string $userId): void
    {
        if ($userId ?? false) {
            (new User(userId: $userId))
                ->deleteRememberedUserById();
        }

        (new LoginWithCookie())
            ->setCookie($this->cookie($this->getConfig('COOKIE_REMEMBER_ME_NAME')))
            ->deleteCookie();
    }
}
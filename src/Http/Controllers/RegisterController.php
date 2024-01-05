<?php

use App\Http\Controllers\Controller;
use App\Register\Register;
use App\DataTransfer\RegisterDTO;

class RegisterController extends Controller
{

    public function __construct
    (
    )
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view->render('register/index');
    }

    public function register(): void
    {
        $registerDTO = new RegisterDTO(
            $_POST['user_name'],
            $_POST['user_password'],
            $_POST['user_password_repeat'],
            $_POST['user_email'],
            $_POST['user_email_repeat']
        );
        $this->view->render(
            'register/response',
            (new Register(object: $registerDTO))->response
        );
    }
}
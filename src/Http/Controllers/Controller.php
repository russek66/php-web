<?php

namespace App\Http\Controllers;

use App\Core\View;

class Controller
{
    public function __construct(public View $View = new View())
    {
//        Session::init();
//        Auth::checkSessionConcurrency();
    }
}
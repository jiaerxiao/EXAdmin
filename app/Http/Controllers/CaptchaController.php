<?php

namespace App\Http\Controllers;

use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller
{
    public function __invoke()
    {
        return Captcha::create();
    }
}

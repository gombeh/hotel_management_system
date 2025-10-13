<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function __invoke()
    {
        return inertia('Landing/Home');
    }
}

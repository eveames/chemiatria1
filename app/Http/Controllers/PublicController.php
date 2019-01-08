<?php

namespace chemiatria\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    //controller for intro pages that don't require login

    public function lewis()
    {
        return view('public.lewis');
    }
}

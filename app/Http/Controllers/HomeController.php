<?php

namespace chemiatria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use chemiatria\Mail\Report;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')->with('user', auth()->user());
    }

    public function email_progress()
    {
        $user = auth()->user();
        Mail::to($user)->send(new Report($user));
        Session::flash('message', 'Successfully emailed!');
        return view('home')->with('user', auth()->user());
    }
}

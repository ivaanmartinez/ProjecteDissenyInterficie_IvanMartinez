<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Factory|View|Application
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    public function show(): Factory|View|Application
    {
       $user = auth()->user();

        return view('users.show', compact('user'));
    }
}

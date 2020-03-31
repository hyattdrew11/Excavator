<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $admin      = Auth::user()->hasRole('admin');
        $user       = Auth::user()->hasRole('user');
        $unverified = Auth::user()->hasRole('unverified');

        if($admin)    { 
            $admin = Auth::user();
            $users = \DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->get();
            $connections = \DB::table('smtp')->get();
            $jobs = \DB::table('jobs')->get();
            return view('admin-home', ['admin' => $admin, 'users' => $users, 'connections' => $connections, 'jobs'=>$jobs] );  
        }
        elseif($user) { 
            $user = Auth::user();
            return view('user-home', ['user' => $user] );   
        }
        else { 
            return view('welcome');     
        }
    }
    public function smtp()
    {

        $admin      = Auth::user()->hasRole('admin');
        $user       = Auth::user()->hasRole('user');
        $unverified = Auth::user()->hasRole('unverified');

        if($admin)    { 
            $admin = Auth::user();
            $users = \DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->get();
            $connections = \DB::table('smtp')->get();
            $jobs = \DB::table('jobs')->get();
            return view('admin-smtp', ['admin' => $admin, 'users' => $users, 'connections' => $connections, 'jobs'=>$jobs] );  
        }
        elseif($user) { 
            $user = Auth::user();
            return view('user-home', ['user' => $user] );   
        }
        else { 
            return view('welcome');     
        }
    }
     public function jobs()
    {

        $admin      = Auth::user()->hasRole('admin');
        $user       = Auth::user()->hasRole('user');
        $unverified = Auth::user()->hasRole('unverified');

        if($admin)    { 
            $admin = Auth::user();
            $users = \DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->get();
            $connections = \DB::table('Smtp')->get();
            $jobs = \DB::table('jobs')
                ->join('users', 'jobs.user_id', '=', 'users.id')
                ->get();
            return view('admin-jobs', ['admin' => $admin, 'users' => $users, 'connections' => $connections, 'jobs'=>$jobs] );  
        }
        elseif($user) { 
            $user = Auth::user();
            return view('user-home', ['user' => $user] );   
        }
        else { 
            return view('welcome');     
        }
    }

}

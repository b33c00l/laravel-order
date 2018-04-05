<?php

namespace App\Http\Controllers;

use App\Client;
use App\Country;
use App\Http\Requests\DisableUserRequest;
use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('users.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
       if($request->role != 'admin'){
           $password_token = str_random(64);
           $client = Client::create($request->except('name', 'password', 'role', '_token') + ['name' => $request->get('client_name')]);
           $client->user()->create($request->only('name', 'role', 'price_coefficient', 'country_id') +
               ['password' => '', 'password_token' => $password_token]);

           Mail::to($request->only('email'))->send(new UserCreated($password_token));

       } else {
           User::create($request->only('name', 'role') + ['password' => bcrypt($request->password)]);
       }
       session() -> flash( 'success', 'User created successfully' );

        return redirect()->route('users.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $client = $user->client;
        $countries = Country::all();
        return view('users.edit', compact('user','client', 'countries'));
    }


    /**
     * @param UpdateUserRequest $request
     * @param $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $client = $user->client;
        if ($request->get('price_coefficient') == null){
            $price_coefficient = 1;
        } else {
            $price_coefficient = $request->get('price_coefficient');
        }
        if($request->role != 'admin') {
            $user->update($request->only('name', 'price_coefficient', 'role', 'country_id'));
            $client->update($request->except('name', 'password', 'role', '_token')  + ['name' => $request->get('client_name')]);
        } else {
            $user->update($request->only('name', 'role')  + ['price_coefficient' => $price_coefficient]);
        }
        session() -> flash( 'success', 'User updated successfully' );
        return redirect()->route('users.index', $id);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->disabled == 1) {
            $user->update([ 'disabled' => 0 ]);
            session() -> flash( 'success', 'User enabled successfully' );
        } else {
            $user->update([ 'disabled' => 1 ]);
            session() -> flash( 'success', 'User disabled successfully' );
        }

        return redirect()->back();
    }

    public function getToken($token)
    {
        if (User::where('password_token', $token)->exists()) {
            return view('users.passwordCreate', ['token' => $token]);
        } else {
            return redirect()->route('home');
        }
    }

    public function storePassword(StorePasswordRequest $request)
    {
        $user = User::where('password_token', $request->get('token'))->first();
        $user->update(['password' => bcrypt($request->get('password')), 'password_token' => null]);

        return redirect()->route('home');
    }
}

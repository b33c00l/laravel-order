<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function form()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }

    public function submit(UpdateProfileRequest $request)
    {
        $data = $request->only('email', 'vat_number', 'registration_number', 'contact_person', 'phone', 'name', 'registration_address', 'shipping_address');

        $user = Auth::user();
        $user->client->update($data);

        return redirect()->back()
          ->with('success', 'Your information was successfully updated');
    }

    public function password(StorePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect()->back()
          ->with('success', 'Your information was successfully updated');
    }
}

<?php

namespace App\Http\Controllers;

use App\ProfileUser;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request)
    {

        $profile = @auth()->user()->profile;

        if ($profile) {
            return response()->json([
                'success' => false,
                "msg" => "You already have profile"
            ], 500);
        }

        $this->validate($request, [
            'phone' => 'required|unique:profile_user,phone',
            'birthday' => 'required|date_format:Y-m-d|before:today'
        ]);

        $input = $request->all();

        $input['user_id'] = auth()->user()->id;

        $profile = ProfileUser::create($input);

        return response()->json([
            'data' => $profile,
            'msg' => 'Create profile successful',
            'success' => true,
        ], 200);

    }

    public function index($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'msg' => 'not found'
            ], 500);
        }

        return response()->json([
            'data' => $user->profile,
            'msg' => 'Get profile successful',
            'success' => true,
        ], 200);

    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'msg' => 'not found'
            ], 500);
        }

        $userLogin = auth()->user();

        if ($user->id != $userLogin->id) {
            return response()->json([
                'success' => false,
                'msg' => 'This is not your profile.'
            ], 500);
        }

        $profile = $userLogin->profile;

        $this->validate($request, [
            'phone' => 'required|unique:profile_user,phone,' . @$profile->id,
            'birthday' => 'required|date_format:Y-m-d|before:today'
        ]);
        if ($profile) {
            $userLogin->profile()->update($request->all());
        } else {
            $profile = new ProfileUser($request->all());
            $userLogin->profile()->save($profile);
        }

        return response()->json([
            'data' => $user->profile,
            'msg' => 'Change profile successful',
            'success' => true,
        ], 200);
    }
}

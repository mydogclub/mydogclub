<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class ProfileController extends Controller
{
	public function show($id)
	{
		$user = User::where('id', $id)->first();
		return view('widget.profile', compact('user'));
	}
}
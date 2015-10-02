<?php
/*
This file is part of SeAT

Copyright (C) 2015  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace Seat\Web\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Seat\Services\Repositories\Configuration\UserRespository;
use Seat\Web\Validation\EditUser;

/**
 * Class UserController
 * @package Seat\Web\Http\Controllers\Configuration
 */
class UserController extends Controller
{

    use UserRespository;

    /**
     * @return \Illuminate\View\View
     */
    public function getAll()
    {

        $users = $this->getAllFullUsers();

        return view('web::configuration.users.list', compact('users'));
    }

    /**
     * @param $user_id
     *
     * @return \Illuminate\View\View
     */
    public function editUser($user_id)
    {

        $user = $this->getFullUser($user_id);

        $login_history = $user->login_history()
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        return view('web::configuration.users.edit',
            compact('user', 'login_history'));
    }

    /**
     * @param \Seat\Web\Validation\EditUser $request
     *
     * @return mixed
     */
    public function updateUser(EditUser $request)
    {

        $user = $this->getUser($request->input('user_id'));

        $user->fill([
            'name'  => $request->input('username'),
            'email' => $request->input('email'),
        ]);

        // Update the password if it was set.
        if ($request->input('password'))
            $user->password = bcrypt($request->input('password'));

        $user->save();

        return Redirect::back()
            ->with('success', trans('web::access.user_updated'));
    }

    /**
     * @param $user_id
     *
     * @return mixed
     */
    public function editUserAccountStatus($user_id)
    {

        $this->flipUserAccountStatus($user_id);

        return Redirect::back()
            ->with('success', trans('web::access.account_status_change'));
    }
}
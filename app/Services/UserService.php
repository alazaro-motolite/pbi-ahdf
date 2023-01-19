<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGroup;
use Carbon\Carbon;

class UserService
{
    public static function doLogin($request)
    {
        $user = User::whereEncrypted('email', '=', $request['email'])
            ->where('users.status', '=', 1)
            ->join('user_group', 'user_group.id', '=', 'users.group_id')
            ->select('users.*', 'user_group.group_name')
            ->get();

        if($user->isEmpty()) :
            $response = [
                'status'  => 400,
                'message' => static::message(1),
                'url'     => NULL
            ];
        else :
            if(password_verify($request['password'], $user[0]->password)) :
                session()->put('isLogged', true);
                session()->put('name', $user[0]['name']);
                session()->put('email', $user[0]['email']);
                session()->put('group', $user[0]['group_name']);
                session()->put('groupID', $user[0]['group_id']);
                session()->put('userID', $user[0]['id']);

                $response = [
                    'status'  => 200,
                    'message' => 'success',
                    'url'     => ($user[0]->group_id == 1) ? '/user' : '/dashboard'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => static::message(2),
                    'url'     => NULL
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function showUsers()
    {
        $users = User::all();
        $output = '';
        $output .= '<table class="table table-sm user_data_table">
                    <thead>
                        <tr>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-2">Email Address</th>
                            <th>Password</th>
                            <th class="col-md-1">User Group</th>
                            <th class="col-md-1 text-center">Status</th>
                            <th class="col-md-1 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($users as $row) :
            $badge  = ($row->status == 1) ? 'label label-success' : 'label label-danger';
            $text   = ($row->status == 1) ? 'ACTIVE' : 'INACTIVE';
            $status = ($row->status == 1) ? 'deactivate' : 'activate';
            $icon   = ($row->status == 1) ? 'icon-close2' : 'icon-checkmark-circle2';

            $output .= '<tr>
                            <td>'.$row->name.'</td>
                            <td>'.$row->email.'</td>
                            <td>'.$row->password.'</td>
                            <td>'.$row->group_name.'</td>
                            <td class="col-md-1 text-center"><span class="'. $badge .'">'. $text .'</span></td>
                            <td class="col-md-1 text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a data-toggle="modal" data-target="#modal_edit_user" data-id="'.$row->id.'" data-url="'. config('app.url') .'/user/edit/"><i class="icon-pencil"></i> Edit User</a></li>';
                                            if($row->group_id != 1) :
                                                $output .= '<li><a id="btnResetPassword" data-url="'. config('app.url') .'/user/reset-password" data-id="'. $row->id .'"><i class="icon-lock2"></i> Reset Password</a></li>
                                            <li><a id="btnStatus" data-url="'. config('app.url') .'/user/status" data-id="'. $row->id .'" data-status="'. $status .'"><i class="'. $icon .'"></i> '. ucwords($status).' User</a></li>';
                                        endif;
                            $output .= '</ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
            endforeach;
        $output .= '</tbody></table>';

        return $output;
    }

    public static function saveUser($request)
    {
        $checkEmail = User::where('email', '=', $request['email'])->exists();
        if($checkEmail) :
            $response = [
                'status'  => 400,
                'message' => static::message(3)
            ];
        else :
            User::create([
                'group_id'   => $request['userGroup'],
                'group_name' => static::groupName($request['userGroup']),
                'name'       => $request['name'],
                'email'      => $request['email'],
                'password'   => password_hash($request['password'], PASSWORD_DEFAULT),
                'status'     => 1,
                'created_at' => Carbon::now()
            ]);
            
            $response = [
                'status'  => 200,
                'message' => static::message(4)
            ];
        endif;

        return json_encode($response);
    }

    public static function userDetails($userID)
    {
        return User::where('id', '=', $userID)->get();
    }

    public static function modifyUserDetails($request)
    {
        $checkEmail = User::whereEncrypted('email', '=', $request['email'])
            ->where('id', '!=', $request['userID'])
            ->exists();

        if($checkEmail) :
            $response = [
                'status'  => 400,
                'message' => static::message(3)
            ];
        else :
            $user = User::find($request['userID']);
            $user->update([
                'group_id'   => $request['userGroup'],
                'group_name' => static::groupName($request['userGroup']),
                'name'       => $request['name'],
                'email'      => $request['email'],
                'updated_at' => Carbon::now()
            ]);

            $response = [
                'status'  => 200,
                'message' => static::message(6)
            ];
        endif;

        return json_encode($response);
    }

    public static function userStatus($data)
    {
        $statusValue = ($data['userStatus'] == 'deactivate') ? 0 : 1;
        $update = User::where('id', '=', $data['userID'])->update(['status' => $statusValue]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['userStatus'], static::message(8))
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['userStatus'], static::message(9))
            ];
        endif;

        return json_encode($response);
    }

    public static function resetPassword($userID)
    {
        $reset = User::where('id', '=', $userID)->update(['password' => password_hash('pass1234', PASSWORD_DEFAULT)]);
        if($reset) :
            $response = [
                'status'  => 200,
                'message' => static::message(10)
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => static::message(11)
            ];
        endif;

        return json_encode($response);
    }

    public static function modifyUserPassword($request)
    {
        $detail = User::where('id', '=', $request['userID'])->get();

        if(password_verify($request['oldPass'], $detail[0]->password)) :
            $update = User::where('id', '=', $request['userID'])->update([
                    'password'   => password_hash($request['newPass'], PASSWORD_DEFAULT),
                    'updated_at' => Carbon::now()
                ]);
            
            if($update) :
                $response = [
                    'status'  => 200,
                    'message' => 'Password has been modified. By clicking ok, you will be logout in the system. Please login again to check your new password.',
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Unable to change password. Try again later!',
                ];
            endif;
        else :
            $response = [
                'status'  => 400,
                'message' => 'Incorrect old password. Try again!',
            ];
        endif;

        return json_encode($response);
    }

    public static function userGroup()
    {
        return UserGroup::all();
    }

    private function groupName($id)
    {
        $result = UserGroup::where('id', '=', $id)->get();

        return $result[0]->group_name;
    }

    private function message($i)
    {
        $message = [
            1 => 'This account does not exist.',
            2 => 'Invalid password. Try again!',
            3 => 'Email address already exists. Try another one!',
            4 => 'User details successfully save!',
            5 => 'Unable to save user!',
            6 => 'User details successfully modified!',
            7 => 'Unable to modify user!',
            8 => 'Successfully %action% user account!',
            9 => 'Failed to %action% user account!',
            10 => 'Successfully reset user password! Default password is "pass1234".',
            11 => 'Failed to reset user password!'
        ];

        return $message[$i];
    }
}
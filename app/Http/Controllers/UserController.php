<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Config;

class UserController extends Controller
{
    public function getIndex()
    {
        $sortBy = 'email';
        $orderBy = 'asc';
        
        $users = User::orderBy($sortBy, $orderBy)->paginate(20);
        
        $data = array(
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'users' => $users
        );

        return view('users/view', $data);
    }

    public function getCreate()
    {
        $roles = Group::orderBy('name')->lists('name', 'id');
        return view('users/create')->with('roles', $roles);
    }
    
    public function getEdit($sid)
    {
        $user = User::find($sid);
        
        if ($user == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be found because it does not exist or may have been deleted."
            );
            return redirect('/admin/users')->withErrors($errors);
        }
        
        $roles = Group::orderBy('name')->lists('name', 'id');
        
        $group = $user->groups()->first();
        
        if ($group == null) {
            $group = Group::orderBy('name')->first();
        }
        
        $data = array(
            'roles' => $roles,
            'user' => $user,
            'group' => $group
        );
        
        return view('users/edit', $data);
    }

    public function postStore()
    {
        $sid = \Input::get('id');
        
        $rules = array(
            'name'    => 'required',
            'nickname'     => 'required',
            'email'         => 'required'
        );
        
        if (isset($sid)) {
            $rules['password'] = 'confirmed|min:6';
        } else {
            $rules['password'] = 'required|confirmed|min:6';
        }

        $validation = \Validator::make(\Input::all(), $rules);
        
        $path = (isset($sid) ? 'admin/users/edit/' . $sid : 'admin/users/create');
        
        if ($validation->fails()) {
            return redirect($path)->withErrors($validation)->withInput();
        }

        $name    = \Input::get('name');
        $nickname    = \Input::get('nickname');
        $email         = \Input::get('email');
        $mobile     = \Input::get('mobile');
        $password     = \Input::get('password');
        $role         = \Input::get('role');
        $activated     = (\Input::get('activated') == '' ? false : true);
        
        $user = (isset($sid) ? User::find($sid) : new User);
        
        if ($user == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be found or created. Please try again later."
            );
            return redirect('/admin/users')->withErrors($errors);
        }
        
        // Save or Update
        $user->email = $email;
        if ($password != '') {
            $user->password = \Hash::make($password);
        }
        $user->name = $name;
        $user->nickname = $nickname;
        $user->activated = $activated;
         $user->mobile = $mobile;
        
        if (! $user->save()) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be updated due to some problem. Please try again."
            );
            return redirect($path)->withErrors($errors)->withInput();
        }
        
        // Find user's group
        $old_group = $user->groups()->first();
        $new_group = Group::find($role);

        if ($new_group == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be updated because the selected group cannot be found. Please try again."
            );
            return redirect($path)->withErrors($errors)->withInput();
        }

        // Assign the group to the user
        if ($old_group == null) {
            $user->groups()->save($new_group);
        } elseif ($old_group->id != $new_group->id) {
            $user->groups()->detach();
            $user->groups()->save($new_group);
        }

        return redirect('admin/users');
    }

    public function getDelete($sid)
    {
        $user = User::find($sid);
        
        if ($user == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be found because it does not exist or may have been deleted."
            );
            return redirect('/admin/users')->withErrors($errors);
        }
        
        // Delete the user
        $user->delete();
        
        return redirect()->back();
    }

    public function getActivate($sid)
    {
        $user = User::find($sid);
        
        if ($user == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be found because it does not exist or may have been deleted."
            );
            return redirect('/admin/users')->withErrors($errors);
        }
        
        // Activate the user
        $user->activated = true;
        $user->save();
        
        return redirect()->back();
    }

    public function getDeactivate($sid)
    {
        $user = User::find($sid);
        
        if ($user == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The user cannot be found because it does not exist or may have been deleted."
            );
            return redirect('/admin/users')->withErrors($errors);
        }
        
        // Deactivate the user
        $user->activated = false;
        $user->save();
        
        return redirect()->back();
    }
    
    public function getSort($sortBy = 'email', $orderBy = 'asc')
    {
        $inputs = array(
            'sortBy' => $sortBy,
            'orderBy' => $orderBy
        );
        
        $rules = array(
            'sortBy'  => 'required|regex:/^[a-zA-Z0-9 _-]*$/',
            'orderBy' => 'required|regex:/^[a-zA-Z0-9 _-]*$/'
        );
        
        $validation = \Validator::make($inputs, $rules);

        if ($validation->fails()) {
            return redirect('admin/users')->withErrors($validation);
        }
        
        if ($orderBy != 'asc' && $orderBy != 'desc') {
            $orderBy = 'asc';
        }
        
        if ($sortBy == 'group') {
            $users = User::LeftJoin('users_groups', 'users_groups.user_id', '=', 'users.id')
                ->LeftJoin('groups', 'groups.id', '=', 'users_groups.group_id')
                ->select('users.*', 'groups.name')
                ->orderBy('groups.name', $orderBy)
                ->paginate(20);
        } else {
            $users = User::orderBy($sortBy, $orderBy)->paginate(20);
        }
        
        $data = array(
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'users' => $users
        );
        
        return view('users/view', $data);
    }
}

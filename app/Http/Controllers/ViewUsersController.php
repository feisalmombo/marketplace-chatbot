<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use App\Role;
use App\Permission;
use App\UserStatus;
use Excel;
use App\ActivityLog;
use App\LoanRequestApprove;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;

class ViewUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $customer_id = Auth::id();

        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('view_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $userData = DB::select(
            "SELECT
            users.id,
            users.first_name,
            users.last_name,
            users.email,
            users.phone_number,
            roles.slug,
            users.created_at
        FROM
            users,
            roles,
            users_roles
        WHERE
            users_roles.role_id = roles.id
            AND users_roles.user_id = users.id
            AND users.id = $customer_id
        ORDER BY users.id DESC"
        );
        return view('manageUser.viewuser')->with('userData', $userData);
    }

    public function allSystemsUsers()
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('view_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $userData = DB::select(
            "SELECT
            users.id,
            users.first_name,
            users.last_name,
            users.email,
            users.phone_number,
            roles.slug,
            users.created_at
        FROM
            users,
            roles,
            users_roles
        WHERE
            users_roles.role_id = roles.id
            AND users_roles.user_id = users.id
        ORDER BY users.id DESC"
        );
        return view('manageUser.viewallsystemUsers')
        ->with('userData', $userData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('create_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $role = DB::table('roles')
            ->select('id', 'slug')
            ->get();

        //return $role;
        return view('manageUser.createuser')->with('roles', $role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('create_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $this->validate(request(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phonenumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:12',
            'privilege' => 'required',
        ]);

        $dev_role = Role::where('slug', $request->privilege)->first();
        $dev_perm = Permission::where('slug', 'create')->first();

        $users = new User();
        $users->first_name = $request->fname;
        $users->last_name = $request->lname;
        $user_email = $users->email = strtolower($request->fname) . "." . strtolower($request->lname) . "@blog.co.tz";
        $users->phone_number = $request->phonenumber;
        $users->password = bcrypt(strtolower($user_email) . '1234');

        // return $users;
        $st = $users->save();
        $users->roles()->attach($dev_role);
        $users->permissions()->attach($dev_perm);
        $userstatus = new UserStatus();
        $userstatus->user_id = $users->id;
        $userstatus->slug = false;
        // return $userstatus;
        $userstatus->save();
        if (!$st) {
            return redirect()->back()->with('message', 'Failed to insert User data');
        }
        return redirect()->back()->with('message', 'User is successfully added with email:' . strtolower($user_email) . '  Password: ' . strtolower($user_email) . '1234');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $customer_id = Auth::id();
        // return $customer_id;
        // $userProfile = DB::table('users')
        // ->get();

        $userProfile = DB::select(
            "SELECT
            users.id,
            users.first_name,
            users.last_name,
            users.email,
            roles.slug,
            users.created_at
        FROM
            users,
            roles,
            users_roles
        WHERE
            users_roles.role_id = roles.id
            AND users_roles.user_id = users.id
            AND users.id = $customer_id"
        );
        // return json_encode($userProfile);
        return view('manageUser.showuserProfile')
        ->with('userProfile', $userProfile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('edit_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $user = User::findOrFail($id);
        //return $user;

        $leve = Role::all();
        //return $leve;

        return view('manageUser.edituser')->with('users', $user)->with('leve', $leve);
    }

    public function resetpwd($id)
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('reset_password')) {
                return $next($request);
            }
            return redirect()->back();
        });
        // dd($id);
        $user = User::findOrFail($id);
        $st = User::findOrFail($id)->update(['password' => bcrypt('123456')]);
        if (!$st) {
            return redirect()->back()->with('message', 'Failed to Reset User Password for ' . $user->first_name);
        }

        return redirect('/view-users')->with('message', 'Password is Successfully Reseted to 123456 for User  ' . $user->first_name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('edit_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $user = User::findOrFail($id);
        $this->validate(request(), [
            'fname' => 'required',
            'lname' => 'required',
            'useremail' => 'required',
            'phonenumber' => 'required',
        ]);

        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        $user->email = $request->useremail;
        $user->phone_number = $request->phonenumber;
        // return $user;
        $st = $user->save();
        if (!$st) {
            return redirect()->back()->with('message', 'Failed to Update User data');
        }

        return redirect('/view-users')->with('message', 'User is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->can('delete_user')) {
                return $next($request);
            }
            return redirect()->back();
        });
        $uid = \Auth::id();
        $user = User::findOrFail($id);
        $user->delete();
        ActivityLog::where('changetype', 'Delete User')->update(['user_id' => $uid]);


        $request->session()->flash('message', 'User is successfully deleted');
        return back();
    }

    public function report(Request $request)
    {
        $str_var = $_POST['tad'];
        $userData = unserialize(base64_decode($str_var));

        if ($request->view_type === 'downloadPdf') {
            $pdf = PDF::loadView('manageUser.report', ['userData' => $userData]);
            return $pdf->download('users.pdf');
        }
    }

    public function downloadExcel(Request $request)
    {
        $str_var = $_POST['tadas'];
        $data = unserialize(base64_decode($str_var));

        $count = 0;
        // Initialize the array which will be passed into the Excel
        // generator.
        $userArray = [];

        // Define the Excel spreadsheet headers
        $userArray[] = ['S/N', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE NUMBER' ,'PRIVILEGE'];

        // Convert each member of the returned collection into an array,
        // and append it to the atms array.
        foreach ($data as $datas) {
            $count++;
            $userArray[] = [$count, $datas->first_name, $datas->last_name, $datas->email, $datas->phone_number, $datas->slug];
        }


        // Generate and return the spreadsheet
        Excel::create('User(s)', function ($excel) use ($userArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('User');
            $excel->setCreator(\Auth::user()->first_name . ' ' . \Auth::user()->first_name)->setCompany('GetPesa Limited');
            $excel->setDescription('User file');

            // Build the spreadsheet, passing in the task array
            $excel->sheet('sheet1', function ($sheet) use ($userArray) {
                $sheet->fromArray($userArray, null, 'A1', false, false);
            });
        })->download('xlsx');
    }
}

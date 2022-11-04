<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\User\UserSaveRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Services\User\UserService;

class UserController extends Controller
{
    public $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $username = $request->username;
        $s_name = $request->s_name;
        $l_name = $request->l_name;
        $email = $request->email;
        $phone = $request->phone;
        $id = $request->id;
        $sex = $request->sex;
        $users = User::when($username, fn ($query) => $query->where('username', 'like', "%$username%"))
            ->when($s_name, fn ($query) => $query->where('s_name', 'like', "%$s_name%"))
            ->when($l_name, fn ($query) => $query->where('l_name', 'like', "%$l_name%"))
            ->when($id, fn ($query) => $query->where('id', $id))
            ->when($email, fn ($query) => $query->where('email', 'like', "%$email%"))
            ->when($phone, fn ($query) => $query->where('phone', 'like', "%$phone%"))
            ->when($sex, fn ($query) => $query->where('sex', 'like', "%$sex%"))
            ->latest()
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));

        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request)
    {
        return redirect()->route('admin.users.index')->with('success','Успешно добавлено');
        $user = new User();
        $this->userService->save($user, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->save($user, $request);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }
}

<?php

namespace App\Http\Controllers\Admin\Turnir;

use App\Http\Controllers\Controller;
use App\Models\TurnirUser;
use App\Http\Requests\Admin\Turnir\TurnirUserSaveRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TurnirUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $fio_user = $request->fio_user;
        $turnir_name = $request->turnir_name;
        $order_id = $request->order_id;

        $users = TurnirUser::when($user_id, fn($query) => $query->where('user_id', $user_id))
            ->when($fio_user, fn($query) => $query->where('fio_user', 'like', "%$fio_user%"))
            ->when($turnir_name, fn($query) => $query->where('turnir_name', 'like', "%$turnir_name%"))
            ->latest('id')
            ->when($order_id, fn($query) => $query->where('order_id', $order_id))
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/TurnirUsers/Index', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurnirUser  $turnirUser
     * @return \Illuminate\Http\Response
     */
    public function show(TurnirUser $turnirUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TurnirUser  $turnirUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turnirUser = TurnirUser::with(['user','turnir'])->findOrFail($id);
        return Inertia::render('Admin/TurnirUsers/Edit', [
            'user' => $turnirUser
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnirUser  $turnirUser
     * @return \Illuminate\Http\Response
     */
    public function update(TurnirUserSaveRequest $request, $id)
    {
        $turnirUser = TurnirUser::findOrFail($id);
        $turnirUser->update([
            'fio_user' => $request->fio_user,
            'update_count' => $request->update_count,
            'success' => $request->success,
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurnirUser  $turnirUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turnirUser = TurnirUser::findOrFail($id);
        $turnirUser->delete();
        return redirect()->back()->withSuccess('Успешно удалено!');

    }
}

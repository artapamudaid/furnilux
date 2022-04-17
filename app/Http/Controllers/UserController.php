<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {
            $user = User::query();

            return DataTables::of($user)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('dashboard.user.edit', $item->id) . '" class="inline-flex items-center h-6 bg-gray-500 hover:bg-gray-700 text-sm text-white font-bold py-2 px-2 rounded shadow-lg">
                    Edit
                    </a>
                    <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                    <button class="inline-flex items-center h-6 bg-red-500 hover:bg-red-700 text-sm text-white font-bold py-2 px-2 rounded shadow-lg" onclick="return confirm(`Are you sure to delete this user?`);>
                    ' . method_field('delete') . csrf_field() . '
                    Delete
                    </button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.backend.user.index');
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
        return view('pages.backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        $user->update($data);

        return redirect()->route('dashboard.user.index');
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

        return redirect()->route('dashboard.user.index');
    }
}

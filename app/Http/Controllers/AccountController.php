<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index');
    }

    public function getAccount(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // <a href="' . route('customer.show' . $row->idr_customer) . '" class="btn btn-icon btn-info my-1" title="Edit"><i class="fas fa-search"></i></a>
                    $btn = '
                    <a href="' . route('account.edit', $row->id) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('account.destroy', $row->id) . '" class="btn btn-icon btn-danger btn-delete-on-table" title="Delete"><i class="fas fa-trash"></i></a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $action = route("account.store");
        return view('account.form', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required',
            'phonenumber'   => 'required',
            'address'   => 'required'
        ]);

        //create post
        User::create([
            'name'     => $request->name,
            'phonenumber'   => $request->phonenumber,
            'address'   => $request->address
        ]);

        //redirect to index
        return redirect()->route('account.index')->with(['success' => 'Record created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $action = route('account.update', $user->idr_account);
        return view('account.form', compact('account', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required',
            'phonenumber'   => 'required',
            'address'   => 'required'
        ]);

        //create post
        $user->update([
            'name'     => $request->name,
            'phonenumber'   => $request->phonenumber,
            'address'   => $request->address
        ]);

        //redirect to index
        return redirect()->route('account.index')->with(['success' => 'Record updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        // dd($user);
        if ($user->delete()) {
            return response()->json(['code' => '200', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['code' => '400', 'message' => 'Record failed to delete']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index');
    }

    public function getAccount(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Account::latest()->get();
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
        $hide = false;
        return view('account.form', compact('action', 'hide'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required',
            'email'   => 'required|email|unique:users',
            'password'   => 'required'
        ]);

        //create post
        Account::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        //redirect to index
        return redirect()->route('account.index')->with(['success' => 'Record created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account): View
    {
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $account = Account::findOrFail($id);
        $action = route('account.update', $account->id);
        $hide = true;

        return view('account.form', compact('account', 'action', 'hide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required',
            'email'   => 'required|email'
        ]);

        $input = $request->all();
        // dd($input);

        $account->update($input);


        //redirect to index
        return redirect()->route('account.index')->with(['success' => 'Record updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account): JsonResponse
    {
        // dd($user);
        if ($account->delete()) {
            return response()->json(['code' => '200', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['code' => '400', 'message' => 'Record failed to delete']);
        }
    }
}

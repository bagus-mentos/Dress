<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.index');
    }

    public function getOrder(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // <a href="' . route('customer.show' . $row->idr_customer) . '" class="btn btn-icon btn-info my-1" title="Edit"><i class="fas fa-search"></i></a>
                    $btn = '
                    <a href="' . route('order.edit', $row->idt_order) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('order.destroy', $row->idt_order) . '" class="btn btn-icon btn-danger btn-delete-on-table" title="Delete"><i class="fas fa-trash"></i></a>
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

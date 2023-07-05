<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('order.index');
    }

    public function getOrder(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::with(['product', 'customer'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('productName', function ($row) {
                    return $row->product['name'];
                })
                ->addColumn('customerName', function ($row) {
                    return $row->customer['name'];
                })
                ->editColumn('rent_start_date', function ($row) {
                    return date('d-m-Y', strtotime($row->rent_start_date));
                })
                ->editColumn('rent_end_date', function ($row) {
                    return date('d-m-Y', strtotime($row->rent_end_date));
                })
                ->editColumn('event_date', function ($row) {
                    return date('d-m-Y', strtotime($row->event_date));
                })
                ->editColumn('appointment_date', function ($row) {
                    return date('d-m-Y', strtotime($row->appointment_date));
                })
                ->editColumn('downpayment', function ($row) {
                    return 'Rp. ' . $row->downpayment . ',-';
                })
                ->editColumn('idr_status', function ($row) {
                    switch ($row->idr_status) {
                        case '1':
                            return '<span class="badge bg-primary text-white">Primary</span>';
                            break;
                        case '2':
                            return '<span class="badge bg-success">Success</span>';
                            break;
                        case '3':
                            return '<span class="badge bg-danger">Danger</span>';
                            break;
                        case '4':
                            return '<span class="badge bg-warning text-dark">Warning</span>';
                            break;
                        default:
                            return '<span class="badge bg-light text-dark">Light</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    // <a href="' . route('customer.show' . $row->idr_customer) . '" class="btn btn-icon btn-info my-1" title="Edit"><i class="fas fa-search"></i></a>
                    $btn = '
                    <a href="' . route('order.edit', $row->idt_order) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('order.destroy', $row->idt_order) . '" class="btn btn-icon btn-danger btn-delete-on-table" title="Delete"><i class="fas fa-trash"></i></a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action', 'idr_status'])
                ->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $action = route("order.store");

        $product = Product::get();
        $customer = Customer::get();

        return view('order.form', compact('action', 'product', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'idr_product' => 'required',
            'idr_customer' => 'required',
            'rent_start_date' => 'required',
            'rent_end_date' => 'required',
        ]);

        $input = $request->all();

        Order::create($input);

        return redirect()->route('order.index')->with(['success' => 'Record created successfully.']);
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
    public function edit(Order $order): View
    {
        $action = route("order.update", $order->idt_order);


        $product = Product::get();
        $customer = Customer::get();

        return view('order.form', compact('action', 'product', 'customer', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->validate($request, [
            'idr_product' => 'required',
            'idr_customer' => 'required',
            'rent_start_date' => 'required',
            'rent_end_date' => 'required',
        ]);

        $input = $request->all();

        $order->update($input);

        return redirect()->route('order.index')->with(['success' => 'Record created successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if ($order->delete()) {
            return response()->json(['code' => '200', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['code' => '400', 'message' => 'Record failed to delete']);
        }
    }
}

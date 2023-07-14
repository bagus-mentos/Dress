<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = [];
        $orders = Order::with(['product', 'customer'])
                    ->where('idr_status','!=',1)
                    ->get();

        foreach ($orders as $order) {
            $date_end = Carbon::createFromFormat('Y-m-d', $order->event_date);
            $events[] = [
                'title' => $order->customer->name,
                'start' => $order->rent_start_date,
                'end'   => $date_end,
            ];
        }
        return view('order.index',compact('events'));
    }

    public function appointment(): View
    {
        $events = [];
        $orders = Order::with(['product', 'customer'])
                    ->where('idr_status',1)
                    ->get();

        foreach ($orders as $order) {
            $date_end = Carbon::createFromFormat('Y-m-d', $order->event_date);
            $events[] = [
                'title' => $order->customer->name,
                'start' => $order->appointment_date,
                'end'   => $order->appointment_date,
            ];
        }
        return view('order.indexappointment',compact('events'));
    }

    public function getOrder(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::with(['product', 'customer'])
                    ->where('idr_status','!=',1)
                    ->get();

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
                    return 'Rp. ' . number_format($row->downpayment) . ',-';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp. ' . number_format($row->product->price) . ',-';
                })
                ->editColumn('remaining', function ($row) {
                    return 'Rp. ' . number_format($row->product->price - $row->downpayment) . ',-';
                })
                ->editColumn('idr_status', function ($row) {
                    switch ($row->idr_status) {
                        case '1':
                            return '<span class="badge bg-primary text-white">Appointment</span>';
                            break;
                        case '2':
                            return '<span class="badge bg-success">On Going</span>';
                            break;
                        case '3':
                            return '<span class="badge bg-danger">Done</span>';
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

    public function getOrderByCustomer(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::with(['product', 'customer'])
                    ->where('idr_customer',$request['idr_customer'])
                    ->where('idr_status','!=',1)
                    ->get();

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
                    return 'Rp. ' . number_format($row->downpayment) . ',-';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp. ' . number_format($row->product->price) . ',-';
                })
                ->editColumn('remaining', function ($row) {
                    return 'Rp. ' . number_format($row->product->price - $row->downpayment) . ',-';
                })
                ->editColumn('idr_status', function ($row) {
                    switch ($row->idr_status) {
                        case '1':
                            return '<span class="badge bg-primary text-white">Appointment</span>';
                            break;
                        case '2':
                            return '<span class="badge bg-success">On Going</span>';
                            break;
                        case '3':
                            return '<span class="badge bg-danger">Done</span>';
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
                    <a href="' . route('order.editc', [$row->idt_order, $row->idr_customer]) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('order.destroy', $row->idt_order) . '" class="btn btn-icon btn-danger btn-delete-on-table" title="Delete"><i class="fas fa-trash"></i></a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action', 'idr_status'])
                ->toJson();
        }
    }

    public function getAppointment(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::with(['product', 'customer'])
                    ->where('idr_status',1)
                    ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('productName', function ($row) {
                    return $row->product['name'];
                })
                ->addColumn('customerName', function ($row) {
                    return $row->customer['name'];
                })
                ->editColumn('appointment_date', function ($row) {
                    return date('d-m-Y h:m', strtotime($row->appointment_date));
                })
                ->addColumn('action', function ($row) {
                    // <a href="' . route('customer.show' . $row->idr_customer) . '" class="btn btn-icon btn-info my-1" title="Edit"><i class="fas fa-search"></i></a>
                    $btn = '
                    <a href="' . route('order.editAppointment', $row->idt_order) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
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
        $status = Status::get();
        return view('order.form', compact('action', 'product', 'customer','status'));
    }

    public function createAppointment(): View
    {
        $action = route("order.storeAppointment");

        $product = Product::get();
        $customer = Customer::get();
        $status = Status::get();
        return view('order.formappointment', compact('action', 'product', 'customer','status'));
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
            'event_date' => 'required',
        ]);

        $input = $request->all();

        Order::create($input);

        return redirect()->route('order.index')->with(['success' => 'Record created successfully.']);
    }

    public function storeAppointment(Request $request): RedirectResponse
    {
        $request['idr_status'] = 1;
        $request['rent_start_date'] = $request->appointment_date;
        $request['event_date'] = $request->appointment_date;
        $this->validate($request, [
            'idr_product' => 'required',
            'idr_customer' => 'required',
            'appointment_date' => 'required',
        ]);

        $input = $request->all();

        Order::create($input);

        return redirect()->route('appointment')->with(['success' => 'Record created successfully.']);
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
        $status = Status::get();

        return view('order.form', compact('action', 'product', 'customer', 'order','status'));
    }

    public function editc($idt_order,$idr_customer): View
    {
        
        $action = route("order.updatec", $idt_order);

        $order = Order::find($idt_order);
        $product = Product::get();
        $customer = Customer::find($idr_customer);
        $status = Status::get();

        return view('order.formc', compact('action', 'product', 'customer', 'order','status'));
    }

    public function editAppointment($idt_order): View
    {
        $action = route("order.updateAppointment", $idt_order);
        
        $order = Order::find($idt_order);
        $product = Product::get();
        $customer = Customer::get();
        $status = Status::get();

        return view('order.formappointment', compact('action', 'product', 'customer', 'order','status'));
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
            'event_date' => 'required',
        ]);

        $input = $request->all();

        $order->update($input);

        return redirect()->route('order.index')->with(['success' => 'Record Updated successfully.']);
    }

    public function updatec(Request $request, Order $order) : View
    {

       DB::table('torder')->where('idt_order',$request['idt_order'])
        ->update([
            'idr_product' => $request['idr_product'],
            'rent_start_date' => $request['rent_start_date'],
            'event_date' => $request['event_date'],
            'notes' => $request['notes'],
            'downpayment' => $request['downpayment']
        ]);

        $customer = Customer::find($request['idr_customer']);
        
        $action = route('customer.update', $customer->idr_customer);
        return view('customer.form', compact('customer', 'action'))->with(['success' => 'Record Updated successfully.']);        //return view('customer.form',$request['idr_customer'])->with(['success' => 'Record Updated successfully.']);
    }

    public function updateAppointment(Request $request, Order $order): RedirectResponse
    {
        
        DB::table('torder')->where('idt_order',$request['idt_order'])
        ->update([
            'idr_product' => $request['idr_product'],
            'idr_customer' => $request['idr_customer'],
            'appointment_date' => $request['appointment_date'],
            'rent_start_date' => $request['appointment_date'],
            'event_date' => $request['appointment_date'],
            'notes' => $request['notes'],
        ]);
        return redirect()->route('appointment')->with(['success' => 'Record Updated successfully.']);    
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

<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Fabric;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // dd(SubCategory::find(2)->pluck('name'));
        return view('product.index');
    }

    public function getProduct(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Product::get();
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('pic1', function ($data) {
                //     $pic1 = '<img src="' . asset('/products/' . $data->pic1) . '" class="rounded" style="width: 150px">';
                //     return $pic1;
                // })
                ->addColumn('subCategory', function ($data) {
                    return SubCategory::where('idr_subcategory', $data->idr_subcategory)->pluck('name')->first();
                })
                ->addColumn('fabric', function ($data) {
                    return Fabric::where('idr_fabric', $data->idr_fabric)->pluck('name')->first();
                })
                ->addColumn('collection', function ($data) {
                    return Collection::where('idr_collection', $data->idr_collection)->pluck('name')->first();
                })
                ->addColumn('size', function ($data) {
                    return Size::where('idr_size', $data->idr_size)->pluck('name')->first();
                })
                ->addColumn('action', function ($row) {
                    // <a href="' . route('customer.show' . $row->idr_customer) . '" class="btn btn-icon btn-info my-1" title="Edit"><i class="fas fa-search"></i></a>
                    $btn = '
                    <a href="' . route('product.edit', $row->idr_product) . '" class="btn btn-icon btn-warning my-1" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('product.destroy', $row->idr_product) . '" class="btn btn-icon btn-danger btn-delete-on-table" title="Delete"><i class="fas fa-trash"></i></a>
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
        $action = route("product.store");

        $subCategory = SubCategory::get();
        $fabric = Fabric::get();
        $collection = Collection::get();
        $size = Size::get();

        return view('product.form', compact('action', 'subCategory', 'fabric', 'collection', 'size'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'pic1'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'pic2'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'pic3'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'pic4'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'idr_subcategory'     => 'required',
            'idr_fabric'     => 'required',
            'idr_collection'     => 'required',
            'idr_size'     => 'required',
            'name'     => 'required',
            'code'     => 'required',
            'notes'     => 'required',
            'price'     => 'required|integer',
            'condition'     => 'required',
            'color'   => 'required'
        ]);

        $input = $request->all();

        if ($request->hasFile('pic1')) {
            $pic1 = $request->file('pic1');
            $pic1Name = date('YmdHi') . $pic1->getClientOriginalName();
            $pic1->move(public_path('products'), $pic1Name);
            $input['pic1'] = "$pic1Name";
        }

        if ($request->hasFile('pic2')) {
            $pic2 = $request->file('pic2');
            $pic2Name = date('YmdHi') . $pic2->getClientOriginalName();
            $pic2->move(public_path('products'), $pic2Name);
            $input['pic2'] = "$pic2Name";
        }

        if ($request->hasFile('pic3')) {
            $pic3 = $request->file('pic3');
            $pic3Name = date('YmdHi') . $pic3->getClientOriginalName();
            $pic3->move(public_path('products'), $pic3Name);
            $input['pic3'] = "$pic3Name";
        }

        if ($request->hasFile('pic4')) {
            $pic4 = $request->file('pic4');
            $pic4Name = date('YmdHi') . $pic4->getClientOriginalName();
            $pic4->move(public_path('products'), $pic4Name);
            $input['pic4'] = "$pic4Name";
        }

        Product::create($input);

        //create post
        // Product::create([
        //     'pic1'     => $pic1Name,
        //     'pic2'     => $pic2Name,
        //     'pic3'     => $pic3Name,
        //     'pic4'     => $pic4Name,
        //     'idr_subcategory'     => $request->idr_subcategory,
        //     'idr_fabric'     => $request->idr_fabric,
        //     'idr_collection'     => $request->idr_collection,
        //     'idr_size'     => $request->idr_size,
        //     'name'     => $request->name,
        //     'code'     => $request->code,
        //     'price'     => $request->price,
        //     'notes'     => $request->notes,
        //     'condition'     => $request->condition,
        //     'color'   => $request->color
        // ]);

        //redirect to index
        return redirect()->route('product.index')->with(['success' => 'Record created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $action = route('product.update', $product->idr_product);

        $subCategory = SubCategory::get();
        $fabric = Fabric::get();
        $collection = Collection::get();
        $size = Size::get();

        return view('product.form', compact('product', 'action', 'subCategory', 'fabric', 'collection', 'size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //validate form
        $this->validate($request, [
            'pic1'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'pic2'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'pic3'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'pic4'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'idr_subcategory'     => 'required',
            'idr_fabric'     => 'required',
            'idr_collection'     => 'required',
            'idr_size'     => 'required',
            'name'     => 'required',
            'code'     => 'required',
            'notes'     => 'required',
            'price'     => 'required|integer',
            'condition'     => 'required',
            'color'   => 'required'
        ]);

        $input = $request->all();

        if ($request->hasFile('pic1')) {
            $pic1 = $request->file('pic1');
            $pic1Name = date('YmdHi') . $pic1->getClientOriginalName();
            $pic1->move(public_path('products'), $pic1Name);
            $input['pic1'] = "$pic1Name";
        } else {
            unset($input['pic1']);
        }

        if ($request->hasFile('pic2')) {
            $pic2 = $request->file('pic2');
            $pic2Name = date('YmdHi') . $pic2->getClientOriginalName();
            $pic2->move(public_path('products'), $pic2Name);
            $input['pic2'] = "$pic2Name";
        } else {
            unset($input['pic2']);
        }

        if ($request->hasFile('pic3')) {
            $pic3 = $request->file('pic3');
            $pic3Name = date('YmdHi') . $pic3->getClientOriginalName();
            $pic3->move(public_path('products'), $pic3Name);
            $input['pic3'] = "$pic3Name";
        } else {
            unset($input['pic3']);
        }

        if ($request->hasFile('pic4')) {
            $pic4 = $request->file('pic4');
            $pic4Name = date('YmdHi') . $pic4->getClientOriginalName();
            $pic4->move(public_path('products'), $pic4Name);
            $input['pic4'] = "$pic4Name";
        } else {
            unset($input['pic4']);
        }

        $product->update($input);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        if ($product->delete()) {
            return response()->json(['code' => '200', 'message' => 'Record deleted successfully']);
        } else {
            return response()->json(['code' => '400', 'message' => 'Record failed to delete']);
        }
    }
}

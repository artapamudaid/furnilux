<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $product = Product::query();

            return DataTables::of($product)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('dashboard.product.gallery.index', $item->id) . '" class="inline-flex items-center h-6 bg-indigo-500 hover:bg-indigo-700 text-sm text-white font-bold py-2 px-2 rounded shadow-lg">
                    Photos
                    </a>
                    <a href="' . route('dashboard.product.edit', $item->id) . '" class="inline-flex items-center h-6 bg-gray-500 hover:bg-gray-700 text-sm text-white font-bold py-2 px-2 rounded shadow-lg">
                    Edit
                    </a>
                    <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                    <button class="inline-flex items-center h-6 bg-red-500 hover:bg-red-700 text-sm text-white font-bold py-2 px-2 rounded shadow-lg" onclick="return confirm(`Are you sure to delete this product?`);">
                    ' . method_field('delete') . csrf_field() . '
                    Delete
                    </button>
                    </form>
                    ';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.backend.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('dashboard.product.index');
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
    public function edit(Product $product)
    {
        return view('pages.backend.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}

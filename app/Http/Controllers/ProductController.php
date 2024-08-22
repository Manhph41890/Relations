<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Gallery;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Product::with(['category', 'tags'])->latest('id')->paginate(1);

        return view('layouts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        $tags = Tag::pluck('name', 'id')->all();

        // dd($categories, $tags);
        return view('layouts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        try {
            DB::transaction(function () use ($request) {
                $dataProduct = [
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                ];

                if ($request->hasFile('image_path')) {
                    $dataProduct['image_path'] = Storage::put('products', $request->file('image_path'));
                }

                $product = Product::query()->create($dataProduct);

                foreach ($request->galleries as $image) {
                    Gallery::query()->create([
                        'product_id' => $product->id,
                        'image_path' => Storage::put('galleries', $image),
                    ]);
                }
                $product->tags()->attach($request->tags);
            });
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['category', 'tags', 'galleries'])->all();
        $productTags = $product->tags->pluck('id')->all();

        $categories = Category::pluck('name', 'id')->all();
        $tags = Tag::pluck('name', 'id')->all();

        return view('layouts.edit', compact('categories', 'tags', 'productTags',  'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $dataProduct = [
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                ];

                if ($request->hasFile('image_path')) {
                    $dataProduct['image_path'] = Storage::put('products', $request->file('image_path'));
                }

                $product->update($dataProduct);

                foreach ($request->galleries ?? [] as $id => $image) {
                    $gallery = Gallery::findOrFail($id);
                    $gallery->update([
                        'image_path' => Storage::put('galleries', $image),
                    ]);
                }
                $product->tags()->sync($request->tags);
            });
            return back()->with('success', 'Thao tac thanh cong');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                $product->tags()->sync([]);

                $product->galleries()->delete();

                $product->delete();
            });

            if ($product->image_path && Storage::exists($product->image_path)) {
                Storage::delete($product->image_path);
            }
            return redirect()->route('products.index')->with('success', 'Thao tac thanh cong');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
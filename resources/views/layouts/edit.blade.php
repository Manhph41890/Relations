@extends('layouts.master')

@section('title')
    Edit {{ $product->name }}
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif

    <div class="container mb-4 mt-2">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group mt-3">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $id => $name)
                        <option @selected($product->category_id == $id) value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
            </div>

            <div class="form-group mt-3">
                <label for="image_path">Image_path</label>
                <input type="file" class="form-control" id="image_path" name="image_path"
                    value="{{ $product->image_path }}">
                @if ($product->image_path && Storage::exists($product->image_path))
                    <img src="{{ Storage::url($product->image_path) }}" width="100px" height="100px" alt="">
                @endif
            </div>

            <div class="form-group mt-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
            </div>

            <div class="form-group mt-3">
                <label for="description">Description</label><br>
                <textarea name="description" id="description" cols="50" rows="10">{{ $product->description }}</textarea>
            </div>

            <div class="form-group mt-3">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" multiple class="form-control">
                    @foreach ($tags as $id => $name)
                        <option @selected(in_array($id, $productTags)) value="{{ $id }}">
                            {{ $name }}</option>
                    @endforeach
                </select>
            </div>


            @foreach ($product->galleries as $item)
                <br>
                <div class="form-group mt-3">
                    <label for="gallery_{{ $loop->iteration }}">Gallery {{ $loop->iteration }}</label>
                    <input type="file" name="galleries[{{ $item->id }}]" class="form-control"
                        id="gallery_{{ $loop->iteration }}">
                    @if ($item->image_path && Storage::exists($item->image_path))
                        <img src="{{ Storage::url($item->image_path) }}" width="100px" height="100px" alt="">
                    @endif
                </div>
            @endforeach


            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back list</a>
            </div>
        </form>
    </div>
@endsection

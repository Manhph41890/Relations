@extends('layouts.master')

@section('title')
    Create
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
    <div class="container mb-4 mt-2">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-3">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group mt-3">
                <label for="image_path">Image_path</label>
                <input type="file" class="form-control" id="image_path" name="image_path"
                    value="{{ old('image_path') }}">
            </div>

            <div class="form-group mt-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>

            <div class="form-group mt-3">
                <label for="description">Description</label><br>
                <textarea name="description" id="description" cols="50" rows="10">{{ old('description') }}</textarea>
            </div>

            <div class="form-group mt-3">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" multiple class="form-control">
                    @foreach ($tags as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="gallery_11">Gallery_1</label>
                <input type="file" name="galleries[]" class="form-control" id="gallery_1">
                <br>
                <label for="gallery_2">Gallery_2</label>
                <input type="file" name="galleries[]" class="form-control" id="gallery_2">
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back list</a>
            </div>
        </form>
    </div>
@endsection

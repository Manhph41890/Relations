@extends('layouts.master')

@section('title')
    List
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-success">Create</a>
    <div class="table mt-3">
        <table class="table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
            @foreach ($list as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->Category->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if ($product->image_path && Storage::exists($product->image_path))
                            <img src="{{ Storage::url($product->image_path) }}" width="100px" height="100px" alt="">
                        @endif
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>
                        @foreach ($product->tags as $tag)
                            <span class="badge bg-info">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Ban chac chan xoa khong')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $list->links() }}
    </div>
@endsection

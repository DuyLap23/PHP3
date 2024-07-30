@extends('layouts.master')
@section('header')
    <h1>products Edit</h1>
@endsection
@section('content')
    <div class="notication">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
    <form action="{{ route('products.update', $products->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="formFile" class="form-label">Name</label>
            <input class="form-control" name="name" type="text" id="formFile" value="{{ $products->name }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="formFile" class="form-label">Price</label>
                <input class="form-control" name="price" type="text" id="formFile" value="{{ $products->price }}">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class=" col-6 mb-3">
                <label for="formFile" class="form-label">Quantity</label>
                <input class="form-control" name="quantity" type="text" id="formFile" value="{{ $products->quantity }}">
                @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $products->description }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Categories</label>
            <select name="category_id" id="" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($products->category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Image</label>
            <input class="form-control" name="image" type="file" id="formFileMultiple">
            <img src="{{ asset('storage/' . $products->image) }}" width="100" alt="">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFileDisabled" class="form-label">Status</label>
            <input type="checkbox" id="formFileDisabled" value="1" {{ $products->status == 1 ? 'checked' : 'checked' }}
                name="status">
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn btn-success" type="submit">Submit</button>
        <a href="{{ route('home') }}" class=""><button type="button" class="btn btn-danger ">Cancel</button></a>
    </form>
    <div class="paginator">
        {{-- {{ $products->links() }} --}}
    </div>
@endsection

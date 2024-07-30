@extends('layouts.master')
@section('header')
    <h1>Categories create</h1>
@endsection
@section('content')
    <div class="notication">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>
    <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="formFile" class="form-label">Name</label>
            <input class="form-control" name="name" type="text" id="formFile">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Image</label>
            <input class="form-control" name="image" type="file" id="formFileMultiple">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="formFileDisabled" class="form-label">Status</label>
            <input type="checkbox" id="formFileDisabled" value="1" checked name="status">
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn btn-success" type="submit">Submit</button>
        <a  href="{{ route('home') }}" class=""><button type="button" class="btn btn-danger ">Cancel</button></a>
    </form>
   
@endsection

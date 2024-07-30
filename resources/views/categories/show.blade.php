@extends('layouts.master')
@section('header')
    <div class="d-flex justify-content-between mt-4">
        <h1>Categories show</h1>

        <a href="{{ route('home') }}" class=""><button type="button" class="btn btn-success ">Back</button></a>
    </div>
@endsection
@section('content')
    <div class="notication">
        @if (session('succes'))
            <div class="alert alert-danger">{{ session('succes') }}</div>
        @endif
    </div>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Trường dữ liệu</th>
                <th>Giá trị</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $categories->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $categories->name }}</td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    <img src=" {{ asset('storage/' . $categories->image) }}" width="100" height="200" class="object-fit-cover img-fluid rounded-3"
                    alt="">
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($categories->status)
                        <span class="badge bg-primary">On</span>
                    @else
                        <span class="badge bg-danger">Off</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
   
@endsection

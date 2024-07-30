@extends('layouts.master')
@section('header')
    <div class="d-flex justify-content-between mt-4">
        <h1>Categories index</h1>

        <a href="{{ route('create') }}" class=""><button type="button" class="btn btn-success ">Add</button></a>
    </div>
@endsection
@section('content')
    <div class="notication">
        @if (session('succes'))
            <div class="alert alert-danger">{{ session('succes') }}</div>
        @endif
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $key => $value)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $value->name }}</td>
                    <td>  <img src=" {{ asset('storage/' . $value->image) }}" width="100" height="200" class="object-fit-cover img-fluid rounded-3"
                      alt=""></td>
                    <td>{!! $value->status ? '<span class="badge bg-primary"> On</span>' : '<span class="badge bg-danger"> Off</span>' !!}</td>
                    <td>
                       <div class="d-flex">
                        <a href="{{ route('edit', $value->id) }}" class="nav-link"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{ route('show', $value->id) }}"class="nav-link"><i class="fa-regular fa-eye"></i></a>
                        <form action="{{ route('destroy', $value->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a onclick="return confirm('Are you sure?')" href="{{ route('destroy', $value->id) }}" class="nav-link"><i class="fa-solid fa-trash"></i></a>
                        </form>
                       </div>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <div class="paginator">
      {{ $categories->links() }}
  </div>
@endsection

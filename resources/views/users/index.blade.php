@extends('layouts.page', ['title' => 'Users'])
@section('content')
    <div class="col-10 mt-5">
        @include('layouts.partials.messages')
        <a class="btn btn-dark" href="{{route('users.create')}}">Create new user</a>
        <div class="col-md-12 table-responsive no-gutters">
            <table class="table table-sm table_container">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Name:</th>
                    <th scope="col">Role:</th>
                    <th scope="col">Country:</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="table-tr">
                        <td Data-label="user:" class="align-middle text-center">
                            {{ $user->name }}
                        </td>
                        <td Data-label="user:" class="align-middle text-center">
                            {{ $user->role }}
                        </td>
                        <td Data-label="user:" class="align-middle text-center">
                            @if($user->country)
                                {{ $user->country->name }}
                            @endif
                        </td>
                        <td class="text-lg-right"><a href="{{ route('users.edit', ['id' => $user->id])}}"
                                                     class="btn btn-dark btn-sm">Edit</a>
                        </td>

                        <td class="text-lg-left">
                            @if(Auth::user()->id != $user->id)
                            <form action="{{ route('users.destroy', ['id' => $user->id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="_method" value="delete">
                                    @if($user->disabled == 1)
                                        <button type="submit" class="btn btn-dark btn-sm">Enable</button>
                                    @else
                                        <button type="submit" class="btn btn-danger btn-sm">Disable</button>
                                    @endif
                                </div>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
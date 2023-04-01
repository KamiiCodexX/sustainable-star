@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1>{{ __('List of Companies') }}<a href="{{ route('companies.add') }}" class="btn btn-warning float-end mt-2">Add Company</a></h1>


                </div>

                <div class="card-body mt-3">
                    <table id="myTable" class="display table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Company Owner</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @if(!empty($companies))
                                @foreach($companies as $company)
                                    <tr>
                                        <td>{{ $company['name'] }}</td>
                                        <td>{{ $company['owner']['name'] }}</td>
                                        <td><a href="javascript:void(0)" class="delete-companies"><i style="color:red;" class="fa fa-trash fs-4" data-id="{{ $company['id'] }}"></i></a></td>
                                    </tr>
                                @endforeach
                            @endif --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('companies')
    <script src="{{ asset('js/companies.js?v=0.0.1')}}"></script>
@endpush



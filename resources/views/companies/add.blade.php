@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1>{{ __('Add Company') }}<a href="{{ route('companies.list') }}" class="btn btn-outline-primary float-end mt-2"><i class="
                    fa fa-arrow-left"></i> Back</a></h1>
                </div>
                <div class="card-body mt-3">
                    <form id="add-company-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="company[owner_id]" id="owner_id" type="hidden" value="{{ Auth::id() }}" >

                                <label class="col-form-label" for="name">Name<span class="requiredInput">*</span></label>
                                <input required name="company[name]" id="name" type="text" class="form-control" placeholder="Enter Name" >

                                <label class="col-form-label" for="contact">Contact No:<span class="requiredInput">*</span></label>
                                <input required name="company[contact]" id="contact" type="text" class="form-control" placeholder="Enter Contact Number" >
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label" for="email">Email<span class="requiredInput">*</span></label>
                                <input required name="company[email]" id="email" type="email" class="form-control" placeholder="Enter Email" >


                                <label class="col-form-label" for="country">Country</label>
                                <select name="company[country]" id="country" class="form-control js-example-basic-single">
                                    <option value="">Select a Country</option>
                                    <option value="ksa">Saudi Arabia</option>
                                    <option value="ku">Kuwait</option>
                                    <option value="bah">Bahrain</option>
                                    <option value="qa">Qatar</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label class="col-form-label" for="delegates">Delegates</label>
                                <select id="delegates" class="js-example-basic-multiple form-control" name="delegates[]" multiple="multiple">
                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-12">
                                <label class="col-form-label" for="description">Description</label>
                                <textarea name="company[description]" id="description" class="form-control" placeholder="Enter Description of your Company" ></textarea>
                            </div>

                            <div class="col-sm-12">
                                <label class="col-form-label" for="logo">Logo</label>
                                <input type="file" class="form-control" name="company[logo]" id="logo" accept=".jpeg,.png,.jpg">
                            </div>

                            <div class="col-sm-12">
                                <div class="mt-3"><button class="form-control btn btn-warning">Save</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(!empty($posts))
            @foreach($posts as $post)
            <div class="card">
                <div class="card-header">{{ __('Timeline') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div><input class="form-control" type="text" placeholder="What's on your mind?"></div>
                    <div class="mt-2"><button class="form-control"><img src="{{ asset('images/video.png') }}" alt="description of myimage">  Photo/Video</button></div>
                    <div class="d-none">
                        <div class="dropzone dropzone-previews form-control mt-2 " id="my-awesome-dropzone"></div>
                    </div>
                    <div class="mt-2"><button class="form-control btn btn-primary">POST</button></div>

                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
@push('companies')
    <script src="{{ asset('js/companies.js?v=0.0.1')}}"></script>
@endpush



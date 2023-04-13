@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-7">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <!-- <div class="card-header">{{ __('Timeline') }}</div> -->

                <div class="card-body">
                    <form id="create-post">
                        @csrf
                        <input type="hidden" name="owner_id" value="{{ session()->get('current_company')->id ?? Auth::id()  }}">
                        <input type="hidden" name="posted_by" value="{{ session()->has('current_company') ? 'company' : 'user' }}">
                        <div><textarea name="text" class="form-control" rows="5" type="text" placeholder="What's on your mind?" required></textarea></div>
                        <div class="mt-2"><button class="form-control uploadFileToPost"><img src="{{ asset('images/video.png') }}" alt="upload photo or video">  Photo/Video</button></div>
                        <div class="d-none dropZoneView">
                            <div class="dropzone dropzone-previews form-control mt-2 " id="my-awesome-dropzone"></div>
                        </div>
                        <div class="mt-2"><button class="form-control btn btn-primary">POST</button></div>
                    </form>
                </div>
            </div>

            <div id="post-view">
                @if(!empty($posts))
                    @foreach($posts as $post)
                        @include('posts.partials.view', ['post' => $post])
                    @endforeach
                @endif
            </div>
        </div>
        <div class="right-side-bar col-sm-5 position-fixed end-0  h100 overflow-auto">

            <div class="card">
                <div class="card-header">
                    @if(session()->has('current_company'))
                    {{ __('Owner') }}
                    @else
                    {{ __('Your Companies') }}
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!empty($companies) && !session()->has('current_company'))
                        @foreach($companies as $company)
                            <div class="accordion accordion-flush" id="accordionFlushExample_{{$company['id']}}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$company['id']}}" aria-expanded="false" aria-controls="flush-collapse-{{$company['id']}}">
                                        {{ $company['name'] ?? '' }}
                                    </button>
                                    </h2>

                                    <div id="flush-collapse-{{$company['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div>
                                                <form method="POST" action="{{ route('switch-company') }}">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{ $company['id'] ?? '' }}" >
                                                    <button class="btn btn-outline-danger" type="submit">Switch to Company</button>
                                                </form>
                                            </div>
                                            <ul class="list-group">
                                                @if(!empty($company['delegates']))
                                                    @foreach($company['delegates'] as $delegate)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-sm-6">{{ $delegate['user']['name'] }}</div>
                                                                <div class="col-sm-6">
                                                                    <form id="manage-permissions-{{$company['id']}}-{{$delegate['id']}}">
                                                                        @csrf

                                                                        <input type="hidden" name="owner_id" value="{{ Auth::id() }}">
                                                                        <input type="hidden" name="delegates_id" value="{{ $delegate['id'] }}">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" id="view_permission" checked disabled>
                                                                            <label class="form-check-label" for="view_permission">View Permission</label>
                                                                        </div>

                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" id="create_permission" name="create_permission" value="1"
                                                                            {{ !empty($delegate['permissions']) && $delegate['permissions']['create_permission'] == '1' ? 'checked' : '' }}
                                                                            >
                                                                            <label class="form-check-label" for="create_permission">Create Permission</label>
                                                                        </div>

                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" id="update_permission" name="update_permission" value="1"
                                                                            {{ !empty($delegate['permissions']) && $delegate['permissions']['update_permission'] == '1' ? 'checked' : '' }}

                                                                            >
                                                                            <label class="form-check-label" for="update_permission">Update Permission</label>
                                                                        </div>

                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" id="delete_permission" name="delete_permission" value="1"
                                                                            {{ !empty($delegate['permissions']) && $delegate['permissions']['delete_permission'] == '1' ? 'checked' : '' }}

                                                                            >
                                                                            <label class="form-check-label" for="delete_permission">Delete Permission</label>
                                                                        </div>


                                                                        <a href="javascript:void(0)" data-id="{{ $delegate['id'] }}" name="" id="" class="btn btn-outline-danger remove-permission">Remove</a>
                                                                        <button  data-id="{{ $delegate['id'] }}" type="submit" name="submit" id="" class="btn btn-outline-success allow-permission">Save</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <span>No user found</span>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(session()->has('current_company'))
                        <div>
                            <form method="GET" action="{{ route('switch-user') }}">
                                @csrf

                                <button class="btn btn-outline-danger" type="submit">Switch to User</button>
                            </form>
                        </div>
                    @else
                    <span>No Company Found</span>
                    @endif
                </div>
            </div>

            @if(!session()->has('current_company'))
             <div class="card">
                <div class="card-header">
                    {{ __('You are delegate of the following companies') }}
                </div>

                <div class="card-body">
                    @if(!empty($delegatedCompanies))
                        @foreach($delegatedCompanies as $company)
                            <div class="accordion accordion-flush" id="accordionFlushExample_1_{{$company['company']['id']}}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-1-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-1-{{$company['company']['id']}}" aria-expanded="false" aria-controls="flush-collapse-1-{{$company['company']['id']}}">
                                        {{ $company['company']['name'] ?? '' }}
                                    </button>
                                    </h2>

                                    <div id="flush-collapse-1-{{$company['company']['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div>
                                                <form method="POST" action="{{ route('switch-company') }}">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{ $company['company']['id'] ?? '' }}" >
                                                    <button class="btn btn-outline-danger" type="submit">Switch to Company</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <span>No Company Found</span>
                    @endif
                </div>
            </div>
            @endif
            <div class="card mt-3">
                <div class="card-header">{{ __('People You May Know') }}</div>

                <div class="card-body">
                    <ul class="list-group">
                        @if(!empty($users))
                            @foreach($users as $user)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-4">{{ $user['name'] }}</div>
                                        <div class="col-sm-8">
                                            <form id="allow-permission-{{$user['id']}}">
                                            @csrf
                                                <input type="hidden" name="user_id" value="{{ $user['id'] }}">

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <select name="company_id" id="company_id" class="form-control">
                                                        <option value="">Select Company</option>
                                                        @if(!empty($companies))
                                                            @foreach($companies as $company)
                                                                <option value="{{$company['id']}}">{{$company['name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <button type="submit" name="allow-permission" class="btn btn-outline-success allow-permission">Allow Permissions</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <span>No user found</span>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('posts')
    <script src="{{ asset('js/posts.js?v=0.0.1')}}"></script>
@endpush



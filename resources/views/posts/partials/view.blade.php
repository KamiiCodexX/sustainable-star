
<div id="post-number-{{$post['id']}}" class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8">
                <h5>
                    <img width="40px" height="40px" src="{{ asset('images/surprised.gif') }}" alt="profile" class="rounded-circle">
                    @php
                        $date = date_create($post['created_at']);
                    @endphp
                    <span>{{ $post['user']['name'] }}</span> posted on
                    <span class="">{{ date_format($date, 'j F, Y') }} at {{ date_format($date, 'H:i.') }}</span>
                </h5>
            </div>
            <div class="col-sm-4">
                <a href="javascript:void(0)" class=" float-end float-top mt-2">
                <img width="30px" height="30px" class="rounded-circle post-remove" src="{{ asset('images/letter-x.gif') }}" data-id="{{$post['id']}}" alt="X">
                </a>
            </div>

        </div>
    </div>
    <div class="card-body">
        @if(isset($post['text']))
        <div class="post-text-view " height="100px"><p class="post-text-field">{{ $post['text'] }}</p></div>
        @endif

        @if(isset($post['media']))
        <div class="post-text-view"><p><pre class="post-text-field">{{ $post['media'] }}</pre></p></div>
        @endif

    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4 text-center border-right like-post"><img width="20px" height="20px" src="{{ asset('images/like.png') }}" alt="like">    Like</div>
            <div class="col-sm-4 text-center border-right comment-post"><img width="20px" height="20px" src="{{ asset('images/comment.png') }}" alt="comment"> Comment</div>
            <div class="col-sm-4 text-center share-post"><img width="20px" height="20px" src="{{ asset('images/share.png') }}" alt="share">    Share</div>
        </div>
    </div>
</div>

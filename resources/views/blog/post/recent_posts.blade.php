<div class="newsletter_main">
    <h1 class="recent_taital">نوشته های اخیر</h1>
    @if (!empty($posts))
        @foreach ($posts as $post)
            <div class="recent_box">
                <a href="{{ url('blog/posts/' . $post->id) }}" class="">
                    <div class="recent_left">
                        <div class="image_6"><img src="{{ asset('upload/images/'.$post->image) }}"></div>
                    </div>
                    <div class="recent_right">
                        <h3 class="consectetur_text">{{ $post->title }}</h3>
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>

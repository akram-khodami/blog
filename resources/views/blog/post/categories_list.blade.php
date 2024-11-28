<div class="newsletter_main">
    <h1 class="recent_taital">دسته بندی ها</h1>
    @if (!empty($categories))
        @foreach ($categories as $category)
            <div class="recent_box">
                <a href="{{ url('blog/category_posts/' . $category->id) }}" class="">
                    <div class="recent_left">
                        <i class="fa fa-image"></i>
                        {{-- <div class="image_6"><img src="{{ Storage::url($category->image) }}"></div> --}}
                    </div>
                    <div class="recent_right">
                        <h3 class="consectetur_text">
                            {{ $category->title }}
                            <span class="badge badge-pill badge-primary">{{ $category->posts_count }}</span>
                        </h3>
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>

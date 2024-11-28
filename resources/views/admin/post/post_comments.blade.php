@if (!empty($comments))
    @foreach ($comments as $comment)
        <div class="card mb-3 mt-1" id="card{{ $comment->id }}">
            <div class="card-body">
                <div class="d-flex flex-start">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="mb-0">
                                <?php
                                $date2 = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($comment->created_at));
                                echo \Morilog\Jalali\CalendarUtils::convertNumbers($date2);
                                ?>
                                {{ $comment->name }}
                            </p>
                            <p class="text-primary fw-bold mb-0">
                                <span class="text-body ms-2">
                                    {{ $comment->content }}
                                </span>
                            </p>

                        </div>
                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex flex-row align-items-center">

                                <a href="#!" class="btn" title="حذف نظر"
                                    onclick="deleteComment({{ $comment->id }})">
                                    <i class="fa fa-trash-alt ms-2 text-danger"></i>
                                </a>

                                @if ($comment->confirmed != 1)
                                    <a href="#!" class="btn" title="تایید نظر" id="confirmed{{ $comment->id }}"
                                        onclick="confirmComment({{ $comment->id }})">
                                        <i class="far fa-check-circle text-success"></i>
                                    </a>
                                @endif

                                @if ($comment->user_id != Auth::id())
                                    <a href="#!" class="btn" title="پاسخ نظر"
                                        onclick="reply_comment({{ $comment->id }})">
                                        <i class="fas fa-reply ms-2"></i>
                                    </a>
                                @else
                                    <a href="#!" class="btn" title="پاسخ نظر"
                                        onclick="delete_comment({{ $comment->id }})">
                                        <i class="fas fa-pencil-alt ms-2 text-warning"></i>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
{{ $comments->links() }}

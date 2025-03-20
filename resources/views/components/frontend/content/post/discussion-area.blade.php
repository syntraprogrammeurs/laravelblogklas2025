<section class="gazette-post-discussion-area section_padding_100 bg-gray" x-data="{ activeReply: null }">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <!-- Comment Area Start -->
                <div class="comment_area section_padding_50 clearfix">
                    <div class="gazette-heading">
                        <h4 class="font-bold">Discussion</h4>
                    </div>

                    <ol class="comments-list">
                        @foreach($post->comments()
                            ->whereNull('parent_id')
                            ->with([
                                'user',
                                'children' => function($query) {
                                    $query->orderBy('created_at', 'desc');
                                },
                                'children.user',
                                'children.parent.user',
                                'children.children' => function($query) {
                                    $query->orderBy('created_at', 'desc');
                                },
                                'children.children.user',
                                'children.children.parent.user'
                            ])
                            ->orderBy('created_at', 'desc')
                            ->get() as $index => $comment)
                            <!-- Single Comment Area -->
                            <li class="single_comment_area parent-comment thread-color-{{ ($index % 5) + 1 }}">
                                <div class="comment-wrapper d-md-flex align-items-start">
                                    <!-- Comment Content -->
                                    <div class="comment-content">
                                        <div class="d-flex flex-column">
                                            <h5 class="mb-1">{{ $comment->user->name }}</h5>
                                            <span class="comment-date font-pt text-muted small">{{ $comment->created_at->format('F d, Y') }}</span>
                                        </div>
                                        <p class="mt-2">{{ $comment->body }}</p>
                                        @if(auth()->check() && auth()->id() !== $comment->user_id)
                                            <button 
                                                @click="activeReply = activeReply === {{ $comment->id }} ? null : {{ $comment->id }}"
                                                class="reply-btn"
                                            >
                                                Reply <i class="fa fa-reply" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Reply Form -->
                                <div x-show="activeReply === {{ $comment->id }}" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="reply-form mt-3 mb-4">
                                    <form action="{{ route('comments.store', $post) }}" method="post" class="bg-light p-3 rounded border">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="form-group">
                                            <textarea 
                                                class="form-control @error('body') is-invalid @enderror" 
                                                name="body" 
                                                rows="3" 
                                                placeholder="Write your reply..." 
                                                required
                                            >{{ old('body') }}</textarea>
                                            @error('body')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <button 
                                                type="button" 
                                                @click="activeReply = null"
                                                class="btn btn-secondary btn-sm"
                                            >
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Submit Reply
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @if($comment->children->count() > 0)
                                    <ol class="children">
                                        @foreach($comment->children as $reply)
                                            <li class="single_comment_area thread-color-{{ ($index % 5) + 1 }}">
                                                <div class="comment-wrapper d-md-flex align-items-start">
                                                    <!-- Comment Content -->
                                                    <div class="comment-content">
                                                        <div class="d-flex flex-column">
                                                            <h5 class="mb-1">{{ $reply->user->name }}</h5>
                                                            <span class="comment-date text-muted small">{{ $reply->created_at->format('F d, Y') }}</span>
                                                        </div>
                                                        <div class="text-muted small mb-2">
                                                            {{ $reply->user->name }} replied to {{ $reply->parent->user->name }}
                                                        </div>
                                                        <p class="mt-2">{{ $reply->body }}</p>
                                                        <div class="d-flex align-items-center gap-2 mt-2">
                                                            @if(auth()->check() && auth()->id() !== $reply->user_id)
                                                                <button 
                                                                    @click="activeReply = activeReply === {{ $reply->id }} ? null : {{ $reply->id }}"
                                                                    class="reply-btn text-muted small"
                                                                >
                                                                    <i class="fa fa-reply"></i> Reply to {{ $reply->user->name }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Reply Form for Child Comments -->
                                                <div x-show="activeReply === {{ $reply->id }}" 
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 transform scale-95"
                                                     x-transition:enter-end="opacity-100 transform scale-100"
                                                     x-transition:leave="transition ease-in duration-150"
                                                     x-transition:leave-start="opacity-100 transform scale-100"
                                                     x-transition:leave-end="opacity-0 transform scale-95"
                                                     class="reply-form mt-3 mb-4">
                                                    <form action="{{ route('comments.store', $post) }}" method="post" class="bg-light p-3 rounded border">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                                        <div class="form-group">
                                                            <textarea 
                                                                class="form-control @error('body') is-invalid @enderror" 
                                                                name="body" 
                                                                rows="3" 
                                                                placeholder="Write your reply..." 
                                                                required
                                                            >{{ old('body') }}</textarea>
                                                            @error('body')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-3">
                                                            <button 
                                                                type="button" 
                                                                @click="activeReply = null"
                                                                class="btn btn-secondary btn-sm"
                                                            >
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Submit Reply
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                @if($reply->children->count() > 0)
                                                    <ol class="children">
                                                        @foreach($reply->children as $nestedReply)
                                                            <li class="single_comment_area thread-color-{{ ($index % 5) + 1 }}">
                                                                <div class="comment-wrapper d-md-flex align-items-start">
                                                                    <!-- Comment Content -->
                                                                    <div class="comment-content">
                                                                        <div class="d-flex flex-column">
                                                                            <h5 class="mb-1">{{ $nestedReply->user->name }}</h5>
                                                                            <span class="comment-date text-muted small">{{ $nestedReply->created_at->format('F d, Y') }}</span>
                                                                        </div>
                                                                        <div class="text-muted small mb-2">
                                                                            {{ $nestedReply->user->name }} replied to {{ $nestedReply->parent->user->name }}
                                                                        </div>
                                                                        <p class="mt-2">{{ $nestedReply->body }}</p>
                                                                        <div class="d-flex align-items-center gap-2 mt-2">
                                                                            @if(auth()->check() && auth()->id() !== $nestedReply->user_id)
                                                                                <button 
                                                                                    @click="activeReply = activeReply === {{ $nestedReply->id }} ? null : {{ $nestedReply->id }}"
                                                                                    class="reply-btn text-muted small"
                                                                                >
                                                                                    <i class="fa fa-reply"></i> Reply to {{ $nestedReply->user->name }}
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Reply Form for Nested Comments -->
                                                                <div x-show="activeReply === {{ $nestedReply->id }}" 
                                                                     x-transition:enter="transition ease-out duration-200"
                                                                     x-transition:enter-start="opacity-0 transform scale-95"
                                                                     x-transition:enter-end="opacity-100 transform scale-100"
                                                                     x-transition:leave="transition ease-in duration-150"
                                                                     x-transition:leave-start="opacity-100 transform scale-100"
                                                                     x-transition:leave-end="opacity-0 transform scale-95"
                                                                     class="reply-form mt-3 mb-4">
                                                                    <form action="{{ route('comments.store', $post) }}" method="post" class="bg-light p-3 rounded border">
                                                                        @csrf
                                                                        <input type="hidden" name="parent_id" value="{{ $nestedReply->id }}">
                                                                        <div class="form-group">
                                                                            <textarea 
                                                                                class="form-control @error('body') is-invalid @enderror" 
                                                                                name="body" 
                                                                                rows="3" 
                                                                                placeholder="Write your reply..." 
                                                                                required
                                                                            >{{ old('body') }}</textarea>
                                                                            @error('body')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mt-3">
                                                                            <button 
                                                                                type="button" 
                                                                                @click="activeReply = null"
                                                                                class="btn btn-secondary btn-sm"
                                                                            >
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                                Submit Reply
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
                <!-- Leave A Comment -->
                <div class="leave-comment-area clearfix">
                    <div class="comment-form">
                        <div class="gazette-heading">
                            <h4 class="font-bold">leave a comment</h4>
                        </div>
                        <!-- Comment Form -->
                        <form action="{{ route('comments.store', $post) }}" method="post" id="commentForm" class="bg-light p-4 rounded border">
                            @csrf
                            <div class="form-group">
                                <textarea 
                                    class="form-control @error('body') is-invalid @enderror" 
                                    name="body" 
                                    cols="30" 
                                    rows="10" 
                                    placeholder="Message" 
                                    required
                                >{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">SUBMIT <i class="fa fa-angle-right ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.comments-list {
    list-style: none;
    padding-left: 0;
}

.comments-list .children {
    list-style: none;
    padding-left: 2rem;
    border-left: 2px dashed #e9ecef;
    margin-left: 1rem;
    position: relative;
}

/* Thread colors */
.thread-color-1 { --thread-color: #FF6B6B; }
.thread-color-2 { --thread-color: #4ECDC4; }
.thread-color-3 { --thread-color: #45B7D1; }
.thread-color-4 { --thread-color: #96CEB4; }
.thread-color-5 { --thread-color: #FFEEAD; }

.single_comment_area {
    margin-bottom: 2rem;
    position: relative;
}

.children {
    border-left-color: var(--thread-color) !important;
    border-left-style: dashed;
    opacity: 0.7;
}

.single_comment_area:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -1rem;
    width: 100%;
    height: 1px;
    background: #e9ecef;
}

.comment-wrapper {
    background: #fff;
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    border-left: 3px solid var(--thread-color);
}

.comment-author img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-content {
    flex: 1;
}

.reply-btn {
    background: none;
    border: none;
    color: #007bff;
    padding: 0;
    font-size: 0.9rem;
    cursor: pointer;
    transition: color 0.2s;
}

.reply-btn:hover {
    color: #0056b3;
}

.reply-form {
    margin-left: 3rem;
}

.form-control {
    border: 1px solid #e9ecef;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

@media (max-width: 768px) {
    .comments-list .children {
        padding-left: 1rem;
    }
    
    .reply-form {
        margin-left: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const replyButtons = document.querySelectorAll('.reply-btn');
    const commentForm = document.getElementById('commentForm');
    const parentIdInput = document.getElementById('parent_id');
    const messageTextarea = document.getElementById('message');

    replyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const commentId = this.dataset.commentId;
            parentIdInput.value = commentId;
            messageTextarea.focus();
            messageTextarea.scrollIntoView({ behavior: 'smooth' });
        });
    });
});
</script>
@endpush

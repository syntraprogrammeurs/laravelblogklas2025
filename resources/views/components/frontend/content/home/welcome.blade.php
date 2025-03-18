<section class="welcome-blog-post-slide owl-carousel">
    @foreach($breakingNews->shuffle()->take(4) as $news)
        <!-- Single Blog Post -->
        <div class="single-blog-post-slide bg-img background-overlay-5" style="background-image: url({{asset('assets/frontend/img/bg-img/1.jpg')}});">
            <!-- Single Blog Post Content -->
            <div class="single-blog-post-content">
                <div class="tags">
                    @foreach($news->categories as $category)
                        <a href="#">
                            {{$category->name}}
                        </a>
                    @endforeach

                </div>
                <h3><a href="#" class="font-pt">{{$news->title}}</a></h3>
                <div class="date">
                    <a href="#">{{$news->created_at->format('M d, Y')}}</a>
                </div>
            </div>
        </div>
    @endforeach


</section>

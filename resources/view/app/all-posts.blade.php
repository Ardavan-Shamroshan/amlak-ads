@extends('app.layouts.app')
@section('head-tag')
    <title>بلاگ</title>
@endsection
@section('content')
    <div class="hero-wrap" style="background-image: url('<?= asset('images/bg_1.jpg') ?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="<?= route('home.index') ?>"> خانه </a></span><span>بلاگ </span>
                    </p>
                    <h1 class="mb-3 bread">بلاگ ها</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row d-flex">
                <?php foreach(paginate($posts, 6) as $post) { ?>
                <div class="col-md-3 d-flex ftco-animate">
                    <div class="blog-entry align-self-stretch">
                        <a href="<?= route('home.posts', [$post->id]) ?>" class="block-20" style="background-image: url(<?= asset($post->image) ?>);">
                        </a>
                        <div class="text mt-3 d-block">
                            <h3 class="heading mt-3">
                                <a href="<?= route('home.posts', [$post->id]) ?>"><?= $post->title ?></a></h3>
                            <div class="meta mb-3">
                                <div>
                                    <a href="<?= route('home.posts', [$post->id]) ?>"><?= \Morilog\Jalali\Jalalian::forge($post->published_at)->format('%B %d، %Y'); ?></a>
                                </div>
                                <div><a href="<?= route('home.posts', [$post->id]) ?>"><?= $post->author() ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?= paginateView($posts, 6) ?>
        </div>
    </section>
@endsection
@section('script')
@endsection

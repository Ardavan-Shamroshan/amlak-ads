@extends('app.layouts.app')
@section('head-tag')
    <title>جستجو</title>
@endsection
@section('content')
    <div class="hero-wrap" style="background-image: url('<?= asset('images/bg_1.jpg') ?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                        <span class="mr-2"><a href="<?= route('home.index') ?>">خانه</a></span>
                        <span class="mr-2"><a href="<?= route('home.allPosts') ?>">جستجو</a></span>
                        <span><?= $post->title ?></span></p>
                    <h1 class="mb-3 bread">جستجو </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">آگهی</span>
                    <h2 class="mb-4"><?= $_GET['search'] ?></h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($ads as $advertise) { ?>
                <div class="col-md-3 ftco-animate">
                    <div class="properties">
                        <a href="<?= route('home.ads', [$advertise->id]) ?>" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url('<?= asset($advertise->image) ?>');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <span class="status <?= $advertise->sell_status == 0 ? 'rent' : 'sale'  ?>"><?= $advertise->sellStatus() ?></span>
                            <div class="d-flex">
                                <div class="one">
                                    <h3>
                                        <a href="<?= route('home.ads', [$advertise->id]) ?>"><?= $advertise->title ?></a>
                                    </h3>
                                    <p><?= $advertise->type() ?></p>
                                </div>
                                <div class="two">
                                    <span class="price"><?= $advertise->amount ?></span>
                                </div>
                            </div>
                            <p><?= substr(html_entity_decode($advertise->description), 0, 63) ?></p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="flaticon-selection mx-1"></i><?= $advertise->area ?></span>
                                <span class="ml-auto"><i class="flaticon-bathtub"></i> <?= $advertise->toilet ?></span>
                                <span><i class="flaticon-bed"></i> <?= $advertise->storeroom ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">بلاگ</span>
                    <h2><?= $_GET['search'] ?></h2>
                </div>
            </div>
            <div class="row d-flex">
                <?php foreach ($posts as $post) { ?>
                <div class="col-md-3 d-flex ftco-animate">
                    <div class="blog-entry align-self-stretch">
                        <a href="<?= route('home.posts', [$post->id]) ?>" class="block-20" style="background-image: url('<?= asset($post->image) ?>')">
                        </a>
                        <div class="text mt-3 d-block">
                            <h3 class="heading mt-3"><a href="#"><?= $post->title ?></a></h3>
                            <div class="meta mb-3">
                                <div>
                                    <a href="#"><?= \Morilog\Jalali\Jalalian::forge($post->published_at)->format('%B %d، %Y'); ?></a>
                                </div>
                                <div><a href="#"><?= $post->author() ?></a></div>
                                <div><a href="#" class="meta-chat"><span class="icon-chat"></span> ۳</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

@endsection
@section('script')
@endsection

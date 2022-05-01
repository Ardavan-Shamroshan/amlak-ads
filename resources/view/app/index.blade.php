@extends('app.layouts.app')
@section('head-tag')
    <title>املاک</title>
@endsection
@section('content')
    <section class="home-slider owl-carousel">
        <?php foreach ($slides as $slide) { ?>
        <div class="slider-item" style="background-image:url('<?= asset($slide->image) ?>');">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-md-end align-items-center justify-content-end">
                    <div class="col-md-6 text p-4 ftco-animate" style="direction: rtl;">
                        <h1 class="mb-3"><?= $slide->title ?></h1>
                        <span class="location d-block mb-3"><i class="icon-my_location"></i><?= $slide->address ?></span>
                        <p><?= html_entity_decode($slide->body) ?></p>
                        <span class="price"><?= $slide->amount ?></span>
                        <a href="<?= $slide->url ?>" class="btn-custom p-3 px-4 bg-primary"><span
                                class="icon-plus mr-1"></span> مشاهده جزئیات</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </section>
    <section class="ftco-search">
        <div class="container">
            <div class="row">
                <div class="col-md-12 search-wrap">
                    <h2 class="heading h5 d-flex align-items-center pr-4"><span class="ion-ios-search mr-3"></span>جستوجو
                    </h2>
                    <form action="<?= route('home.search') ?>" method="GET" class="search-property">
                        <div class="row">
                            <div class="col-md align-items-end">
                                <div class="form-group">
                                    <label for="#">عنوان اگهی</label>
                                    <div class="form-field">
                                        <div class="icon"><span class="icon-pencil "></span></div>
                                        <input type="text" name="search" class="form-control text-right"
                                            placeholder="عنوان">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md align-self-end">
                                <div class="form-group">
                                    <div class="form-field">
                                        <input type="submit" value="جستوجو" class="form-control btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon"><span class="flaticon-pin"></span></div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">پیدا کردن خانه در هرجای </h3>
                            <p>به راحتی در هرجای ایران خانه موردنظر خود را انتخاب کنید</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon"><span class="flaticon-detective"></span></div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">نمایندگان فعال</h3>
                            <p>نمایندگان فعال در سراسر کشور</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-sel Searchf-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon"><span class="flaticon-house"></span></div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">خرید و یا اجاره</h3>
                            <p>دسته بندی جدا خانه های خریدنی و یا اجاره کردنی</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon"><span class="flaticon-purse"></span></div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">دو سر سود</h3>
                            <p>منفعت برای خریدار و فروشنده</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-properties">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">اخرین پست ها</span>
                    <h2 class="mb-4">اخرین اگهی ها</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="properties-slider owl-carousel ftco-animate">
                        <?php foreach ($newestAds as $advertise) { ?>
                        <div class="item">
                            <div class="properties">
                                <a href="<?= route('home.ads', [$advertise->id]) ?>"
                                    class="img d-flex justify-content-center align-items-center"
                                    style="background-image: url('<?= asset($advertise->image) ?>');">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                                </a>
                                <div class="text p-3">
                                    <span
                                        class="status <?= $advertise->sellStatus() == 'اجاره' ? 'rent' : 'sale' ?>"><?= $advertise->sellStatus() ?></span>
                                    <div class="d-flex">
                                        <div class="one">
                                            <h3>
                                                <a
                                                    href="<?= route('home.ads', [$advertise->id]) ?>"><?= $advertise->title ?></a>
                                            </h3>
                                            <p><?= $advertise->type() ?></p>
                                        </div>
                                        <div class="two">
                                            <span class="price"><?= $advertise->amount ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">پیشنهادات ویژه</span>
                    <h2 class="mb-4">بهترین اگهی ها</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($bestAds as $advertise) { ?>
                <div class="col-sm-8 col-md-6 col-lg ftco-animate">
                    <div class="properties">
                        <a href="<?= route('home.ads', [$advertise->id]) ?>"
                            class="img img-2 d-flex justify-content-center align-items-center"
                            style="background-image: url('<?= asset($advertise->image) ?>');">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="icon-search2"></span>
                            </div>
                        </a>
                        <div class="text p-3">
                            <span
                                class="status <?= $advertise->sell_status == 0 ? 'sale' : 'rent' ?>"><?= $advertise->sellStatus() ?></span>
                            <div class="d-flex">
                                <div class="one">
                                    <small>
                                        <a href="<?= route('home.ads', [$advertise->id]) ?>"><?= $advertise->title ?></a>
                                    </small>
                                    <small><?= $advertise->type() ?></small>
                                </div>
                                <div class="two">
                                    <span class="price"><?= $advertise->amount ?></span>
                                </div>
                            </div>
                            <p><?= substr(html_entity_decode($advertise->description), 0, 100) ?></p>
                            <hr>
                            <p class="bottom-area d-flex">
                                <span><i class="flaticon-selection mx-1"></i><?= $advertise->area ?></span>
                                <span class="ml-auto"><i class="flaticon-bathtub"></i>
                                    <?= $advertise->toilet ?></span>
                                <span><i class="flaticon-bed"></i> <?= $advertise->storeroom ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-counter img" id="section-counter"
        style="background-image: url('<?= asset('images/bg_1.jpg') ?>');">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                    <h2 class="mb-4">برخی اطلاعات جالب</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="<?= $postsCount ?>">0</strong>
                                    <span>مشتریان خوشحال</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="<?= $adsCount ?>">0</strong>
                                    <span>آگهی ها</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="<?= $usersCount ?>">0</strong>
                                    <span>نمایندگان</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="<?= $sumArea ?>">0</strong>
                                    <span>متراژ کلی </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">مقالات</span>
                    <h2>آخرین بلاگ ها</h2>
                </div>
            </div>
            <div class="row d-flex">
                <?php foreach ($posts as $post) { ?>
                <div class="col-md-3 d-flex ftco-animate">
                    <div class="blog-entry align-self-stretch">
                        <a href="<?= route('home.posts', [$post->id]) ?>" class="block-20"
                            style="background-image: url('<?= asset($post->image) ?>')">
                        </a>
                        <div class="text mt-3 d-block">
                            <h3 class="heading smt-3"><a
                                    href="<?= route('home.posts', [$post->id]) ?>"><?= $post->title ?></a></h3>
                            <div class="meta mb-3">
                                <div>
                                    <a
                                        href="#"><?= \Morilog\Jalali\Jalalian::forge($post->published_at)->format('%B %d، %Y') ?></a>
                                </div>
                                <div><a href="#"><?= $post->author() ?></a></div>
                                <div><a href="#" class="meta-chat"><span class="icon-chat"></span>3</a></div>
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
    <script>
        $(window).on('load', function() {
            $.ajax({
                url: "<?= route('home.last.posts') ?>",
                success: function(result) {
                    posts = result;
                    var htmlString = '';
                    for (var i = 0; i < posts.length; i++) {
                        var post = posts[i];
                        htmlString += '<div class="col-md-3 d-flex fadeIn ftco-animated">';
                        htmlString += '<div class="blog-entry align-self-sm-stretch">';
                        htmlString += '<a href="' + post.url +
                            '" class="block-20" style="background-image: url(' + post.image + ');">';
                        htmlString += '</a>';
                        htmlString += '<div class="text mt-3 d-block">';
                        htmlString += '<h3 class="heading mt-3"><a href="' + post.url + '">' + post
                            .title + '</a></h3>';
                        htmlString += '<div class="meta mb-3">';
                        htmlString += '<div>' + post.created_at + '</div>';
                        htmlString += '<div>' + post.user + '</div>';
                        htmlString += '</div>';
                        htmlString += '</div>';
                        htmlString += '</div>';
                        htmlString += '</div>';
                    }
                    $('#last_posts').html(htmlString);
                }
            });
        });
    </script>
@endsection

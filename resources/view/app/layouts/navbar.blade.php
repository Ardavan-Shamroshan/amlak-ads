<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar"
     style="direction: rtl;">
    <div class="container">
        <a class="navbar-brand" href="<?= route('home.index') ?>">Royal<span>estate</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> منو
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= sidebarActive(route('home.index'), false) ?>">
                    <a href="<?= route('home.index') ?>" class="nav-link">خانه</a></li>
                <li class="nav-item <?= sidebarActive(route('home.allAds')) ?>">
                    <a href="<?= route('home.allAds')?>" class="nav-link">آگهی ها</a></li>
                <li class="nav-item <?= sidebarActive(route('home.about')) ?>">
                    <a href="<?= route('home.about') ?>" class="nav-link">درباره ما</a></li>
                <li class="nav-item <?= sidebarActive(route('home.allPosts')) ?>">
                    <a href="<?= route('home.allPosts') ?>" class="nav-link">بلاگ</a></li>
                <?php if(\System\Auth\Auth::checkLogin()) {
                if(\System\Auth\Auth::user()->user_type == 'admin') { ?>
                <li class="nav-item cta">
                    <a href="<?= route('admin.index') ?>" class="nav-link ml-lg-1 mr-lg-5 btn-success">
                        <span class="icon-user m-2"></span>پنل ادمین</a>
                </li>
                <?php } ?>
                <li class="nav-item dropdown dropdown-user">
                    <a href="<?= route('home.index') ?>" class="nav-link dropdown-toggle nav-link dropdown-user-link"
                       href="#" data-toggle="dropdown">
                        <span>
                            <img src="<?= asset(\System\Auth\Auth::user()->avatar) ?>" alt="avatar" height="40"
                                 width="40" style="border-radius: 1.5rem">
                        </span>
                        <?= \System\Auth\Auth::user()->first_name . ' ' . \System\Auth\Auth::user()->last_name ?>
                        <?php if(\System\Auth\Auth::user()->is_active == 1){?>
                        <span class="user-status active small badge text-success">آنلاین </span>
                        <?php } else {?>
                        <span class="user-status active small badge text-danger">آفلاین </span>
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item text-right" href="<?= route('auth.logout') ?>"><i class="feather icon-power"></i>خروج</a>
                    </div>
                </li>

                <?php } else {?>
                <li class="nav-item cta">
                    <a href="<?= route('auth.login.view') ?>" class="nav-link ml-lg-1 mr-lg-5"><span
                                class="icon-user m-2"></span>ورود</a>
                </li>
                <li class="nav-item cta cta-colored">
                    <a href="<?= route('auth.register.view') ?>" class="nav-link"><span class="icon-pencil m-2"></span>ثبت
                        نام</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
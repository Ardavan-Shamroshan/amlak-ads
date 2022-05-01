@extends('admin.layouts.app')
@section('head-tag')
    <title>ادمین / نظرات</title>
@endsection
@section('content')
    <div class="content-header row"></div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">نظرات</h4>
                            <span><a href="<?= route("admin.index") ?>" class="btn btn-success disabled">ایجاد</a></span>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="">
                                    <table class="table zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>کاربر</th>
                                            <th>نظر</th>
                                            <th>وضعیت</th>
                                            <th>تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($comments as $comment) { ?>
                                        <tr>
                                            <td><?= $comment->id ?></td>
                                            <td><?= $comment->user()->first_name . ' ' . $comment->user()->last_name ?></td>
                                            <td><?= $comment->comment ?></td>
                                            <td><?= $comment->approved == 0 ? '<span class="text-danger">در انتظار تایید</span>' : '<span class="text-success">تایید شده</class>' ?></td>
                                            <td>
                                                <a href="<?= route('admin.comment.show', [$comment->id]) ?>" class="btn btn-success">نمایش</a>
                                                <?php if($comment->approved == 0) { ?>
                                                <a href="<?= route('admin.comment.approved', [$comment->id]) ?>" class="btn btn-warning">تائید</a>
                                                <?php } else { ?>
                                                <a href="<?= route('admin.comment.approved', [$comment->id]) ?>" class="btn btn-danger">لغو
                                                    تایید</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Zero configuration table -->
    </div>
@endsection
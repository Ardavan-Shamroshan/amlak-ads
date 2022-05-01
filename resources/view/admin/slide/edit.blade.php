@extends('admin.layouts.app')



@section('head-tag')
    <title>ادمین / اسلایدشو</title>
@endsection



@section('content')
    <div class="content-header row">

    </div>
    <div class="content-body">

        <!-- Zero configuration table -->
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اسلایدشو</h4>
                            <span><a href="<?= route("admin.slide.index") ?>" class="btn btn-success">بازگشت</a></span>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">

                                <form class="row" action="<?= route("admin.slide.update", ['id' => $slide->id]) ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="put">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="title">عنوان</label>
                                            <input name="title" type="text" id="title"  value="<?= oldOrValue('title', $slide->title) ?>" class="form-control" placeholder="عنوان ...">
                                            <?= errorText('title') ?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="url">لینک</label>
                                            <input name="url" type="text" id="url" value="<?= oldOrValue('url', $slide->url) ?>" class="form-control" placeholder="لینک ...">
                                            <?= errorText('url') ?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="address">آدرس</label>
                                            <input name="address" type="text" id="address"  value="<?= oldOrValue('address', $slide->address) ?>" class="form-control" placeholder="آدرس ...">
                                            <?= errorText('address') ?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="amount">مبلغ</label>
                                            <input name="amount" type="text" id="amount"  value="<?= oldOrValue('amount', $slide->amount) ?>" class="form-control" placeholder="مبلغ ...">
                                            <?= errorText('amount') ?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="image">تصویر</label>
                                            <input name="image" type="file" id="image" class="form-control-file">
                                            <?= errorText('file') ?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-12">
                                        <section class="form-group">
                                            <label for="body">متن</label>
                                            <textarea class="form-control" id="body" rows="5" name="body" placeholder="متن ...">
                                                <?= oldOrValue('body', $slide->body) ?>
                                            </textarea>
                                            <?= errorText('body') ?>
                                        </section>
                                    </div>

                                    <div class="col-md-6">
                                        <section class="form-group">
                                            <button type="submit" class="btn btn-primary">ایجاد</button>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('script')
    <script src="<?= asset('ckeditor/ckeditor.js'); ?>"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'body' );
    </script>
@endsection

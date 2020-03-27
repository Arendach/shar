@extends('layouts.admin')

@section('content')

    <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
               aria-selected="true">Общие</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">Seo</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="layer-tab" data-toggle="tab" href="#layer" role="tab" aria-controls="layer"
               aria-selected="false">Баннер</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="delivery-tab" data-toggle="tab" href="#delivery" role="tab" aria-controls="delivery"
               aria-selected="false">Условия доставки</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="sms-tab" data-toggle="tab" href="#sms" role="tab" aria-controls="sms"
               aria-selected="false">Смс</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab" aria-controls="feedback"
               aria-selected="false">Обратная связь</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
               aria-selected="false">Остальное</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent" style="margin-top: 15px;">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <?php $section = 'main'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <?php $section = 'seo'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>

        <div class="tab-pane fade" id="layer" role="tabpanel" aria-labelledby="layer-tab">
            @include('admin.settings.layer')
        </div>

        <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
            <?php $section = 'delivery'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>

        <div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="sms-tab">
            <?php $section = 'sms'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>

        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
            <?php $section = 'feedback'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <?php $section = 'other'; ?>
            <?php $data = Settings::getSection($section) ?>
            @include('admin.settings.parts')
        </div>
    </div>



@endsection

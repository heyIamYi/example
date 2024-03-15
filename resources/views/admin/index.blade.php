@extends('back.template.template')

@section('title')
    {{env('WEBSITE_NAME', '')}}
@endsection

@section('main')
    <div class="rightbox">
        <!-- 歡迎頁面 -->
        <div class="welcome-page">
            <img src="{{ asset('./images/back-img/welcome.jpg') }}" alt="歡迎頁面" />
        </div>
    </div>
@endsection

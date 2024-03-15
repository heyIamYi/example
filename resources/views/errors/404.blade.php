@extends('cathayrun.template.template')

@section('main')
    <main>
        <div class="pg-grid">
            <section class="frame">
                <div class="error-row">
                    <div class="img-box">
                        <img src="{{ asset('images/error-pc.svg') }}" alt>
                        <p class="error-code">404</p>
                    </div>
                    <div class="content">
                        <p class="title">很抱歉，我們無法找到您所尋找的頁面。</p>
                        <div class="des">
                            <p>這可能是因為頁面已經被移除、頁面暫時無法使用，或者您輸入的網址有誤。</p>
                            <p>請檢查您輸入的網址是否正確，確保沒有拼寫錯誤或者多餘的符號。</p>
                            <p>如果您有其他疑問或問題，請不吝與我們聯繫，讓我們知道問題所在，我們將盡快修復並恢復相應的內容。</p>
                        </div>
                    </div>
                    <div class="btn-row">
                        <a class="link" href="{{route('front.index')}}">GO HOME</a>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ env('WEBSITE_NAME', '') }} - 後台管理登入</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ asset('Admin/css/login/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('Admin/css/login/login.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="box">
        <div class="boxin">
            <div class="iconfwebadmintitle">Welcome</div>
            <div class="iconfwebadmintitle">
                <p>{{ env('WEBSITE_NAME', '') }}</p>
            </div>
            <div id="mianbox">
                <div class="txt"></div>

                <form action="{{ route('admin.login.post') }}" method="POST" style="margin:0px;padding:0px;"
                    onsubmit="return check();">

                    @if ($errors->any())
                        <div class="alert alert-danger" style="color: red;">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @csrf

                    {{-- 帳號 --}}
                    <div class="contentbox">
                        <div class="inputset">
                            <div class="titlebox"></div>
                            <div class="inputbox"><input name="name" id="name" type="text"
                                    placeholder="帳號/ID" /></div>
                            <div class="clear"></div>
                        </div>

                        {{-- 密碼 --}}
                        <div class="inputset">
                            <div class="titlebox titlebox2"></div>
                            <div class="inputbox"><input name="password" id="password" type="password"
                                    placeholder="密碼/Password" /></div>
                            <div class="clear"></div>
                        </div>

                        {{-- 驗證碼 --}}
                        <div class="inputset">
                            <div class="titlebox titlebox3"></div>
                            <div class="inputbox02">
                                <input name="verifycode" id="verifycode" type="text" placeholder="驗證碼/Verify Code"
                                    autocomplete="off" />
                                <div>
                                    <img src="{{ captcha_src() }}" id="rand-img" alt="驗證碼" title="驗證碼"
                                        onclick="this.src='/captcha/default?'+Math.random()" />
                                </div>
                                <div id="reload-img">
                                    <img src="{{ asset('images/back-img/reload.png') }}" border=0 alt="重新載入"
                                        title="重新載入" style="cursor:pointer"
                                        onclick="document.getElementById('rand-img').src='/captcha/default?'+Math.random()" />
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div>
                            <span class="inputbox03"><input name="" type="submit" value="Sign In" /></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </form>
                <div class="iconffooter">系統維護 <img src="{{ asset('/images/back-img/logo-bw.png') }}" height="25"
                        alt="iware" title="iware" style="vertical-align: bottom;height: 21px;"></div>
            </div>
        </div>
    </div>


</body>


</html>

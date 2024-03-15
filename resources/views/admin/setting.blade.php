@extends('back.template.template')
@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $header }}列表
                </h1>
            </div>

            <div class="result-list">
                <table class="setting">
                    <thead>
                        <tr>
                            <th width="300" colspan="7">參數管理</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="/WebAdmin/setting" method="post">
                            @csrf
                            <tr id="row_{{ $data->id }}">
                                <td width="300">網站流量分析代碼
                                    (Google Analytics Code)：</td>
                                <td  colspan="4">
                                    登入您的 <a
                                        onclick="window.open('http://www.google.com/analytics/');"><u>Google流量分析帳戶</u></a>
                                    建立您的網站分析代碼後黏貼至此.<br>
                                    <textarea name="value" rows="5" cols="70">{{$data->value}}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td >
                                    <button>
                                        儲存
                                    </button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

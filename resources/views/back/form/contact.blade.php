@extends('back.template.template')

@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $header }}
                </h1>
            </div>
            {{-- <div class="search">
                <a href="{{ $storeLink }}" class="add-button" style="margin:5px;">
                    新增資料
                </a>
            </div> --}}
            <div class="edit-list">
                <table>
                    <thead>
                        <tr>
                            <th class="title ps-2" scope="col" colspan="2" width="140">聯絡我們資料</th>
                            <th class="title w-100 " scope="col" colspan="6">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                <form action="{{ $storeLink }}" method="post">
                    @csrf
                    <table>
                        <tbody>
                            <tr>
                                <td>姓名</td>
                                <td>
                                    {{ $data->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>E-mail：</td>
                                <td>
                                    {{ $data->email }}
                                </td>
                            </tr>
                            <tr>
                                <td>電話：</td>
                                <td>
                                    {{ $data->tel }}
                                </td>
                            </tr>
                            <tr style="height: 100px;">
                                <td style="height: 100px;">說明內容：</td>
                                <td style="height: 100px;">
                                    {{ $data->content }}
                                </td>
                            </tr>
                            <tr>
                                <td>聯絡時間：</td>
                                <td>
                                    {{ $data->created_at }}
                                </td>
                            </tr>
                            <tr>
                                <td>處理狀態：</td>
                                <td>
                                    <label for="">
                                        <input type="radio" name="state" value="1"
                                            @if ($data->state == 1) checked @endif>是
                                    </label>
                                    <label for="">
                                        <input type="radio" name="state" value="0"
                                            @if ($data->state == 0) checked @endif>否
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>備註</td>
                                <td>
                                    <textarea style="min-height: 80px;" name="remark" cols="100" rows="8">{{ $data->remark }}</textarea>
                                </td>
                            </tr>

                            <tr class="last-tr">
                                <td></td>
                                <td><input class="sub2" type="submit" value="確認"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection

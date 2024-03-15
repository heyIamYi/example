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
                            <th class="title ps-2" scope="col" colspan="2" width="140">聯絡資訊資料</th>
                            <th class="title w-100 " scope="col" colspan="6">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                <form action="{{ $storeLink }}" method="post">
                    @csrf
                    <table>
                        <tbody>
                            <tr>
                                <td>名稱(前臺不會顯示)</td>
                                <td>
                                    <input type="text" name="name" value="">
                                </td>
                            </tr>

                            <tr>
                                <td>E-mail：</td>
                                <td>
                                    <input type="text" name="email" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>排序：</td>
                                <td>
                                    <input colspan="7" size="4" autocomplete="off" type="text" name="sort"
                                        {{ isset($data) ? 'value=' . $data->sort . '' : 'value=100' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>是否啟用：</td>
                                <td class="is-show">
                                    <label>
                                        <input colspan="7" value="1" name="is_show" type="radio"
                                            {{ (isset($data) && $data->is_show == 1) || !isset($data) ? 'CHECKED' : '' }}>是
                                    </label>
                                    <label>
                                        <input colspan="7" value="0" name="is_show" type="radio"
                                            {{ isset($data) && $data->is_show == 0 ? 'CHECKED' : '' }}>否
                                    </label>
                                </td>
                            </tr>
                            <tr class="last-tr">
                                <td></td>
                                <td><input class="sub2" type="submit" value="送出表單">
                                </td>
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

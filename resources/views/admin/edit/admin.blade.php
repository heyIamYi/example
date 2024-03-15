@extends('back.template.template')

@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ isset($data) ? '修改' . $header : '新增' . $header }}
                </h1>
            </div>
            <div class="edit-list">
                <table>
                    <thead>
                        <tr>
                            <th class="title ps-2" scope="col" colspan="2" width="140">使用者資料</th>
                            <th class="title w-100 " scope="col" colspan="6">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                @if (isset($data))
                    <form action="{{ route('admin.create', ['id' => $data->id]) }}" method="post"
                        enctype="multipart/form-data">
                    @else
                        <form action="{{ route('admin.create') }}" method="post" enctype="multipart/form-data">
                @endif
                @csrf
                <table>
                    <tbody>
                        @if (session('error'))
                            <tr>
                                <td colspan="7">
                                    <div style="color: red;">
                                        {{ session('error') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>使用者群組：</td>
                            <td>
                                <select name="group_id" id="group_id">
                                    <option value="">請選擇使用者群組</option>
                                    @foreach ($groups as $group)
                                        <option
                                            {{ isset($data->group_id) && $data->group_id == $group->id ? 'selected' : '' }}
                                            value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>使用者帳號：</td>
                            <td>
                                <input pattern="[A-Za-z0-9]+" title="請輸入英文或數字" name="name" id="name"
                                    value="{{ isset($data->name) ? $data->name : '' }}">
                            </td>
                        </tr>

                        <tr>
                            <td>使用者名稱：</td>
                            <td>
                                <input name="username" id="username"
                                    value="{{ isset($data->username) ? $data->username : '' }}">
                            </td>
                        </tr>
                        @if (isset($data))
                            <tr>
                                <td>請輸入舊密碼</td>
                                <td>
                                    <input type="password" name="oldPassword" id="oldPassword" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>請輸入新密碼：
                                </td>
                                <td>
                                    <input type="password" name="password" minlength="8" pattern="[A-Za-z0-9]+"
                                        title="請輸入英文或數字" id="password" value="">
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>使用者密碼：</td>
                                <td>
                                    <input type="password" name="password" minlength="8" pattern="[A-Za-z0-9]+"
                                        title="請輸入英文或數字" id="password" value="">
                                </td>
                            </tr>

                            <tr>
                                <td>確認使用者密碼：
                                </td>
                                <td>
                                    <input type="password" name="checkPassword" minlength="8" pattern="[A-Za-z0-9]+"
                                        title="請輸入英文或數字" id="password" value="">
                        @endif
                        </td>
                        </tr>

                        <tr>
                            <td>使用者信箱：
                            </td>
                            <td>
                                <input name="email" type="email" id="email"
                                    value="{{ isset($data->email) ? $data->email : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>是否啟用：</td>
                            <td class="is-show">
                                <label>
                                    <input colspan="7" value="1" name="is_show" type="radio"
                                        {{ !isset($data->is_show) || $data->is_show == 1 ? 'checked' : '' }}>是
                                </label>
                                <label>
                                    <input colspan="7" value="0" name="is_show" type="radio"
                                        {{ isset($data->is_show) && $data->is_show == 0 ? 'checked' : '' }}>否
                                </label>
                            </td>
                        </tr>
                        <tr class="last-tr">
                            <td></td>
                            <td><input class="sub2" type="submit" value="送出表單" onclick="showSuccessEditAlert()"></td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
@endsection

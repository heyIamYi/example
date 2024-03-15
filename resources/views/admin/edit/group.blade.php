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
                <a href="{{ $createLink }}" class="add-button" style="margin:5px;">
                    新增資料
                </a>
            </div> --}}
            <div class="edit-list">
                <table>
                    <thead>
                        <tr>
                            <th class="title ps-2" scope="col" colspan="2" width="140">群組資料</th>
                            <th class="title w-100 " scope="col" colspan="6">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                <form action="/WebAdmin/user-group/{{$data->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <table>
                        <tbody>
                            <tr>
                                <td>群組名稱：</td>
                                <td>
                                    <input name="name" id="name" value="{{ $data->name }}">
                                </td>
                            </tr>

                            {{-- <tr>
                                <td>是否啟用：</td>
                                <td class="is-show">
                                    <label>
                                        <input colspan="7" value="1" name="is_show" type="radio" {{ $data->is_show == 1 ? 'checked' : '' }}>是
                                    </label>
                                    <label>
                                        <input colspan="7" value="0" name="is_show" type="radio" {{ $data->is_show == 0 ? 'checked' : '' }}>否
                                    </label>
                                </td>

                            </tr> --}}
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

@section('js')
@endsection

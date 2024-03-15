@extends('back.template.template')
@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $header }}列表
                </h1>
            </div>
            <div class="search">
                {{-- <a href="{{ $createLink }}" class="add-button" style="margin:5px;">
                    新增資料
                </a> --}}
                <select name="group" id="user-group">
                    <option value="">請選擇</option>
                    @foreach ($userGroups as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="300">選單</th>
                            <th width="80">列表</th>
                            <th width="80">新增</th>
                            <th width="80">修改</th>
                            <th width="80">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>{{ $list->name }}</td>
                                <td>
                                    @if ($list->slist == 1 && $list->link != null)
                                        <input type="checkbox" name="slist" checked>
                                    @elseif ($list->slist == 0 && $list->link != null)
                                        <input type="checkbox" name="slist">
                                    @endif
                                </td>
                                <td>
                                    @if ($list->sadd == 1 && $list->link != null)
                                        <input type="checkbox" name="sadd" checked>
                                    @elseif ($list->sadd == 0 && $list->link != null)
                                        <input type="checkbox" name="sadd">
                                    @endif
                                </td>
                                <td>
                                    @if ($list->sedit == 1 && $list->link != null)
                                        <input type="checkbox" name="sedit" checked>
                                    @elseif ($list->sedit == 0 && $list->link != null)
                                        <input type="checkbox" name="sedit">
                                    @endif
                                </td>
                                <td>
                                    @if ($list->sdelete == 1 && $list->link != null)
                                        <input type="checkbox" name="sdelete"checked>
                                    @elseif ($list->sdelete == 0 && $list->link != null)
                                        <input type="checkbox" name="sdelete">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

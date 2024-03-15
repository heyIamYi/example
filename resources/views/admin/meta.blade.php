@extends('back.template.template')
@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $header }}列表
                </h1>
            </div>
            {{-- <div class="search">
                <a href="" class="add-button" style="margin:5px;">
                    新增資料
                </a>
            </div> --}}
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="300">標題</th>
                            <th width="120">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr id="row_{{ $data->id }}">
                                <td width="300">{{ $data->title }}</td>
                                <td >
                                    <a href="{{route('admin.meta.show', ['id'=>$data->id])}}"
                                        style="text-decoration: none;color:blue;"
                                        >編輯</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

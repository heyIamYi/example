@extends('back.template.template')
@php
    $is_status = request()->input('is_status') ?? '';
@endphp
@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $header }}列表
                </h1>
            </div>
            <div class="search">
                <div class="search-bar">
                    <input type="text" id="keyword" placeholder="搜尋姓名"
                        value="@if (isset($keyword)){{ $keyword ?? '' }}@endif">
                    <select id="is_status">
                        <option value="" @if ($is_status === '') selected @endif>處理情況</option>
                        <option value="1" @if ($is_status === '1') selected @endif>已處理</option>
                        <option value="0" @if ($is_status === '0') selected @endif>未處理</option>
                    </select>
                    <button type="submit" onclick="search()">搜索</button>
                </div>
            </div>
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="70">姓名</th>
                            <th width="70">電話</th>
                            <th width="70">信箱</th>
                            <th width="70">內容</th>
                            <th width="50">處理狀態</th>
                            <th width="50">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr id="row_{{ $data->id }}">
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->tel }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->content }}</td>
                                @if ($data->state == 0)
                                    <td style="color:red;">
                                        未處理
                                    </td>
                                @elseif ($data->state == 1)
                                    <td style="color:blue;">
                                        已處理
                                    </td>
                                @endif

                                <td class="operate">
                                    <a href="{{ route('form.contact', ['id' => $data->id]) }}">查看</a>
                                    @if (isset($permCheck))
                                        @if ($permCheck->d_tag == 1)
                                            | <a href="javascript:void(0)"
                                                onclick="deleteData('{{ $deleteLink }}','{{ $data->id }}'); event.preventDefault();">
                                                刪除
                                            </a>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

                {{-- 筆數連結 --}}
                @if (isset($datas) && !empty($datas))
                {{ $datas->links('back.partials.pagination', ['datas' => $datas]) }}
                @endisset
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- 頁數轉跳 --}}

<script>
    function jumpToPage(selectedPage) {}
</script>
@endsection

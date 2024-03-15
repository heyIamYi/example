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
                @if (isset($permCheck))
                    @if ($permCheck->a_tag == 1)
                        <a href="{{ $formLink }}" class="add-button" style="margin:5px;">
                            新增資料
                        </a>
                    @endif
                @endif
            </div>
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="70">名稱</th>
                            <th >信箱</th>
                            <th width="70">排序</th>
                            <th width="80">是否啟用</th>
                            <th width="50">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($datas))
                            @foreach ($datas as $data)
                                <tr id="row_{{ $data->id }}">
                                    <td width="300">{{ $data->name }}</td>
                                    <td>{!! $data->email !!}</td>
                                    <td width="30"><input autocomplete="off" onChange="modifyConfirmation('sort', {{ $data->id }})"
                                            id="sort_{{ $data->id }}" type="number" name="sort"
                                            style="max-width:50px;" value="{{ $data->sort }}">
                                    </td>
                                    <td width="80">
                                        <input onclick="modifyConfirmation('show',{{ $data->id }})" id="show_{{ $data->id }}"
                                            type="checkbox" value="{{ $data->is_show }}"
                                            {{ $data->is_show == 1 ? 'checked' : '' }}>
                                    </td>
                                    @if (isset($permCheck))
                                        <td width="75" class="operate">
                                            @if ($permCheck->e_tag == 1)
                                                <a href="{{ $formLink }}/{{ $data->id }}">
                                                    編輯
                                                </a>
                                                @if ($permCheck->d_tag == 1)
                                                    |
                                                @endif
                                            @endif
                                            @if ($permCheck->d_tag == 1)
                                                <a href="javascript:void(0)"
                                                    onclick="deleteData('{{ $deleteLink }}','{{ $data->id }}'); event.preventDefault();">
                                                    刪除
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
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

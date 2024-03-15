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
                <a href="{{ route('admin.edit.form') }}" class="add-button" style="margin:5px;">
                    新增使用者
                </a>
            </div>
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="300">帳號</th>
                            <th>權限群組</th>
                            <th width="80">是否啟用</th>
                            <th width="120">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr id="row_{{ $data->id }}">
                                <td width="300">{{ $data->name }}</td>
                                <td>
                                    @if (isset($data->group->id))
                                        {{ $data->group->name }}
                                    @endif
                                </td>
                                    @if ($data->id != 1)
                                <td width="80">
                                    <input onclick="modifyConfirmation('show',{{ $data->id }})"
                                        id="show_{{ $data->id }}" type="checkbox" value="{{ $data->is_show }}"
                                        {{ $data->is_show == 1 ? 'checked' : '' }}>
                                </td>
                                    @else
                                <td></td>
                                    @endif
                        </td>
                        <td width="75">
                            <a href="{{ route('admin.edit.form', ['id' => $data->id]) }}"
                                style="text-decoration: none;color:blue;"
                                >
                                編輯
                            </a>
                            @if ($data->id != 1)
                                |
                                <a href="javascript:void(0)"
                                    style="text-decoration: none;color:blue;"
                                    onclick="deleteUser({{ $data->id }}); event.preventDefault();">刪除</a>
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

@section('js')
    <script>
        // 刪除資料的 function
        function deleteUser(id) {
            let oldUrl = '{{ route('admin.destory', ["id"=>'dataId']) }}';
            let url = oldUrl.replace('dataId', id);

            if (!confirm('確定要刪除此資料？')) {
                return;
            } else {
                document.getElementById(`row_${id}`).style.display = 'none';
            }

            fetch(url, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                if (result.status == 200) {
                    console.log(result);
                    alert('刪除成功');
                } else {
                    alert('刪除失敗');
                }
            });
        }
    </script>
@endsection

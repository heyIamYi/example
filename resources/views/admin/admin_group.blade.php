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
                <form action="{{ route('admin.group.create') }}" method="post"
                    style="display: flex; align-items:center; justify-content:center;">
                    @csrf
                    <input type="text" name="name"
					required
                        style="
                        padding: 0 3px;
                    border: 1px solid #cdcdcd;
                    color: #333;
                    height: 26px;
                    margin-right:5px;
                    "
					                    required

                        autocomplete="off">
                    <input type="submit"
                        style="background: #4ebda8;
                    color: white;
                    border: none;
                    padding: 5px 15px;
                    border-radius: 3px;"
                        value="增加">
                    {{-- 錯誤訊息 --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" style=" color:red;">
                            <ul style="margin: 0;display: flex; align-items:center; justify-content:center;">
                                @foreach ($errors->all() as $error)
                                    <li style="list-style: none;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </form>
            </div>
            <div class="result-list">
                <table>
                    <thead>
                        <tr>
                            <th width="300" colspan="2">群組名稱</th>
                            {{-- <th>內容</th> --}}
                            {{-- <th width="80">是否啟用</th> --}}
                            <th width="100" colspan="1">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr id="row_{{ $data->id }}">
                                <td width="300" colspan="2">{{ $data->name }}</td>
                                <td>
                                    @if ($data->id != 1 && Auth::guard('admin')->user()->group_id == 1)
                                        <a href="javascript:void(0)"
                                            style="text-decoration:none;"
                                            onclick="deleteGroup('{{ $data->id }}'); event.preventDefault();">刪除</a>
                                    @else
                                    <span style="color:#0b2640">
                                        無操作
                                    </span>
                                    @endif
                                </td>
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
        function deleteGroup(id) {
            let link = '/WebAdmin/d/admin_group/' + id
            if (!confirm('確定要刪除此資料？')) {
                return;
            } else {
                document.getElementById(`row_${id}`).style.display = 'none';
            }

            fetch(link, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
        }
    </script>

    <script>
        // 新增資料的 function
        function CreateGroup() {
            let docut
            let link = '/WebAdmin/c/user-group/';
            if (!confirm('確定要新增此資料？')) {
                return;
            } else {
                document.getElementById(`row_${id}`).style.display = 'none';
            }

            fetch(link, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
        }
    </script>
@endsection

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
                <select name="group" id="user-group" style="width: 110px;">
                    @foreach ($userGroups as $data)
                        @if (Auth::guard('admin')->user()->group_id != 1)
                            @if ($data->id < Auth::guard('admin')->user()->group_id)
                                @continue;
                            @endif
                            <option value="{{ $data->id }}" @if ($group_id != null && $group_id == $data->id) selected @endif>
                                {{ $data->name }}
                            </option>
                        @else
                            <option value="{{ $data->id }}" @if ($group_id != null && $group_id == $data->id) selected @endif>
                                {{ $data->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="result-list">
                <table class="permission-table">
                    <thead>
                        <tr>
                            <th width="300">選單</th>
                            <th width="80">列表</th>
                            <th width="80">新增</th>
                            <th width="80">修改</th>
                            <th width="80">刪除</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($menusByParent[0] as $key => $parent)
                            <tr>
                                <td @if ($parent->parent_id == 0 && isset($menusByParent[$parent->id])) colspan="6" @endif>

                                    @if ($parent->parent_id == 0 && Auth::guard('admin')->user()->group_id == 1 && $parent->name != '系統管理')
                                        <input type="checkbox" class="select-all" data-perms-id="{{ $parent->original_id }}"
                                            data-parent-id="{{ $parent->id }}">
                                    @endif
                                    {{ $parent->name }}
                                </td>
                                @foreach ($allDatas as $data)
                                    @if ($data->menu_id == $parent->id)
                                        @if (!isset($menusByParent[$parent->id]))
                                            <!-- 如果主選單沒有子層 -->

                                            <!-- 列表 -->
                                            <td>
                                                @if (!is_null($data->s_tag))
                                                    @if ($data->s_tag == 1)
                                                        <input type="checkbox" id="s_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('s_tag', {{ $data->id }}, 0)"
                                                            name="s_tag" value="1" checked>
                                                        <label for="s_tag">列表</label>
                                                    @elseif ($data->s_tag == 0)
                                                        <input type="checkbox" id="s_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('s_tag', {{ $data->id }}, 1)"
                                                            name="s_tag" value="0">
                                                        <label for="s_tag">列表</label>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- 新增 -->
                                            <td>
                                                @if (!is_null($data->a_tag))
                                                    @if ($data->a_tag == 1)
                                                        <input type="checkbox" id="a_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('a_tag', {{ $data->id }}, 0)"
                                                            name="a_tag" value="1" checked>
                                                        <label for="a_tag">新增</label>
                                                    @elseif ($data->a_tag == 0)
                                                        <input type="checkbox" id="a_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('a_tag', {{ $data->id }}, 1)"
                                                            name="a_tag" value="0">
                                                        <label for="a_tag">新增</label>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- 編輯 -->
                                            <td>
                                                @if (!is_null($data->e_tag))
                                                    @if ($data->e_tag == 1)
                                                        <input type="checkbox" id="e_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('e_tag', {{ $data->id }}, 0)"
                                                            name="e_tag" value="1" checked>
                                                        <label for="e_tag">編輯</label>
                                                    @elseif ($data->e_tag == 0)
                                                        <input type="checkbox" id="e_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('e_tag', {{ $data->id }}, 1)"
                                                            name="e_tag" value="0">
                                                        <label for="e_tag">編輯</label>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- 刪除 -->
                                            <td>
                                                @if (!is_null($data->d_tag))
                                                    @if ($data->d_tag == 1)
                                                        <input type="checkbox" id="d_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('d_tag', {{ $data->id }}, 0)"
                                                            name="d_tag" value="1" checked>
                                                        <label for="d_tag">刪除</label>
                                                    @elseif ($data->d_tag == 0)
                                                        <input type="checkbox" id="d_tag_{{ $data->id }}"
                                                            data-menu-id="{{ $parent->id }}"
                                                            onclick="changeState('d_tag', {{ $data->id }}, 1)"
                                                            name="d_tag" value="0">
                                                        <label for="d_tag">刪除</label>
                                                    @endif
                                                @endif
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            @if (isset($menusByParent[$parent->id]))
                                @foreach ($menusByParent[$parent->id] as $child)
                                    @if ($child->hide_sub != 0)
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;├─{{ $child->name }}</td>
                                            @foreach ($datas as $data)
                                                @if ($data->menu_id == $child->id)
                                                    <td>
                                                        @if (!is_null($data->s_tag))
                                                            @if ($data->s_tag == 1)
                                                                <input type="checkbox" id="s_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('s_tag', {{ $data->id }}, 0)"
                                                                    name="s_tag" value="1" checked>
                                                                <label for="s_tag">列表</label>
                                                            @elseif ($data->s_tag == 0)
                                                                <input type="checkbox" id="s_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('s_tag', {{ $data->id }}, 1)"
                                                                    name="s_tag" value="0">
                                                                <label for="s_tag">列表</label>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($data->a_tag))
                                                            @if ($data->a_tag == 1)
                                                                <input type="checkbox" id="a_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('a_tag', {{ $data->id }}, 0)"
                                                                    name="a_tag" value="1" checked>
                                                                <label for="a_tag">新增</label>
                                                            @elseif ($data->a_tag == 0)
                                                                <input type="checkbox" id="a_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('a_tag', {{ $data->id }}, 1)"
                                                                    name="a_tag" value="0">
                                                                <label for="a_tag">新增</label>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($data->e_tag))
                                                            @if ($data->e_tag == 1)
                                                                <input type="checkbox" id="e_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('e_tag', {{ $data->id }}, 0)"
                                                                    name="e_tag" value="1" checked>
                                                                <label for="e_tag">編輯</label>
                                                            @elseif ($data->e_tag == 0)
                                                                <input type="checkbox" id="e_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('e_tag', {{ $data->id }}, 1)"
                                                                    name="e_tag" value="0">
                                                                <label for="e_tag">編輯</label>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($data->d_tag))
                                                            @if ($data->d_tag == 1)
                                                                <input type="checkbox" id="d_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('d_tag', {{ $data->id }}, 0)"
                                                                    name="d_tag" value="1" checked>
                                                                <label for="d_tag">刪除</label>
                                                            @elseif ($data->d_tag == 0)
                                                                <input type="checkbox" id="d_tag_{{ $data->id }}"
                                                                    data-menu-parent-id="{{ $parent->id }}"
                                                                    onclick="changeState('d_tag', {{ $data->id }}, 1)"
                                                                    name="d_tag" value="0">
                                                                <label for="d_tag">刪除</label>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- 更改群組 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 下拉選單元素
            let selectElement = document.getElementById('user-group');

            // 當下拉選單的變化時，更新值
            selectElement.addEventListener('change', function() {
                let selectedGroupId = this.value;
                let url = "{{ route('admin.perm') }}" + '?g_id=' + selectedGroupId;
                window.location.href = url;
            });
        });
        // 全選功能
        let selectAllCheckboxes = document.querySelectorAll('.select-all');
        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let parentId = this.getAttribute('data-parent-id');
                let childCheckboxes = document.querySelectorAll(`[data-menu-parent-id="${parentId}"]`);
                childCheckboxes.forEach(function(childCheckbox) {
                    // 更新前端的複選框狀態
                    childCheckbox.checked = checkbox.checked;
                    // 送到後台更新子項目的狀態
                    updateBackend(childCheckbox);
                });

                // 選擇具有相同 data-menu-id 的複選框
                let sameIdCheckboxes = document.querySelectorAll(`[data-menu-id="${parentId}"]`);
                sameIdCheckboxes.forEach(function(sameIdCheckbox) {
                    // 更新前端的複選框狀態
                    sameIdCheckbox.checked = checkbox.checked;
                    // 送到後台更新相同 id 的項目的狀態
                    updateBackend(sameIdCheckbox);
                });


                // 送到後台更新父項目的s_tag
                updateBackend(checkbox, true);

            });

        });

        function updateBackend(checkbox, isParent = false) {
            let name = checkbox.getAttribute('name');
            let itemId;
            if (isParent) {
                name = 's_tag';
                itemId = checkbox.getAttribute('data-perms-id');
            } else {
                itemId = checkbox.id.split('_').pop();
            }
            let value = checkbox.checked ? 1 : 0;
            let url = `/WebAdmin/perm/${name}/${itemId}/${value}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    window.location.reload();
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            setParentCheckboxState();
        });

        function setParentCheckboxState() {
            document.querySelectorAll('.select-all').forEach(parentCheckbox => {
                let parentId = parentCheckbox.dataset.parentId;
                let siblingCheckboxes = document.querySelectorAll(`[data-menu-parent-id="${parentId}"]`);
                let sameIdCheckboxes  = document.querySelectorAll(`[data-menu-id="${parentId}"]`);

                let allSelected = true;
                siblingCheckboxes.forEach(siblingCheckbox => {
                    if (!siblingCheckbox.checked) {
                        allSelected = false;
                    }
                });

                // 如果所有的子項目都被選擇，就勾選父項目
                sameIdCheckboxes.forEach(sameIdCheckbox => {
                    if (!sameIdCheckbox.checked) {
                        allSelected = false;
                    }
                });

                if (allSelected) {
                    parentCheckbox.checked = true;
                } else {
                    parentCheckbox.checked = false;
                }
            });
        }
    </script>

    {{-- 更改狀態 --}}
    <script>
        function changeState(name, id, value) {
            let url = '/WebAdmin/perm/' + name + '/' + id + '/' + value;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('回傳的資料:', data);
                })
        }
    </script>
@endsection

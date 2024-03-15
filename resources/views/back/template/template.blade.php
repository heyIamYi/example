<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon-->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />


    <title>
        {{ env('WEBSITE_NAME', '') }}
    </title>
    <link rel="stylesheet" href="{{ asset('Admin/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/jquery-ui-1.13.2.custom/jquery-ui.css') }}">

    {{-- ckeditor編輯器 --}}
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    @yield('css')
    @if (session()->has('success'))
        <script>
            alert('{{ session()->get('message') }}');
            window.location.href = '/WebAdmin/list/{{ session()->get('path') }}';
        </script>
    @endif
    {{-- 起始位置的js --}}
    @yield('head-js')

</head>
@auth('admin')

    <body>
        <!-- 導覽列 -->
        <nav>
            <div class="logobox">
                <div class="conpanyname">
                    <a href="/WebAdmin/" style="text-decoration: none; color:#006699;">
                        {{ env('WEBSITE_NAME', '') }}
                    </a>
                    <div class="admintext">後台管理</div>
                </div>
                <span style="display:flex;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <input class="topbut01" type="submit" value="" title="登出" />
                    </form>

                    <a href="{{ route('front.index') }}" target="_blank">
                        <input class="topbut02" type="button" value="" title="前台主頁" />
                    </a>
                </span>
            </div>
        </nav>
        <!-- 主要內容頁 -->
        <main>
            <div class="centerbox">
                <div id="left">
                    <div class="leftbox">
                        <!-- 列表頁面 -->
                        <ul class="object_list">
                            @if (isset($lists))
                                @foreach ($lists as $list)
                                    @if ($list->hide_sub != 0 && $list->hide_sub == 1)
                                        @if (
                                            $list->parent_id == 0 &&
                                                $list->groupPerms()->where('group_id', Auth::guard('admin')->user()->group->id)->first()->s_tag == 1)
                                            <li class="list_object" id="maintitle{{ $list->id }}">
                                                <div class="list_parent">
                                                    @if ($list->alias == true)
                                                        <img src="{{ asset('images/back-img/menu/nfolder.png') }}"
                                                            alt="" />
                                                        <a
                                                            href="/WebAdmin/list/{{ $list->alias }}">{{ $list->name }}</a>
                                                    @elseif ($list->alias == false)
                                                        <img src="{{ asset('images/back-img/menu/folder.png') }}"
                                                            alt="" />
                                                        <a>{{ $list->name }}</a>
                                                    @endif
                                                </div>
                                                <ul class="list_child">
                                                    @foreach ($lists as $child)
                                                        @if ($child->hide_sub != 0 && $child->hide_sub == 1)
                                                            @if (
                                                                $child->parent_id == $list->id &&
                                                                    $child->groupPerms()->where('group_id', Auth::guard('admin')->user()->group->id)->first()->s_tag == 1)
                                                                <li>
                                                                    <img src="{{ asset('images/back-img/menu/H.gif') }}"
                                                                        alt="">
                                                                    <img src="{{ asset('images/back-img/menu/nfolder.png') }}"
                                                                        alt="" />
                                                                    <a
                                                                        href="/WebAdmin/list/{{ $child->alias }}">{{ $child->name }}</a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <!-- 登出按鈕 -->
                        <div class="logout-botton">
                            <form method="POST" action="{{ route('logout') }}" style="display:flex;align-items:center;">
                                @csrf
                                <img src="{{ asset('images/back-img/menu/showtag_00.gif') }}" alt="登出圖示" />
                                <button type="submit">
                                    登　　出
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="right">
                    @yield('main')
                </div>
            </div>
        </main>

        <!-- 頁底 -->
        <footer>
            <div class="footerbot">
                Designed by iware
                <a href="http://www.iware.com.tw/" target="_blank" title="網頁設計公司:馬路科技">
                    <b>網頁設計</b>
                </a>
                <!--<img src="style/images/iconfbot.png">-->
                <img src="{{ asset('images/back-img/iwarelogo.png') }}" style="vertical-align: bottom; height: 21px" />
            </div>
        </footer>
    </body>


    {{-- 引入JQuery --}}

    <script src="{{ asset('Admin/js/comm.js') }}"></script>
    {{-- 自動帶入資料沒有在/list/的時候 --}}
    @if (!str_contains(request()->path(), '/list/'))
        @if (isset($data))
            <script>
                editFun({!! json_encode($data) !!});
            </script>
        @endif
    @endif

    {{-- 引入Menu --}}
    <script src="{{ asset('/Admin/js/custom-scripts/menu.js') }}"></script>
    {{-- 引入表單檢查 --}}
    <script src="{{ asset('/Admin/js/CheckForm.js') }}"></script>
    {{-- 搜尋功能 --}}
    <script>
        function search() {
            // 主要搜尋資料
            let keyword = document.getElementById('keyword').value;
            let is_show = document.getElementById('is_show');
            let is_status = document.getElementById('is_status');
            let trip_type = document.getElementById('trip_type');

            if (is_show) {
                is_show = is_show.value;
            } else {
                is_show = null;
            }

            // 處理狀態
            if (is_status) {
                is_status = is_status.value;
            } else {
                is_status = null;
            }

            // 處理行程類別
            if (trip_type) {
                trip_type = trip_type.value;
            } else {
                trip_type = null;
            }

            let data = {
                keyword: keyword,
                is_show: is_show,
                is_status: is_status,
            };

            let queryString = '?keyword=' + encodeURIComponent(keyword);

            if (is_show != null) {
                queryString += '&is_show=' + encodeURIComponent(is_show);
            }
            if (is_status != null) {
                queryString += '&is_status=' + encodeURIComponent(is_status);
            }
            if (trip_type != null) {
                queryString += '&trip_type=' + encodeURIComponent(trip_type);
            }

            // 完整url
            let old_url = window.location.pathname;
            let regex = /WebAdmin\/(.*)/;
            let matches = old_url.match(regex);
            let path = matches[1];
            let url = old_url + queryString;

            window.location.href = url;
        }
    </script>

    {{-- 刪除function --}}
    <script>
        function deleteData(path, id) {
            let link = path + '/' + id;
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

    {{-- 引入通用確認函式 --}}
    <script src="{{ asset('/Admin/js/custom-scripts/modifyConfirmation.js') }}"></script>

    {{-- 其他通用 --}}
    @yield('js')


@endauth

@guest('admin')
    '尚未登入'
@endguest


</html>

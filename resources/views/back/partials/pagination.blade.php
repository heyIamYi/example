@if (!isset($datas) || empty($datas))
    @php return; @endphp
@endif
{{-- 當前頁面名稱 --}}
@php
    $currentPageName = request()->segments()[2];
@endphp
<div class="admin-style">
    <div class="news-viewpage">
        <div class="page-right">&nbsp;</div>
        <div class="page-content">


            @if ($currentPageName == 'services')
                <span>共 <strong>{{ $datas->total() - 1 }}</strong> 筆</span>
            @else
                <span>共 <strong>{{ $datas->total() }}</strong> 筆</span>
            @endif

            <!-- 判斷是否為第一頁，若是則禁用「首頁」與「上一頁」按鈕 -->
            @if ($datas->onFirstPage())
                <span class="BtnFirst" aria-disabled="true">首頁</span>
                <span class="BtnPrev" aria-disabled="true">上一頁</span>
            @else
                <a href="{{ $datas->withQueryString()->url(1) }}" class="BtnFirst">首頁</a>
                <a href="{{ $datas->withQueryString()->previousPageUrl() }}" class="BtnPrev">上一頁</a>
            @endif

            <!-- 顯示分頁頁碼 -->
            @foreach ($datas->withQueryString()->getUrlRange(1, $datas->lastPage()) as $page => $url)
                <!-- 判斷當前頁面，當前頁使用<em>標籤以突出顯示 -->
                @if ($page == $datas->currentPage())
                    <em class="BtnNumSelect">{{ $page }}</em>
                @else
                    <a href="{{ $url }}" class="BtnNum">{{ $page }}</a>
                @endif
            @endforeach

            <!-- 判斷是否還有下一頁，若有則顯示「下一頁」與「尾頁」按鈕 -->
            @if ($datas->hasMorePages())
                <a href="{{ $datas->withQueryString()->nextPageUrl() }}" class="BtnNext">下一頁</a>
                <a href="{{ $datas->withQueryString()->url($datas->lastPage()) }}" class="BtnEnd">尾頁</a>
            @else
                <span class="BtnNext" aria-disabled="true">下一頁</span>
                <span class="BtnEnd" aria-disabled="true">尾頁</span>
            @endif

            <!-- 下拉選單供使用者選擇前往特定頁碼 -->
            <select name="p" id="pageSelect" onchange="jumpToPage(this.value)">
                @for ($i = 1; $i <= $datas->lastPage(); $i++)
                    <option value="{{ $i }}" {{ $i == $datas->currentPage() ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            </select>

        </div>
        <div class="page-left">&nbsp;</div>
    </div>
</div>

<script>
    function jumpToPage(pageNumber) {
        const queryParams = new URLSearchParams(window.location.search);
        queryParams.set('page', pageNumber);
        window.location.href = window.location.pathname + '?' + queryParams.toString();
    }
</script>

// 列表圖片顯示功能
// 選取所有的子項目，將它們隱藏
let childItems = document.querySelectorAll(".list_object .list_child li");
childItems.forEach(function (item) {
    item.style.display = "none";
});

// 選取所有的主標題
let mainTitles = document.querySelectorAll(".list_object");

// 從 sessionStorage 中獲取已展開的主標題 ID 和無子項目的主標題 ID
let expandedId = sessionStorage.getItem("expandedId");
let noChildId = sessionStorage.getItem("noChildId");

// 重置所有主標題的狀態
function resetAll() {
    mainTitles.forEach(function (title) {
        let childItems = title.querySelectorAll(".list_child li");
        let image = title.querySelector("img");
        if (title.id === expandedId) {
            childItems.forEach(function (item) {
                item.style.display = "none";
            });
            image.src = "/images/back-img/menu/folder.png";
        }
    });
}

// 對每個主標題進行處理
mainTitles.forEach(function (title) {
    let image = title.querySelector("img");

    // 處理主標題的點擊事件
    function handleTitleClick() {
        let currentId = this.id;
        let childItems = this.querySelectorAll(".list_child li");
        if (childItems.length > 0) {
            if (currentId !== expandedId) {
                resetAll();
                childItems.forEach(function (item) {
                    item.style.display = "block";
                });
                image.src = "/images/back-img/menu/ofolder.png";
                sessionStorage.setItem("expandedId", currentId);
            } else {
                childItems.forEach(function (item) {
                    item.style.display = "none";
                });
                image.src = "/images/back-img/menu/folder.png";
                sessionStorage.removeItem("expandedId");
            }
        } else {
            resetAll();
            sessionStorage.removeItem("expandedId");
            sessionStorage.setItem("noChildId", currentId);
        }
        expandedId = sessionStorage.getItem("expandedId");
    }

    // 監聽主標題的點擊事件
    title.addEventListener("click", handleTitleClick);

    // 監聽子項目的點擊事件，停止事件傳播
    let childItems = title.querySelectorAll(".list_child li");
    childItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });

    // 如果主標題的 ID 與已展開的主標題 ID 匹配，顯示子項目
    if (title.id === expandedId) {
        childItems.forEach(function (item) {
            item.style.display = "block";
        });
        image.src = "/images/back-img/menu/ofolder.png";
    }
});

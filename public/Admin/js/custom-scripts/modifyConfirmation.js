function modifyConfirmation(type, id) {
    // 確認訊息
    const confirmMessage = "確定要更改值嗎？";

    // 若類型不是 'sort'，則彈出確認訊息
    if (type !== "sort") {
        const confirmMessage = "確定要更改值嗎？";
        if (!confirm(confirmMessage)) {
            alert("已取消更改");
            return;
        }
    }
    // 取得 CSRF Token
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // 取得當前網頁路徑相關資訊
    const webpathRegex = /\/list\/([^\/]+)/;
    const webpathMatch = window.location.pathname.match(webpathRegex);
    const path = webpathMatch ? webpathMatch[1] : null;
    // 取得欲修改元素的狀態
    const elementId = `${type}_${id}`;
    const element = document.getElementById(elementId);
    let value;

    if (element.type === "checkbox") {
        value = element.checked ? 1 : 0;
    } else if (element.type === "text" && element.value === "") {
        value = 0;
    } else {
        value = element.value;
    }

    // 建立 URL 參數
    const params = new URLSearchParams();
    params.append("type", type);
    params.append("path", path);
    params.append("id", id);
    params.append("value", value);
    params.append("_token", csrfToken);

    const url = "/WebAdmin/modify";
    // 進行 POST 請求
    fetch(url, {
        method: "POST",
        body: params,
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            if (data.success && type == "sort") {
                location.reload();
            }
        })
        .catch((error) => {
            console.log(error);
            alert("儲存失敗，請聯繫工程師！");
        });
}

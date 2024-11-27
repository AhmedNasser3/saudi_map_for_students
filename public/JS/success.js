document.addEventListener("DOMContentLoaded", function() {
    const successAlert = document.getElementById("success-alert");
    const errorAlert = document.getElementById("error-alert");

    // عرض وإخفاء رسالة النجاح
    if (successAlert) {
        successAlert.classList.add("show");
        setTimeout(() => {
            successAlert.classList.remove("show");
        }, 3000); // تختفي بعد 3 ثوانٍ
    }

    // عرض وإخفاء رسالة الخطأ
    if (errorAlert) {
        errorAlert.classList.add("show");
        setTimeout(() => {
            errorAlert.classList.remove("show");
        }, 3000); // تختفي بعد 3 ثوانٍ
    }
});
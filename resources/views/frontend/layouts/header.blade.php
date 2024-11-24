 <!-- header -->
 <header class="header">
    <div class="header_container">
        <div class="header_data">
            <div class="header_content">
                <div id="log-in" class="log-up">
                    <div class="log_in">
                        <button><a href="#">🪙 الرصيد : {{ auth()->user()->balance }}</a></button>
                    </div>
                    <div class="sign_up">
                        <button><a href="#">📏 المساحة : 300 متر</a></button>
                    </div>
                </div>
                <div class="header_logo">
                    <div class="header_links" id="header_links">
                        <ul id="menuList" class="menuList">
                            <li class="header_link">الخريطة</li>
                            <li class="header_link">مكتبي</li>
                            <li class="header_link">
                                <div id="turnon-log" class="log-up">
                                    <div class="log_in">
                                        <button><a href="#" >تسجيل دخول</a></button>
                                    </div>
                                    <div class="sign_up" >
                                        <button><a href="#" >مستخدم جديد</a></button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <img src="/images/logo.png" alt="">

                </div>
                <div class="icons_price_lands">
                    <div class="icon_prices">
                        <div class="icon_price_1">
                            <button><a href="#" style="font-size: .7rem; color:white;">🪙 الرصيد : ريال2000</a></button>&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="icon_prices">
                        <div class="icon_price_2">
                            <button><a href="#" style="font-size: .8rem; color:#2f8a2c;">📏 المساحة : 300 متر</a></button>
                        </div>
                    </div>
                </div>
                <div class="menu-icon">
                    <i class="fa-solid fa-bars" onclick="toggleMenu()"></i>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
// header

let menuList = document.getElementById("menuList")
menuList.style.maxHeight = "0px";

function toggleMenu() {
    if (menuList.style.maxHeight == "0px") {
        menuList.style.maxHeight = "300px";
    } else {
        menuList.style.maxHeight = "0px";
    }
}
</script>

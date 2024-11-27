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
                        @php
                            use App\Models\admin\land\LandArea;
                            $meters = LandArea::where('user_id', auth()->user()->id)->sum('area');
                            @endphp
                        <button><a href="#">📏 المساحة : {{ floor($meters) }} متر</a></button>
                    </div>
                </div>
                <div class="header_logo">
                    <div class="header_links" id="header_links">
                        <ul id="menuList" class="menuList">
                            <li class="header_link" style="color: white">الخريطة</li>

                            <li class="header_link"><a href="{{ route('my.office', ['user_id' => auth()->user()->id]) }}" style="color: #131313">مكتبي</a></li>
                            <li class="header_link">
                                <div id="turnon-log" class="log-up">
                                    <div class="log_in">
                                        <button><a href="#">تسجيل دخول</a></button>
                                    </div>
                                    <div class="sign_up" >
                                        <button><a href="#">مستخدم جديد</a></button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('home.page') }}">
                        <img src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="icons_price_lands">
                    <div class="icon_prices">
                        <div class="icon_price_1">
                            <button><a href="#"  style="color: white;">🪙 الرصيد : {{ auth()->user()->balance }}</a></button>
                        </div>
                    </div>
                    <div class="icon_prices">
                        <div class="icon_price_2">
                            <button><a href="#">📏 المساحة : 300 متر</a></button>
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

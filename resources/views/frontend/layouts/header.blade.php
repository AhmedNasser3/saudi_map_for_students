<!-- header -->
<header class="header">
    <div class="header_container">
        <div class="header_data">
            <div class="header_content">
                <div id="log-in" class="log-up">
                    <div class="log_in">
                        @if (auth()->check())
                        <button><a href="#">🪙 الرصيد : {{ auth()->user()->balance }}</a></button>
                        <button><a href="#">🪙 الرصيد المعلق  : {{ auth()->user()->freeze_balance  }}</a></button>
                        @else
                        <button><a href="{{ route('login') }}">تسجيل الدخول</a></button>
                        @endif
                    </div>
                    <div class="sign_up">
                        @php
                        use App\Models\admin\land\LandArea;
                        if (auth()->check()) {

                        $meters = LandArea::with('bids')
            ->where('highest_bidder_id', auth()->user()->id)
            ->get()->sum('area');;
                        }
                        @endphp
                        @if (auth()->check())
                        <button><a href="#">📏 المساحة : {{ floor($meters) }} متر</a></button>
                        <button><a href="{{ route('logout') }}">تسجيل خروج</a></button>
                        @else
                        @endif
                    </div>
                </div>
                <div class="header_logo">
                    <div class="header_links" id="header_links">
                        <ul id="menuList" class="menuList">
                            @if (auth()->check())
                            <li class="header_link" style="color: white">الخريطة</li>
                            @if (auth()->user()->role == 'admin')
                            <li class="header_link"><a href="{{ route('user.page') }}" style="color: #131313">الدخول الي صفحة الادمن</a></li>
                            @else
                            @endif
                            <li class="header_link"><a href="{{ route('my.office', ['user_id' => auth()->user()->id]) }}" style="color: #131313">مكتبي</a></li>
                            <li class="header_link">
                                <div id="turnon-log" class="log-up">
                                    <div class="log_in">
                                        <button><a href="{{ route('logout') }}">تسجيل خروج</a></button>
                                    </div>
                                </div>
                            </li>
                            @else
                            <li class="header_link">
                                <div id="turnon-log" class="log-up">
                                    <div class="log_in">
                                        <button><a href="{{ route('login') }}">تسجيل الدخول</a></button>
                                    </div>
                                    <div class="sign_up" >
                                    </div>
                                </div>
                            </li>
                            @endif

                        </ul>
                    </div>
                    <a href="{{ route('home.page') }}">
                        <img src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="icons_price_lands">
                    <div class="icon_prices">
                        <div class="icon_price_1">
                            @if (auth()->check())
                            <button><a href="#"  style="color: white;">🪙 الرصيد : {{ auth()->user()->balance }}</a></button>
                            @else
                            <button><a href="#">تسجيل الدخول</a></button>
                            @endif
                        </div>
                    </div>
                    <div class="icon_prices">
                        <div class="icon_price_2">
                            @if (auth()->check())
                            <button><a href="#">📏 المساحة : 300 متر</a></button>
                            @else
                            <button><a href="#">مستخدم جديد</a></button>
                            @endif
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
{{-- header Js --}}
<script src="{{ asset('JS/header.js') }}"></script>

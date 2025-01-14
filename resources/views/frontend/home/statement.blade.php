
@extends('admin.master')
@section('admin_content')
<div class="home_cn" style="direction: rtl">
    <div class="home_bg" style="background-color: #1b2d68;">
        <div class="home_title">
            <div class="home_icons">
                <div class="home_icon"><i style="background-color: #ffffff;color: #334da0;"class="fa-solid fa-user"></i></div>
            </div>
            @php
            use App\Models\User;
            use App\Models\admin\bid\Bid;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
                $users = User::all();
                $lands = Land::all();
                $landAreas = LandArea::where('go', '1')->where('stop' , '0');
                $landAreasView = LandArea::all();
                $bids = Bid::all();
            @endphp
            <h2 style="color: #fff;">{{ __('عدد الطلاب') }} - <span>{{ $users->count() }}</span></h2>
        </div>
    </div>
    <div class="home_bg">
        <div class="home_title">
            <div class="home_icons">
                <div class="home_icon"><i class="fa-solid fa-person-military-pointing"></i></div>
            </div>
            <h2>{{ __('عدد المدن') }} - <span>{{ $lands->count() }}</span></h2>
        </div>
    </div>
    <div class="home_bg">
        <div class="home_title">
            <div class="home_icons">
                <div class="home_icon"><i class="fa-solid fa-lock"></i></div>
            </div>
            <h2>{{ __('عدد المزادات الفعاله الان') }} - <span>{{ $landAreas->count() }}</span></h2>
        </div>
    </div>
    <div class="home_bg">
        <div class="home_title">
            <div class="home_icons">
                <div class="home_icon"><i class="fa-solid fa-lock"></i></div>
            </div>
            <h2>{{ __('عدد المزادات كاملة') }} - <span>{{ $landAreasView->count() }}</span></h2>
        </div>
    </div>
</div>
@endsection
<style>
    @import url("https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&display=swap");
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style: none;
    text-decoration: none;
    font-family: "Beiruti", serif;
    font-optical-sizing: auto;
    font-style: normal;
}

.home {
    display: flex;
    justify-content: center;
    padding: 0 5%;
    min-height: 100vh;
    background-color: #f2f8ff;
}

.home_cn {
    padding: 2% 0 0 0;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.home_cn {
    display: flex;
    justify-content: center;
    align-items: center;
}

.home_bg {
    cursor: pointer;
    display: grid;
    align-items: center;
    width: 380px;
    height: 120px;
    border-radius: 20px;
    background-color: #ffffff;
    transition: all 0.6s ease;
}

.home_bg:hover {
    transition: all 0.6s ease;
    background-color: #1b2d68;
}

.home_title {
    padding: 0 20px;
    display: flex;
}

.home_icon i {
    background-color: #334da0;
    width: 50px;
    height: 50px;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.6s ease;
}

.home_bg:hover i {
    transition: all 0.6s ease;
    background-color: #ffffff;
    color: #334da0;
}

.home_bg h2 {
    padding: 0 10px 0 0;
    display: flex;
    align-items: center;
    color: #334da0;
    transition: all 0.6s ease;
}

.home_bg:hover h2 {
    transition: all 0.6s ease;
    color: #fff;
}

.home_title {
    display: flex;
    justify-content: space-between;
}

.home_title h2 span {
    color: #4edcff;
    padding: 10px;
}

/* alarm */

.home_alarm {
    padding: 10px 0;
}

.home_container_container {
    background-color: #a7d7afd4;
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #71ff4e;
}

.home_container_title {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.home_container_title i {
    color: white;
    font-weight: 900;
    cursor: pointer;
}

.home_container_title h2 {
    display: flex;
    align-items: center;
    color: white;
    font-size: 18px;
}

.home_container_title h2 span {
    display: flex;
    align-items: center;
    padding: 0 10px 0 0;
    color: #131313;
}

.home_container_title h2 span i {
    color: #629361;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.home_alarm {
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}

.home_alarm.show {
    opacity: 0;
    display: none;
}

/* Account */

.account {
    padding: 2% 0 0 0;
}

.account_container {
    background-color: #ffff;
    height: 200px;
    padding: 20px;
    border-radius: 10px;
}

.account_title {
    color: #4d5366;
}

.account_content_bg_data {
    border: 1px solid #dadada;
    margin: 15px 0 0 0;
    border-radius: 10px;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
}

.account_content_bg_title h3 {
    padding: 0 0 45px 0;
    color: #636363;
    font-weight: 600;
}

.account_content_bg_title {
    text-align: center;
}

/* notify index */
/* notify index */

.notify {
    padding: 2% 0 0 0;
}

.notify_container {
    background-color: #ffff;
    padding: 20px;
    border-radius: 10px;
}

.notify_title {
    display: flex;
    align-items: center;
}

.notify_title p {
    color: #9e9e9e;
    font-weight: 500;
    padding: 0 10px 0 0;
}

.table {
    border: 2px solid #000;
    width: 100%;
    border-collapse: collapse;
}

.notify_table table tr th,
.notify_table table tr td {
    padding: 10px 20px;
    text-align: center;
}

.notify_table {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-x: auto; /* تم تفعيل overflow-x بشكل مناسب */
}

table {
    width: 100%;
    border-collapse: collapse;
}

.tr_head {
    color: white;
    background-color: #3f589c;
}

.tr_body {
    background-color: #ffffff;
}

tr {
    border: 1px solid #bbbbbb;
    padding: 10px 0 0 0;
}

.notify_title_cn {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.notify_btn button {
    cursor: pointer;
    padding: 8px 20px;
    background-color: #334da0;
    border: none;
    border-radius: 5px;
    transition: all 0.6s ease;
}

.notify_btn:hover button {
    transition: all 0.6s ease;
    background-color: #232f55;
}

.notify_btn button a {
    color: white;
}

.tr_body td {
    color: #646464;
}

.tr_body td h3 {
    color: #2e363b;
}

.notify_table {
    overflow-x: auto; /* تفعيل الـ overflow-x لتحسين التمرير الأفقي */
    padding: 0 20px; /* إضافة padding بشكل مناسب */
    max-width: 100%; /* ضمان تناسب الجدول مع العرض */
}

@media screen and (max-width: 1024px) {
    .notify {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .notify_container {
        max-width: 100%;
        padding: 10px;
    }
    table {
        width: 100%;
    }
    .notify_table table tr th,
    .notify_table table tr td {
        padding: 10px 10px;
        text-align: center;
    }
}

@media screen and (max-width: 768px) {
    .notify_container {
        padding: 15px;
    }
    .notify_title_cn {
        flex-direction: column;
        align-items: flex-start;
    }
    .notify_btn button {
        width: 100%;
    }
    .notify_table {
        padding: 0 10px;
    }
    .table th,
    .table td {
        font-size: 12px; /* تصغير حجم الخط في الأجهزة الصغيرة */
    }
}

/* admin notify */

.admin_container {
    padding: 0 10%;
}

</style>

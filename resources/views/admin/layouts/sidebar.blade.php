<nav class="navbar">
  <ul class="navbar__menu">
    <li class="navbar__item">
      <a href="#" class="navbar__link"><i class="fa-solid fa-house"></i><span>رئيسية</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('land.page') }}" class="navbar__link"><i class="fa-solid fa-earth-africa"></i><span>الأراضي</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('landArea.page') }}" class="navbar__link"><i class="fa-solid fa-lines-leaning"></i><span>المزادات</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{route('user.page')}}" class="navbar__link"><i class="fa-solid fa-users"></i><span>المستخدمين</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('add_balance') }}" class="navbar__link"><i class="fa-solid fa-plus"></i><span>اضف رصيد للطلاب</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('minus_balance.form') }}" class="navbar__link"><i class="fa-solid fa-minus"></i><span>اخصم رصيد للطلاب</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('admin.chat.view') }}" class="navbar__link"><i class="fa-solid fa-envelope"></i><span>الاستشارات</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('estate.index') }}" class="navbar__link"><i class="fa-solid fa-person-cane"></i><span>شيخ العقار</span></a>
    </li>
    <li class="navbar__item">
      <a href="{{ route('price.page') }}" class="navbar__link"><i class="fa-solid fa-coins"></i><span>تعديل اسعارالمنتجات</span></a>
    </li>
  </ul>
</nav>

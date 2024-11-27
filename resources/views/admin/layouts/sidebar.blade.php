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
  </ul>
</nav>

@extends('admin.master')
@section('admin_content')
<h1>قائمة المدن</h1>

<ul>
    @foreach($cities as $city)
        <li>
            {{ $city->name }}: {{ $city->total_meters }} متر
            <form action="{{ route('cities.addArea', $city->id) }}" method="POST">
                @csrf
                <input type="number" name="meters" placeholder="إضافة مساحة (متر)">
                <button type="submit">إضافة</button>
            </form>
        </li>
    @endforeach
</ul>

<h2>إضافة مدينة جديدة</h2>
<form action="{{ route('cities.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="اسم المدينة" required>
    <button type="submit">إضافة</button>
</form>
@endsection

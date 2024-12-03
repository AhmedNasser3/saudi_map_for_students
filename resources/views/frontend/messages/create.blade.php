@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('my.office', ['user_id' => auth()->user()->id]) }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>انشاء استشارة</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                    <div class="admin_land_create_body">
                        <div class="form-container">
                            <form action="{{ route('message.create') }}" method="POST">
                                @method('post')
                                @csrf
                              <table>
                                <tr>
                                    <td>
                                        <input type="text" id="title" name="title" placeholder="ادخل عنوان الرسالة..." required>
                                    </td>
                                    <td>
                                      <label for="title">: عنوان الاستشارة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="message" name="message" placeholder="ادخل تفاصيل الرسالة..." required>
                                    </td>
                                    <td>
                                      <label for="message">: تفاصيل الاستشارة</label>
                                    </td>
                                </tr>
                                <tr hidden>
                                    <td>
                                        <input type="text" id="user_id" name="user_id" value="{{ auth()->user()->id }}" placeholder="ادخل تفاصيل الرسالة..." required>
                                    </td>
                                    <td>
                                      <label for="user_id">: المستخدم</label>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    @php
                                    use App\Models\admin\price\Price;

                                    $price = Price::first(); // إذا كنت تريد تحديث أول سجل فقط. يمكنك تخصيص البحث إذا كان هناك أكثر من سجل
                                    @endphp
<input style="text-align: center" type="submit" value="انشيئي استشارة ب{{ $price->first()->message_price }} ريال">
</td>
                                </tr>
                              </table>
                            </form>
                          </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

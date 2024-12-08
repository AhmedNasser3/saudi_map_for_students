@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('admin.view.product') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>انشاء المنتج</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                    <div class="admin_land_create_body">
                        <div class="form-container">
                            <form action="{{ route('product.store') }}" method="POST">
                                @method('post')
                                @csrf
                              <table>
                                <tr>
                                    <td>
                                        <input type="text" id="name" name="name" placeholder="ادخل اسم الارض هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="name">: العنوان</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="number_products" name="number_products" placeholder="ادخل اسم الارض هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="number_products">: عدد المنتج</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="name" name="area" placeholder="ادخل اسم الارض هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="area">: المساحة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select id="state" name="state" class="select_land" required>
                                            <option value="" disabled selected>اختر طريقة الزيادة...</option>
                                                <option value="0">%</option>
                                                <option value="1">كم</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label for="land_id">: الزيادة</label>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <input type="submit" value="انشيئ المنتج">
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

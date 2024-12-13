@extends('admin.master')

@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('admin.view.product') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>تعديل المنتج</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                <div class="admin_land_create_body">
                    <div class="form-container">
                        <form action="{{ route('product.admin.update', $product->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" id="name" name="name" value="{{ $product->name }}" placeholder="ادخل اسم العنوان هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="name">: العنوان</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="number_products" name="number_products" value="{{ $product->number_products }}" placeholder="ادخل عدد المنتج هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="number_products">: عدد المنتج</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="area" name="area" value="{{ $product->area }}" placeholder="ادخل اسم المساحة هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="area">: المساحة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select id="state" name="state" class="select_land" required>
                                            <option value="" disabled>اختر طريقة الزيادة...</option>
                                            <option value="0" {{ $product->state == 0 ? 'selected' : '' }}>%</option>
                                            <option value="1" {{ $product->state == 1 ? 'selected' : '' }}>كم</option>
                                        </select>
                                    </td>
                                    <td>
                                      <label for="state">: الزيادة</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="bonus_area_price" name="bonus_area_price" value="{{ $product->bonus_area_price }}" placeholder="ادخل سعر المنتج هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="bonus_area_price">: سعر المنتج</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="تحديث المنتج">
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

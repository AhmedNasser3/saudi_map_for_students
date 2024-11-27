@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('land.page') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>انشاء ارض</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                    <div class="admin_land_create_body">
                        <div class="form-container">
                            <form action="{{ route('land.store') }}" method="POST">
                                @method('post')
                                @csrf
                              <table>
                                <tr>
                                    <td>
                                        <input type="text" id="name" name="name" placeholder="ادخل اسم الارض هنا ..." required>
                                    </td>
                                    <td>
                                      <label for="name">: الأسم</label>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <input type="submit" value="انشيئي الارض">
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

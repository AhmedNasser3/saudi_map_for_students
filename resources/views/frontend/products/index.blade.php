<div class="products">
    <div class="products_container">
        <div class="products_data">
            <div class="products_content">
                <div class="products_title">
                    <h3>الدرج السري</h3>
                </div>
                <div class="products_bg_container">
                    @foreach ($bonusAreas as $bonusArea)
                    <form action="{{ route('product.store') }}" method="post">
                        @csrf <!-- إضافة الحماية -->
                        <div class="products_bg">
                            <div class="products_bg_title">
                                <h3>مساحة أرض للبيع</h3>
                                <div class="products_bg_area">
                                    <input type="hidden" name="bonus_area" value="{{ $bonusArea->area }}">
                                    <p>{{ floor($bonusArea->area) }} @if($bonusArea->state == 1 )
                                    كم
                                    @else
                                    %
                                    @endif</p>
                                </div>
                            </div>
                            <div class="products_bg_des">
                                <div>
                                    <p>مساحة أرض متوفرة </p>
                                    <p>X{{ $bonusArea->number_products }}</p>
                                </div>
                                <div class="products_bg_btn">
                                    <select name="landArea_id" id="locations" required>
                                        @foreach ($bids as $landArea)
                                        <option value="{{ $landArea->id }}">{{ $landArea->land_deed }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="bonus_area_price" value="{{ $bonusArea->bonus_area_price }}" id="" hidden>
                                    <input type="text" name="state" value="{{ $bonusArea->state }}" id="" hidden>
                                    <button type="submit" style="color: white">شراء واحدة بسعر {{ floor($bonusArea->bonus_area_price) }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

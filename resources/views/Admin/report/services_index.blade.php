
<div class="modal-body">
    <div class="form-group ">
        <label for="name" class="form-control-label" style="display: block !important;">مقدم الخدمة</label>
        <img alt="image" onclick="window.open(this.src)" class="avatar " style=" width: 250px !important;
                                                                                height: 200px !important;
                                                                                display: block;
                                                                                border-radius: 50%;
                                                                                margin-left: auto;
                                                                                margin-right: auto;
                                                                                border: 3px solid #525ce5 !important ;"
             src="{{ get_user_file($order->provider->image) }}">
        <h3 class="form-input" style="text-align: center; margin-top: 4px">{{ $order->provider->first_name }}</h3>
        <h4 class="form-input" style="text-align: center">{{  $order->sub_category->title_ar }}</h4>
        <hr style="border-color: #525ce5 !important;">
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">العميل</label>
        <h3 class="form-control" style="font-size: 20px">{{ $order->user->first_name }}</h3>
    </div>

    <div class="form-group">
        <label for="name" class="form-control-label">القسم</label>
        <h3 class="form-control" style="font-size: 20px">{{  $order->sub_category->title_ar }}</h3>
    </div>

{{--    <div class="form-group">--}}
{{--        <label for="name" class="form-control-label">صورة الطلب</label>--}}
{{--        @php--}}
{{--            $image = $order->img--}}
{{--        @endphp--}}
{{--        @if($image == null)--}}
{{--            <p> لا يوجد صورة </p>--}}
{{--        @else--}}
{{--            <img alt="image" onclick="window.open(this.src)" class="avatar " style=" width: 250px !important;--}}
{{--                                                                                    height: 200px !important;--}}
{{--                                                                                    display: block;--}}
{{--                                                                                    margin-left: auto;--}}
{{--                                                                                    margin-right: auto;--}}
{{--                                                                                    "--}}
{{--                 src="{{ url('/orders/'.$order->img) }}">--}}
{{--            <h5 for="name" class="form-input" style="text-align: center">اضغط علي الصورة للتكبير</h5>--}}
{{--        @endif--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        <label for="name" class="form-control-label">حالة الطلب</label>--}}
{{--        <h2 class="form-control" style="font-size: 20px">{{ $order->payment_status }}</h2>--}}
{{--    </div>--}}

    <div class="form-group">
        <label for="name" class="form-control-label">الحالة</label>
        <h2 class="form-control" style="font-size: 20px">{{ $order->status }}</h2>
    </div>

    <div class="form-group">
        <label for="name" class="form-control-label">السعر</label>
        <h2 class="form-control" style="font-size: 20px">{{ $order->price }}</h2>
    </div>

    <hr style="border-color: #525ce5 !important;">
    <div class="form-group">
        <h4 for="name" class="form-input" style="text-align: center; border: 1px solid #525ce5 ; background-color: #525ce5; color: white; border-radius: 4px; padding: 5px">التفاصيل</h4>
        <h3  class="form-input" style="font-size: 20px; text-align: center">{{ $order->details }}</h3>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
    </div>
</div>
<script>
    $('.dropify').dropify()
</script>

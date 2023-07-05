<div class="modal-body">
    <div class="form-group ">
        <label for="name" class="form-control-label" style="display: block !important;">مقدم الخدمة</label>
        <img alt="image" onclick="window.open(this.src)" class="avatar " style="  width: 250px !important;
                                                                                height: 200px !important;
                                                                                display: block;
                                                                                border-radius: 50%;
                                                                                margin-left: auto;
                                                                                margin-right: auto;
                                                                                border: 3px solid #525ce5 !important ;"
         src="{{ get_user_file($service->provider->image) }}">
        <h3 class="form-input" style="text-align: center; margin-top: 4px">{{ $service->provider->first_name }}</h3>
        <h4 class="form-input" style="text-align: center">{{ $service->provider->category->title_ar }}</h4>
        <hr style="border-color: #525ce5 !important;">
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">العميل</label>
        <h3 class="form-control" style="font-size: 20px">{{ $service->user->first_name }}</h3>
    </div>

    <div class="form-group">
        <label for="name" class="form-control-label">القسم</label>
        <h3 class="form-control" style="font-size: 20px">{{ $service->sub_category->title_ar }}</h3>
    </div>

    <div class="form-group">
        <label for="name" class="form-control-label">السعر</label>
        <h2 class="form-control" style="font-size: 20px">{{ number_format($service->price,2) }}</h2>
    </div>

    <div class="form-group">
        <label for="name" class="form-control-label">تاريخ التسليم</label>
        <h2 class="form-control" style="font-size: 20px">{{ $service->delivery_date }}</h2>
    </div>

    <hr style="border-color: #525ce5 !important;">
    <div class="form-group">
        <h4 for="name" class="form-input" style="text-align: center; border: 1px solid #525ce5 ; background-color: #525ce5; color: white; border-radius: 4px; padding: 5px">التفاصيل</h4>
        <h3  class="form-input" style="font-size: 20px; text-align: center">{{ $service->details }}</h3>
    </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        </div>
    </div>
<script>
    $('.dropify').dropify()
</script>

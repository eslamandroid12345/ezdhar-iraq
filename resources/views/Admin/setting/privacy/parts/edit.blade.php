<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('update_about',$abouts->id)}}" >
    @csrf
{{--        @method('put')--}}
        <input type="hidden" value="{{$abouts->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">من نحن بالعربية</label>
            <input type="text" class="form-control" name="about_ar" id="about_ar" value="{{$abouts->about_ar}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">من نحن بالانجليزية</label>
            <input type="text" class="form-control" name="about_en" id="about_en" value="{{$abouts->about_en}}">
        </div>
{{--        <div class="form-group">--}}
{{--            <label for="name" class="form-control-label">الاسم بالعربية</label>--}}
{{--            <input type="text" class="form-control" name="terms_ar" id="terms_ar" value="{{$setting->terms_ar}}">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="name" class="form-control-label">الاسم بالانجليزية</label>--}}
{{--            <input type="text" class="form-control" name="terms_en" id="terms_en" value="{{$setting->terms_en}}">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="name" class="form-control-label">الاسم بالعربية</label>--}}
{{--            <input type="text" class="form-control" name="privacy_ar" id="privacy_ar" value="{{$setting->privacy_ar}}">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="name" class="form-control-label">الاسم بالانجليزية</label>--}}
{{--            <input type="text" class="form-control" name="privacy_en" id="privacy_en" value="{{$setting->privacy_en}}">--}}
{{--        </div>--}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>

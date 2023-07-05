<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('subcategories.store')}}">
    @csrf
        <div class="form-group">
        <label for="name" class="form-control-label">الصورة</label>
        <input type="file" class="dropify" name="image" data-default-file="{{asset('assets/uploads/avatar.png')}}" accept="image/png,image/webp , image/gif, image/jpeg,image/jpg"/>
        <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg, jpg,webp</span>
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">القسم</label>
        <select name="category_id" class="form-control">
            <option value="" disabled selected >اختار القسم</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{lang() == 'ar' ? $category->title_ar : $category->title_en}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">الاسم بالعربية</label>
        <input type="text" class="form-control" name="title_ar" id="title_ar">
    </div>
    <div class="form-group">
            <label for="name" class="form-control-label">الاسم بالانجليزية</label>
            <input type="text" class="form-control" name="title_en" id="title_en">
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">شروط التقدم بالعربية</label>
        <input type="text" class="form-control" name="terms_ar" id="terms_ar">
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">شروط التقدم بالانجليزية</label>
        <input type="text" class="form-control" name="terms_en" id="terms_en">
    </div>
{{--    <div class="form-group">--}}
{{--        <label for="name" class="form-control-label">السعر</label>--}}
{{--        <input type="text" class="form-control" name="price" id="price">--}}
{{--    </div>--}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>

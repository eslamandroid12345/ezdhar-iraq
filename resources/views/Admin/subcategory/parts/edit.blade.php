<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('subcategories.update',$subcategory->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$subcategory->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" id="testDrop" class="dropify" name="image" data-default-file="{{get_user_file($subcategory->image)}}"/>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">القسم</label>
            <select name="category_id" class="form-control">
                <option value="" disabled selected >اختار القسم</option>
            @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == $subcategory->category_id ? 'selected' : ''}}>{{lang() == 'ar' ? $category->title_ar : $category->title_en}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم بالعربية</label>
            <input type="text" class="form-control" name="title_ar" id="title_ar" value="{{$subcategory->title_ar}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم بالانجليزية</label>
            <input type="text" class="form-control" name="title_en" id="title_en" value="{{$subcategory->title_en}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الشروط بالعربية</label>
            <input type="text" class="form-control" name="terms_ar" id="terms_ar" value="{{$subcategory->terms_ar}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الشروط بالانجليزية</label>
            <input type="text" class="form-control" name="terms_en" id="terms_en" value="{{$subcategory->terms_en}}">
        </div>
{{--        <div class="form-group">--}}
{{--            <label for="name" class="form-control-label">السعر</label>--}}
{{--            <input type="text" class="form-control" name="price" id="price" value="{{$subcategory->price}}">--}}
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

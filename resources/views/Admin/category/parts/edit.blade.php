<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('categories.update',$category->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$category->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" id="testDrop" class="dropify" name="image" data-default-file="{{get_user_file($category->image)}}"/>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم بالعربية</label>
            <input type="text" class="form-control" name="title_ar" id="title_ar" value="{{$category->title_ar}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم بالانجليزية</label>
            <input type="text" class="form-control" name="title_en" id="title_en" value="{{$category->title_en}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">عدد الطلبات</label>
            <input type="text" class="form-control" name="limit" id="order_count" value="{{$category->limit}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>

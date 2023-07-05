<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('feasibility_study.update',$feasibility_study->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$feasibility_study->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" id="testDrop" class="dropify" name="image" data-default-file="{{get_user_file($feasibility_study->image)}}"/>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$feasibility_study->name}}">
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

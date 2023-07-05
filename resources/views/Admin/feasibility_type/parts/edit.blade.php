<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('feasibility_type.update',$feasibility_type->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$feasibility_type->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" id="testDrop" class="dropify" name="img" data-default-file="{{asset($feasibility_type->img)}}"/>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">النوع</label>
            <input type="text" class="form-control" name="type" id="name" value="{{$feasibility_type->type}}">
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

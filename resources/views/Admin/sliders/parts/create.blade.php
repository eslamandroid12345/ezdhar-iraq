<form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('sliders.store')}}">
    @csrf
    <div class="form-group">
        <label for="image" class="form-control-label">الصورة</label>
        <input type="file" class="dropify" name="image" accept="image/png, image/gif, image/jpeg,image/jpg"/>
        <span class="form-text text-danger text-center">مسموح بالصيغ الاتية png, gif, jpeg, jpg</span>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="desc_ar" class="form-control-label">المحتوي باللغة العربية</label>
                <textarea name="desc_ar" id="editor">
       تفاصيل عن المقطع
                </textarea>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="desc_en" class="form-control-label">المحتوي باللغة الانجليزية</label>
                <textarea name="desc_en" id="editor2">
        Details about the section
                </textarea>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor2'))
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_ar" class="form-control-label">نص الزر (ar)</label>
                <input type="text" class="form-control" name="btn_title_ar">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">نص الزر (en)</label>
                <input type="text" class="form-control" name="btn_title_en">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="btn_link" class="form-control-label">لينك توجيه الزر</label>
                <input type="text" class="form-control" name="btn_link" placeholder="https://www.facebook.com/">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
    </div>
</form>
<script>
    $('.dropify').dropify()
</script>


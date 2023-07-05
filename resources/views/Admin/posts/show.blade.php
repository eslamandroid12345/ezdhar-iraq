<div class="modal-body">
    <div class="row">
        <div class="col-2">
        <img alt="image" onclick="window.open(this.src)" class="avatar " style=" width: 100% !important;
                                                                                height: 100% !important;
                                                                                border-radius: 50%;
                                                                                margin-left: auto;
                                                                                margin-right: auto;"
         src="{{ get_user_file($post->provider->image) }}">
        </div>
        <div class="col-10" style="margin-top: 3px">
        <h3 class="form-input" style="text-align: right; font-size: 19px">{{ $post->provider->first_name }}</h3>
        <h4 class="form-input" style="text-align: right;  font-size: 15px">{{ $post->provider->category->title_ar }}</h4>
        <h5 class="form-input" style="text-align: right;  font-size: 12px">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</h5>
        </div>
    </div>
    </div>

{{--    <div class="form-group">--}}
{{--        <label for="name" class="form-control-label">العنوان</label>--}}
{{--        <h2 class="form-control" style="font-size: 20px">{{ $post->title }}</h2>--}}
{{--    </div>--}}

    <div class="form-group">

        <h3  class="form-input" style="font-size: 19px; text-align: center; line-height: 1.7 ">{{ $post->description }}</h3>
    </div>

    <div class="form-group">
        @if($post->image == null)
            <h3  class="form-input" style="font-size: 20px; text-align: center">لا يوجد صورة لهذا المنشور</h3>
        @else
        <img alt="image" onclick="window.open(this.src)" class="avatar " style=" width: 600px !important;
                                                                                    height: 300px !important;
                                                                                    display: block;
                                                                                    margin-left: auto;
                                                                                    margin-right: auto;"
             src="{{ asset('jobs/'. $post->image) }}">
        @endif
    </div>

        <div class="modal-footer">
            @if($post->status == 1)
            <button data-id="{{ $post->id }}" type="button" data-dismiss="modal" class="btn btn-danger statusBtn">ايقاف</button>
            @endif
            @if($post->status == 0)
            <button data-id="{{ $post->id }}" type="button" data-dismiss="modal"  class=" btn btn-success statusBtn">نشر</button>
            @endif
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        </div>
    </div>
<script>
    $('.dropify').dropify()

    // change users status
    $(document).on('click', '.statusBtn', function (event) {
        var id = $(this).data("id")
        $.ajax({
            type: 'POST',
            url: "{{route('PostActivation')}}",
            data: {
                '_token': "{{csrf_token()}}",
                'id': id,
            },

            success: function (data) {
                if (data.success === true) {
                    $('#dataTable').DataTable().ajax.reload();
                    location.reload();
                    toastr.success(data.message)
                } else {
                    toastr.error('هناك خطأ ما ...')
                }
            }
        })
    });
</script>

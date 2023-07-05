@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}} | الخصوصية
@endsection
@section('page_name') الخصوصية @endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="modal-body">
                <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('update_privacy',$privacy->id)}}" >
                    @csrf
{{--                            @method('put')--}}
                    <input type="hidden" value="{{$privacy->id}}" name="id">
                    <div class="form-group">
                        <label for="name" class="form-control-label">الخصوصية بالعربية</label>
                        <textarea name="privacy_ar" class="form-control editor" id="privacy_ar">{{$privacy->privacy_ar}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">الخصوصية بالانجليزية</label>
                        <textarea name="privacy_en" class="form-control editor" id="privacy_en">{{$privacy->privacy_en}}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('.dropify').dropify()
    </script>

    @include('Admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'privacy_ar', name: 'privacy_ar'},
            {data: 'privacy_en', name: 'privacy_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('setting.privacy')}}', columns);
        // Delete Using Ajax
        {{--deleteScript('{{route('delete_setting')}}');--}}
        {{--// Add Using Ajax--}}
        showAddModal('{{route('setting.privacy')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('setting.privacy')}}');
        editScript();
    </script>
    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
        }
    </script>
@endsection



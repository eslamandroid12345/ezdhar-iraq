@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}} | من نحن
@endsection
@section('page_name') من نحن @endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="modal-body">
                <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('update_about',$abouts->id)}}" >
                    @csrf
{{--                        @method('put')--}}
                    <input type="hidden" value="{{$abouts->id}}" name="id">
                    <div class="form-group">
                        <label for="name" class="form-control-label">من نحن بالعربية</label>
                        <textarea name="about_ar" class="form-control editor" id="about_ar">{{$abouts->about_ar}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">من نحن بالانجليزية</label>
                        <textarea name="about_en" class="form-control editor" id="about_ar">{{$abouts->about_en}}</textarea>
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
            {data: 'about_ar', name: 'about_ar'},
            {data: 'about_en', name: 'about_en'},

            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('setting.about')}}', columns);
        {{--// Add Using Ajax--}}
        showAddModal('{{route('setting.about')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('setting.about')}}');
        editScript();
    </script>
    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
        }
    </script>
@endsection



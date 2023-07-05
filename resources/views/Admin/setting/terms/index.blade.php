@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}} | الشروط و الاحكام
@endsection
@section('page_name') الشروط و الاحكام @endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="modal-body">
                <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('update_terms',$terms->id)}}" >
                    @csrf
{{--                            @method('put')--}}
                    <input type="hidden" value="{{$terms->id}}" name="id">
                    <div class="form-group">
                        <label for="name" class="form-control-label">الشروط و الاحكام بالعربية</label>
                        <textarea name="terms_ar" class="form-control editor" id="terms_ar">{{$terms->terms_ar}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">الشروط و الاحكام بالانجليزية</label>
                        <textarea name="terms_en" class="form-control editor" id="terms_en">{{$terms->terms_en}}</textarea>
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
            {data: 'terms_ar', name: 'terms_ar'},
            {data: 'terms_en', name: 'terms_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('setting.terms')}}', columns);
        // Delete Using Ajax
        {{--deleteScript('{{route('delete_setting')}}');--}}
        {{--// Add Using Ajax--}}
        showAddModal('{{route('setting.terms')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('setting.terms')}}');
        editScript();
    </script>
    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
        }
    </script>
@endsection



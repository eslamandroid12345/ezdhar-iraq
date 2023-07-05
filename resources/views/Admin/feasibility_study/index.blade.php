@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}} | دراسة الجدوي
@endsection
@section('page_name') دراسة الجدوي @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> دراسة الجدوي {{($setting->title) ?? ''}}</h3>
                    <div class="">
{{--                        <button class="btn btn-secondary btn-icon text-white addBtn">--}}
{{--									<span>--}}
{{--										<i class="fe fe-plus"></i>--}}
{{--									</span> اضافة جديد--}}
{{--                        </button>--}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">نوع دراسة الجدوي</th>
                                <th class="min-w-50px">الصورة</th>
                                <th class="min-w-50px">اسم المشروع</th>
                                <th class="min-w-50px">التقييم</th>
                                <th class="min-w-50px">ملاحظات</th>
                                <th class="min-w-50px">التفاصيل</th>
                                <th class="min-w-50px">عرض المشروع</th>
                                <th class="min-w-50px">المستخدم</th>
                                <th class="min-w-50px rounded-end">العمليات</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete MODAL -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف بيانات</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>هل انت متأكد من حذف البيانات التالية <span id="title" class="text-danger"></span>؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">
                            اغلاق
                        </button>
                        <button type="button" class="btn btn-danger" id="delete_btn">حذف !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->

        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">البيانات </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- Create Or Edit Modal -->
    </div>
    @include('Admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'feasibility_type_id', name: 'feasibility_type_id'},
            {data: 'img', name: 'img'},
            {data: 'project_name', name: 'project_name'},
            {data: 'ownership_rate', name: 'ownership_rate'},
            {data: 'note', name: 'note'},
            {data: 'details', name: 'details'},
            {data: 'show', name: 'show'},
            {data: 'user_id', name: 'user_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('feasibility_study.index')}}', columns);
        // Delete Using Ajax
        deleteScript('{{route('delete_feasibility_study')}}');
        // Add Using Ajax
        showAddModal('{{route('feasibility_study.create')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('feasibility_study.edit',':id')}}');
        editScript();
    </script>
@endsection



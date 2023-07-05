@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}}  | الاقسام الفرعية
@endsection
@section('page_name')
الاقسام الفرعية
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> الاقسام الفرعية {{($setting->title) ?? ''}}</h3>
                    <div class="">
                        <button class="btn btn-secondary btn-icon text-white addBtn">
									<span>
										<i class="fe fe-plus"></i>
									</span> اضافة جديد
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-wrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">NO</th>
                                <th class="min-w-50px">الصورة</th>
                                <th class="min-w-50px">الاسم بالعربية</th>
                                <th class="min-w-125px">الاسم بالانجليزية</th>
                                <th class="min-w-25px">القسم</th>
{{--                                <th class="min-w-50px">شروط التقدم بالعربية</th>--}}
{{--                                <th class="min-w-50px">شروط التقدم بالانجليزية</th>--}}
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
                        <h5 class="modal-title" id="example-Modal3">بيانات القسم</h5>
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
            {data: 'image', name: 'image'},
            {data: 'title_ar', name: 'title_ar'},
            {data: 'title_en', name: 'title_en'},
            {data: 'category_id', name: 'category_id'},
            // {data: 'terms_ar', name: 'terms_ar'},
            // {data: 'terms_en', name: 'terms_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('subcategories.index')}}', columns);
        // Delete Using Ajax
        deleteScript('{{route('delete_subcategory')}}');
        // Add Using Ajax
        showAddModal('{{route('subcategories.create')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('subcategories.edit',':id')}}');
        editScript();
    </script>
@endsection



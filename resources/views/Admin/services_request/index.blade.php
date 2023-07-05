@extends('Admin/layouts/master')

@section('title')
    {{($setting->title) ?? ''}} | طلب خدمة
@endsection
@section('page_name') طلب خدمة @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> طلب خدمة {{($setting->title) ?? ''}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-25px">مقدم الخدمة</th>
                                <th class="min-w-25px">العميل</th>
                                <th class="min-w-25px">القسم</th>
{{--                                <th class="min-w-25px">السعر</th>--}}
{{--                                <th class="min-w-25px">تاريخ التسليم</th>--}}
{{--                                <th class="min-w-25px">التفاصيل</th>--}}

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
            <div class="modal-dialog" style="max-width: 635px !important;" role="document">
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
            {data: 'provider_id', name: 'provider_id'},
            {data: 'user_id', name: 'user_id'},
            {data: 'sub_category_id', name: 'sub_category_id'},
            // {data: 'price', name: 'price'},
            // {data: 'delivery_date', name: 'delivery_date'},
            // {data: 'details', name: 'details'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('services.index')}}', columns);
        // Delete Using Ajax
        deleteScript('{{route('delete_services')}}');


        var loader = `
			<div class="dimmer active">
			<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
			</div>
        `;

        function showModal(routeOfEdit){
            $(document).on('click', '.showBtn', function () {
                var id = $(this).data('id')
                var url = routeOfEdit;
                url = url.replace(':id', id)
                $('#modal-body').html(loader)
                $('#editOrCreate').modal('show')

                setTimeout(function () {
                    $('#modal-body').load(url)
                }, 500)
            })
        }

        showModal('{{route('show_service',':id')}}');
    </script>
@endsection



<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data"
          action="{{ route('users_freelancer_store')}}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">صورة</label>
            <input type="file" class="dropify" name="image" data-default-file="{{asset('assets/uploads/avatar.png')}}"
                   accept="image/png,image/webp , image/gif, image/jpeg,image/jpg"/>
            <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg, jpg,webp</span>
            <script>
                $('.dropify').dropify()
            </script>
        </div>

        <input type="hidden" name="user_type" value="freelancer">

        <div class="row">
            <div class="col-6">
                <label for="name" class="form-control-label">الاسم الأول</label>
                <input type="text" class="form-control" name="first_name" id="name">
            </div>
            <div class="col-6">
                <label for="name" class="form-control-label">الاسم الأخير</label>
                <input type="text" class="form-control" name="last_name" id="last_name">
            </div>
        </div>

        <div class="row" style="margin-top: 13px !important; margin-bottom: 13px">
            <div class="col-2">
                <label for="name" class="form-control-label">كود البلد</label>
                <input type="tel" maxlength="5" class="form-control" placeholder="+xxx" name="phone_code" id="name">
            </div>
            <div class="col-8">
                <label for="name" class="form-control-label">الهاتف</label>
                <input type="tel" maxlength="13" class="form-control" name="phone" id="name"
                       style="width: 127% !important;">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">البريد الاكتروني</label>
            <input type="email" class="form-control" name="email" id="name">
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">القسم</label>
            <select class="form-control" name="category_id">
                <option class="form-control" selected disabled>اختر القسم</option>
                @foreach($categories as $category)
                    <option class="form-control" value="{{ $category->id }}">{{ $category->title_ar }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">المدينة</label>
            <input class="form-control" name="city_id" type="text" list="city-list"
                   class="form-control" placeholder="ابحث عن المدينة بالاسم او ID">
            <datalist id="city-list">
                @foreach($cities as $city)
                    <option class="form-control" id="city" value="{{ $city->id }}">{{ $city->city_name_ar }}</option>
                @endforeach
            </datalist>
            <span id="error" class="text-danger"></span>
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">تاريخ الميلاد</label>
            <input type="date" class="form-control" name="birthdate" id="name">
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">سنين الخبرة</label>
            <input type="number" class="form-control" name="years_ex" id="name">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">الوصف</label>
            <input type="text" class="form-control" name="bio" id="name">
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>

    </form>
</div>

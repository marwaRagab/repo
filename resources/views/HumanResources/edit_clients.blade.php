<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> تعديل العميل </h4>
    </div>
    <div class="card-body">

        <form class="mega-vertical" action="{{ route('clients.update', $client->client_old->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->client_old->id }}">

            <div class="form-row flex-wrap d-flex gap-3 p-3 border mt-3">
                <div class="form-group">
                    <label class="form-label"> الإسم
                        بالعربية</label>
                    <input type="text" name="name_ar" value="{{ $client->client_old->name_ar }}"
                        class="form-control" />

                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"> الإسم
                            بالانجليزية</label>
                        <input type="text" name="name_en" value="{{ $client->client_old->name_en }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"> الرقم المدني</label>
                    <input type="text" name="civil_number" value="{{ $client->client_old->civil_number }}"
                        class="form-control" />
                </div>
                <input type="hidden" name="">
                <div class="form-group">
                    <label class="form-label"> الجنس</label>
                    <select class="form-select" name="gender">
                        <option value="male" {{ $client->client_old->gender == 'male' ? 'selected' : '' }}>
                            ذكر
                        </option>
                        <option value="female" {{ $client->client_old->gender == 'female' ? 'selected' : '' }}>
                            انثى
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label"> الجنسية</label>
                    <select class="form-select" name="nationality_id">
                        <option disabled selected>اختر الجنسية
                        </option>
                        @foreach ($nationalities as $nationality)
                            <option value="{{ $nationality->id }}"
                                {{ $client->client_old->nationality_id == $nationality->id ? 'selected' : '' }}>
                                {{ $nationality->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_date">تاريخ
                        الميلاد</label>
                    <input type="date" name="birth_date" value="{{ $client->birth_date }}" class="form-control mb-2"
                        id="edit_date">
                </div>
                <div class="form-group">
                    <label class="form-label"> الهاتف</label>
                    <input type="text" name="phone" value="{{ $client->phone }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="form-label"> البريد
                        الالكترونى</label>
                    <input type="email" name="email" value="{{ $client->email }}" class="form-control" />
                </div>
                <div class="form-group">

                    <label class="form-label"> هاتف العمل</label>
                    <input type="text" name="phone_work" value="{{ $client->phone_work }}" class="form-control" />


                </div>



                <div class="form-group">

                    <label class="form-label"> هاتف اقرب
                        شخص</label>
                    <input type="text" name="nearist_phone" value="{{ $client->phone_work }}"
                        class="form-control" />

                </div>


                <div class="form-group">

                    <label class="form-label"> الهاتف
                        الارضي</label>
                    <input type="text" name="phone_land" value="{{ $client->phone_land }}" class="form-control" />

                </div>
                <div class="form-group">

                    <label class="form-label"> الرقم الالي</label>
                    <input type="text" name="house_id" value="{{ $client->client_old->house_id }}"
                        class="form-control" />

                </div>


                <div class="form-group">

                    <label class="form-label"> القطعة</label>
                    <input type="text" name="block" value="{{ $client->block }}" class="form-control" />

                </div>
                <div class="form-group">

                    <label class="form-label"> شارع</label>
                    <input type="text" name="street" value="{{ $client->street }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="form-label"> جادة</label>
                    <input type="text" name="jada" value="{{ $client->jada }}" class="form-control" />
                </div>
                <div class="form-group">

                    <label class="form-label"> مبنى</label>
                    <input type="text" name="building" value="{{ $client->building }}" class="form-control" />
                </div>
                <div class="form-group">

                    <label class="form-label"> الدور</label>
                    <input type="text" name="floor" value="{{ $client->floor }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="form-label"> المنزل</label>
                    <input type="text" name="flat" value="{{ $client->flat }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="form-label"> جهة العمل</label>
                    <select class="form-select" name="ministry_id">
                        <option disabled selected>اختر جهة العمل
                        </option>
                        @foreach ($ministries as $ministry)
                            <option value="{{ $ministry->id }}"
                                {{ $client->client_old->ministry_id == $ministry->id ? 'selected' : '' }}>
                                {{ $ministry->name_ar }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label class="form-label"> المحافظة</label>
                    <select class="form-select" name="governorate_id">
                        <option disabled selected>اختر المحافظة
                        </option>
                        @foreach ($governorates as $governorate)
                            <option value="{{ $governorate->id }}"
                                {{ $client->client_old->governorate_id == $governorate->id ? 'selected' : '' }}>
                                {{ $governorate->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">

                    <label class="form-label"> المنطقة</label>
                    <select class="form-select" name="area_id">
                        <option disabled selected>اختر المنطقة
                        </option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}"
                                {{ $client->area_id == $area->id ? 'selected' : '' }}>
                                {{ $area->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label"> الفرع</label>
                    <select class="form-select" name="branch_id">
                        <option disabled selected>اختر الفرع
                        </option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ $client->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label"> الراتب</label>
                    <input type="text" name="salary" value="  {{ $client->salary }}" class="form-control" />
                </div>


                <div class="form-group">

                    <label class="form-label"> اسم البنك</label>
                    <select class="form-select" name="bank_id">
                        <option disabled selected>اختر البنك
                        </option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ $client->bank_id == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label"> رقم الحساب
                        البنكي</label>
                    <input type="text" name="bank_account_number" value="{{ $client->bank_account_number }}"
                        class="form-control" />

                </div>
                <div class="form-group">

                    <label class="form-label"> صورة شهادة
                        الراتب</label>
                    <input type="file" name="images[0][path]" class="form-control" />
                    <input type="hidden" name="images[0][type]" value="contract" />
                </div>


                <div class="form-group">
                    <label class="form-label"> صورة البطاقة
                        وجه</label>
                    <input type="file" name="images[1][path]" class="form-control" />
                    <input type="hidden" name="images[1][type]" value="personal" />
                </div>

                <div class="form-group">
                    <label class="form-label"> صورة البطاقة
                        ظهر</label>
                    <input type="file" name="images[2][path]" class="form-control" />
                    <input type="hidden" name="images[2][type]" value="working" />
                </div>

                <div class="form-group">
                    <label class="form-label"> صورة استعلام
                        الساينت</label>
                    <input type="file" name="images[3][path]" class="form-control" />
                    <input type="hidden" name="images[3][type]" value="contract" />
                </div>

                <div class="form-group">
                    <label class="form-label"> صورة هوية
                        العمل</label>
                    <input type="file" name="images[4][path]" class="form-control" />
                    <input type="hidden" name="images[4][type]" value="personal" />
                </div>


            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
</div>

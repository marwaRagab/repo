@extends('header.index')
@section('style')

@endsection
@section('content')
<!-- Main Content Wrapper -->

<main class="main-content w-full px-[var(--margin-x)] pb-8">
    <div class="flex items-center justify-between space-x-4 space-x-reverse py-5 lg:py-6">
        <ul class=" flex-wrap items-center space-x-2 space-x-reverse sm:flex">
            <li class="flex items-center space-x-2 space-x-reverse">
                <a class=" transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                    href="#"> الشركات الموردة</a>
                <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </li>
            <li class="text-primary">المنتجات </li>
        </ul>

    </div>

    <div class=" filters ">
        <button
            class="btn border border-info font-medium text-info hover:bg-info hover:text-white focus:bg-info focus:text-white active:bg-info/90 ml-3 mt-3">
            عدد المنتجات ( {{ count($products)}})
        </button>
        <button
            class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90 dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3">
            اجمالي صافي التكلفة ({{ $products->sum('net_price')}})
        </button>
        <button
            class="btn border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 ml-3 mt-3">
            اجمالي سعر البيع ({{ $products->sum('price')}})
        </button>

    </div>
    <div class=" card-custom my-5 flex items-center justify-between">
        <div class="flex ">

            <!-- <a
                class="btn bg-primary font-medium ml-2 text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                طباعة
            </a> -->
            <div x-data="{showModal:false}">
                <button @click="showModal = true"
                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                    اضافة جديد
                </button>

                <template x-teleport="#x-teleport-target">
                    <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                            @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"></div>
                        <div class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                            x-show="showModal" x-transition:enter="easy-out"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="easy-in" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95">
                            <div
                                class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    اضافة جديد </h3>
                                <button @click="showModal = !showModal"
                                    class="btn -ml-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="px-4 py-4 sm:px-5">
                                <form method="POST" action="{{ route('products.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mt-4 space-y-4">
                                        <label class="block">
                                            <span>الشركة الموردة</span>
                                            <select id="company_id" name="company_id"
                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                <option value=" "> اختر </option>
                                                @foreach($companies as $company)
                                                <option value="{{$company->id}}"> {{$company->name_ar}} </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>
                                        <label class="block">
                                            <span>الماركة</span>
                                            <select name="mark_id"
                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                <option value=" "> اختر </option>
                                                @foreach($marks as $mark)
                                                <option value="{{$mark->id}}"> {{$mark->name_ar}} </option>
                                                @endforeach
                                            </select>
                                            @error('mark_id')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>
                                        <label class="block">
                                            <span>الصنف</span>
                                            <select name="class_id"
                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                <option value=" "> اختر </option>
                                                @foreach($classes as $class)
                                                <option value="{{$class->id}}"> {{$class->name_ar}} </option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>
                                        <label class="block">
                                            الموديل
                                            <input name="model"
                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder=" الموديل" type="text" />
                                            @error('model')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>
                                        السعر
                                        <label class="block">
                                            <input name="price"
                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder=" السعر" type="text" />
                                            @error('price')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>
                                        <label class="block">
                                            صافي التكلفة
                                            <input name="net_price"
                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder=" صافي التكلفة" type="text" />
                                            @error('net_price')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </label>

                                        <div class="flex justify-around mt-3">
                                            <label class="block mx-1 mt-3">
                                                <input type="radio" name="number_type" value="barcode" {{ $product->number_type == 1 ? 'checked' : '' }}
                                                    onclick="toggleInput('barcode')" />
                                                الباركود
                                            </label>
                                            <label class="block mt-3  mx-1">
                                                <input type="radio" name="number_type" value="serial" {{ $product->number_type == 2 ? 'checked' : '' }}
                                                    onclick="toggleInput('serial')" />
                                                السريال نمبر
                                            </label>

                                        </div>

                                        <div id="barcodeInput" class="hidden ">
                                            <label class="block w-full mx-1">
                                                الباركود
                                                <input name="number"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                                                    placeholder="الباركود" type="text" />
                                                @error('number')
                                                <div style='color:red'>{{$message}}</div>
                                                @enderror
                                            </label>
                                        </div>

                                        <div id="serialInput" class="hidden ">
                                            <label class="block w-full mx-1">
                                                السريال نمبر
                                                <input name="number"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                                                    placeholder="السريال نمبر" type="text" />
                                                @error('number')
                                                <div style='color:red'>{{$message}}</div>
                                                @enderror
                                            </label>
                                        </div>
                                        <div class=" space-x-reverse space-x-2 text-right">
                                            <button @click="showModal = false"
                                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                إلغاء
                                            </button>
                                            <button type="submit"
                                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                حفظ
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>
        <div class="flex">
            <div class="flex items-center" x-data="{isInputActive:false}">
                <label class="block">
                    <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                        :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                        class="form-input bg-transparent px-1 text-left transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                        placeholder="Search here..." type="text" />
                </label>
                <button @click="isInputActive = !isInputActive"
                    class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="  is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="is-hoverable w-full text-right">
                <thead>
                    <tr>
                        <th
                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            التسلسل
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الماركة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الموديل
                        </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الصنف
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الباركود </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الكلي
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            المتوفر
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            صافي التكلفة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            سعر البيع </th>
                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            عمليات </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <p>{{ $loop->index + 1 }}</p>
                        </td>
                        <td class="whitespace-nowrap  py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-2">
                            <h5>{{ $product->mark->name_ar }}</h5>
                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5> {{ $product->model }}</h5>
                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5>{{ $product->mark->name_ar }} </h5>
                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5>{{ $product->barcode }}</h5>
                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5> - </h5>
                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5> - </h5>

                        </td>
                        <td class="whitespace-nowrap  py-3 sm:px-5">
                            <h5>{{ $product->net_price }}</h5>

                        </td>
                        <td class="whitespace-nowrap px-2 py-3 sm:px-5">
                            <h5>{{ $product->price }}</h5>
                        </td>
                        <td class="whitespace-nowrap px-2 py-3 sm:px-5">
                            <a>
                                <div x-data="{editModal:false}">
                                    <button @click="editModal = true">
                                        <i class="fa-solid fa-pen-to-square text-info"></i>
                                    </button>

                                    <template x-teleport="#x-teleport-target">
                                        <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                            x-show="editModal" role="dialog" @keydown.window.escape="editModal = false">
                                            <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                                @click="editModal = false" x-show="editModal"
                                                x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"></div>
                                            <div class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                                                x-show="editModal" x-transition:enter="easy-out"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="easy-in"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95">
                                                <div
                                                    class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                                        تعديل
                                                    </h3>
                                                    <button @click="editModal = !editModal"
                                                        class="btn -ml-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="px-4 py-4 sm:px-5">
                                                    <div class="mt-4 space-y-4">
                                                        <label class="block w-full">
                                                            <span>الشركة الموردة </span>
                                                            <select
                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                <option>الشركة </option>
                                                                <option>الشركة</option>
                                                                <option>الشركة</option>
                                                            </select>
                                                        </label>
                                                        <label class="block">
                                                            <span> الماركة </span>
                                                            <select
                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                <option>الماركة </option>
                                                                <option>الماركة</option>
                                                                <option>الماركة</option>
                                                            </select>
                                                        </label>
                                                        <label class="block">
                                                            <span> الصنف </span>
                                                            <select
                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                <option>الصنف </option>
                                                                <option>الصنف</option>
                                                                <option>الصنف</option>
                                                            </select>
                                                        </label>
                                                        <label class="block">
                                                            الموديل
                                                            <input
                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                placeholder="الموديل" type="text" />
                                                        </label>
                                                        <label class="block">
                                                            السعر
                                                            <input
                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                placeholder="السعر" type="text" />
                                                        </label>
                                                        <label class="block">
                                                            السيريال او الباركود
                                                            <input
                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                placeholder="" type="text" />
                                                        </label>
                                                        <label class="block">
                                                            صافي التكلفة
                                                            <input
                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                placeholder="صافس التكلفة" type="text" />
                                                        </label>
                                                        <div class=" space-x-reverse space-x-2 text-right">
                                                            <button @click="editModal = false"
                                                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                                إلغاء
                                                            </button>
                                                            <button @click="editModal = false"
                                                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                                تعديل
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" >
                                @method('DELETE')
                                @csrf
                                <button 
                                    type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('delete') }}"
                                    onclick="return confirm('هل انت متاكد من حذف هذا العنصر');" class="me-2"><i
                                        data-feather="trash-2" width="15" height='15'></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
            <div class="flex items-center space-x-2 space-x-reverse text-xs+">
                <span>عرض</span>
                <label class="block">
                    <select
                        class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pl-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </label>
                <span>الصفحات</span>
            </div>

            <ol class="pagination">
                <li class="rounded-r-lg bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">1</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">2</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">3</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">4</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">5</a>
                </li>
                <li class="rounded-l-lg bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
            </ol>

            <div class="text-xs+">1 - 10 of 10 entries</div>
        </div>
    </div>
    </div>
    </div>
</main>

<script src="{{ asset('asset\js\style.js')}}"></script>
@endsection
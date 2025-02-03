<style>
    /* 🌳 Tree Container */
    #permissions-container {
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        width: 100%;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        overflow: auto; /* Ensure it expands with content */
    }

    /* 📝 Tree Structure */
    .tree {
        list-style-type: none;
        padding: 0;
        direction: rtl;
        text-align: right;
    }

    /* 🌟 Parent Nodes */
    .tree > ul > li {
        font-weight: bold;
        color: #ffffff;
        background: linear-gradient(135deg, #007bff, #0056b3);
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        transition: background 0.3s;
        position: relative;
    }

    /* 🟡 Hover Effects */
    .tree > ul > li:hover {
        background: linear-gradient(135deg, #0056b3, #004094);
    }

    /* 🔗 Tree Lines */
    .tree ul.child-tree {
        padding-right: 20px;
        border-right: 3px dashed #a1c5eb;
        margin-right: 12px;
        display: none;
    }

    /* 🌱 Child Nodes */
    .tree li {
        margin: 6px 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        display: flow;
        align-items: center;
        transition: background 0.3s;
        position: relative;
    }

    /* 🔘 Hover Effect */
    .tree li:hover {
        background: #e9ecef;
    }

    /* 🔼 Expand/Collapse Arrows */
    .tree .toggle-arrow {
        cursor: pointer;
        color: black;
        font-size: 18px;
        margin-left: 8px;
        transition: transform 0.3s ease-in-out;
    }

    /* ⬇ Rotate Arrow on Open */
    .tree li.open .toggle-arrow {
        transform: rotate(90deg);
    }

    /* ✅ Checkbox Styling */
    .tree input[type="checkbox"] {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid #007bff;
        background: #ffffff;
        position: relative;
        cursor: pointer;
        margin-left: 12px;
        transition: background 0.2s, border 0.2s;
    }

    /* 🟢 Checkbox Checked */
    .tree input[type="checkbox"]:checked {
        background: #007bff;
        border: 2px solid #0056b3;
    }

    /* ⚠ Checkbox Indeterminate */
    .tree input[type="checkbox"]:indeterminate {
        background: #ffcc00;
        border-color: #ffa500;
    }

    /* ✔ Checkmark */
    .tree input[type="checkbox"]::after {
        content: "✔";
        position: absolute;
        color: white;
        font-size: 16px;
        font-weight: bold;
        left: 3px;
        top: -2px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    /* 🎯 Show Checkmark */
    .tree input[type="checkbox"]:checked::after {
        opacity: 1;
    }
    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<form action="{{ $formAction }}" method="POST">
    @csrf
    @if(isset($role)) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">الإسم بالعربية <span class="text-danger">*</span></label>
                <input type="text" name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar', $role->name_ar ?? '') }}" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">الإسم بالإنجليزية <span class="text-danger">*</span></label>
                <input type="text" name="name_en" id="name_en" class="form-control" value="{{ old('name_en', $role->name ?? '') }}" required />
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label>الصلاحيات</label>
        <div id="permissions-container">
            {!! $permissionsTableHTML !!}
        </div>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary">حفظ</button>
        <a href="{{ route('roles.index') }}" class="btn bg-danger-subtle text-danger ms-2">الغاء</a>
    </div>
</form>

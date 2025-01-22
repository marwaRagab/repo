// 
//    File export                              //
// 

$("#file_export").DataTable({
  dom: "Bfrtip",
  buttons: ["copy", "csv", "excel", "pdf", "print"],
  "language": {
    "loadingRecords": "جارٍ التحميل...",
    "lengthMenu": "أظهر _MENU_ مدخلات",
    "zeroRecords": "لم يعثر على أية سجلات",
    "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
    "search": "ابحث:",
    "paginate": {
        "first": "الأول",
        "previous": "السابق",
        "next": "التالي",
        "last": "الأخير"
    },
    "aria": {
        "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
        "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
    },
    "select": {
        "rows": {
            "_": "%d قيمة محددة",
            "1": "1 قيمة محددة"
        },
        "cells": {
            "1": "1 خلية محددة",
            "_": "%d خلايا محددة"
        },
        "columns": {
            "1": "1 عمود محدد",
            "_": "%d أعمدة محددة"
        }
    },
    "buttons": {
        "print": "طباعة",
        "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
        "pageLength": {
            "-1": "اظهار الكل",
            "_": "إظهار %d أسطر",
            "1": "اظهار سطر واحد"
        },
        "collection": "مجموعة",
        "copy": "نسخ",
        "copyTitle": "نسخ إلى الحافظة",
        "csv": "CSV",
        "excel": "Excel",
        "pdf": "PDF",
        "colvis": "إظهار الأعمدة",
        "colvisRestore": "إستعادة العرض",
        "copySuccess": {
            "1": "تم نسخ سطر واحد الى الحافظة",
            "_": "تم نسخ %ds أسطر الى الحافظة"
        },
        "createState": "تكوين حالة",
        "removeAllStates": "ازالة جميع الحالات",
        "removeState": "ازالة حالة",
        "renameState": "تغيير اسم حالة",
        "savedStates": "الحالات المحفوظة",
        "stateRestore": "استرجاع حالة",
        "updateState": "تحديث حالة"
    },
    "searchBuilder": {
        "add": "اضافة شرط",
        "clearAll": "ازالة الكل",
        "condition": "الشرط",
        "data": "المعلومة",
        "logicAnd": "و",
        "logicOr": "أو",
        "value": "القيمة",
        "conditions": {
            "date": {
                "after": "بعد",
                "before": "قبل",
                "between": "بين",
                "empty": "فارغ",
                "equals": "تساوي",
                "notBetween": "ليست بين",
                "notEmpty": "ليست فارغة",
                "not": "ليست "
            },
            "number": {
                "between": "بين",
                "empty": "فارغة",
                "equals": "تساوي",
                "gt": "أكبر من",
                "lt": "أقل من",
                "not": "ليست",
                "notBetween": "ليست بين",
                "notEmpty": "ليست فارغة",
                "gte": "أكبر أو تساوي",
                "lte": "أقل أو تساوي"
            },
            "string": {
                "not": "ليست",
                "notEmpty": "ليست فارغة",
                "startsWith": " تبدأ بـ ",
                "contains": "تحتوي",
                "empty": "فارغة",
                "endsWith": "تنتهي ب",
                "equals": "تساوي",
                "notContains": "لا تحتوي",
                "notStartsWith": "لا تبدأ بـ",
                "notEndsWith": "لا تنتهي بـ"
            },
            "array": {
                "equals": "تساوي",
                "empty": "فارغة",
                "contains": "تحتوي",
                "not": "ليست",
                "notEmpty": "ليست فارغة",
                "without": "بدون"
            }
        },
        "button": {
            "0": "فلاتر البحث",
            "_": "فلاتر البحث (%d)"
        },
        "deleteTitle": "حذف فلاتر",
        "leftTitle": "محاذاة يسار",
        "rightTitle": "محاذاة يمين",
        "title": {
            "0": "البحث المتقدم",
            "_": "البحث المتقدم (فعال)"
        }
    },
    "searchPanes": {
        "clearMessage": "ازالة الكل",
        "collapse": {
            "0": "بحث",
            "_": "بحث (%d)"
        },
        "count": "عدد",
        "countFiltered": "عدد المفلتر",
        "loadMessage": "جارِ التحميل ...",
        "title": "الفلاتر النشطة",
        "showMessage": "إظهار الجميع",
        "collapseMessage": "إخفاء الجميع",
        "emptyPanes": "لا يوجد مربع بحث"
    },
    "infoThousands": ",",
    "datetime": {
        "previous": "السابق",
        "next": "التالي",
        "hours": "الساعة",
        "minutes": "الدقيقة",
        "seconds": "الثانية",
        "unknown": "-",
        "amPm": [
            "صباحا",
            "مساءا"
        ],
        "weekdays": [
            "الأحد",
            "الإثنين",
            "الثلاثاء",
            "الأربعاء",
            "الخميس",
            "الجمعة",
            "السبت"
        ],
        "months": [
            "يناير",
            "فبراير",
            "مارس",
            "أبريل",
            "مايو",
            "يونيو",
            "يوليو",
            "أغسطس",
            "سبتمبر",
            "أكتوبر",
            "نوفمبر",
            "ديسمبر"
        ]
    },
    "editor": {
        "close": "إغلاق",
        "create": {
            "button": "إضافة",
            "title": "إضافة جديدة",
            "submit": "إرسال"
        },
        "edit": {
            "button": "تعديل",
            "title": "تعديل السجل",
            "submit": "تحديث"
        },
        "remove": {
            "button": "حذف",
            "title": "حذف",
            "submit": "حذف",
            "confirm": {
                "_": "هل أنت متأكد من رغبتك في حذف السجلات %d المحددة؟",
                "1": "هل أنت متأكد من رغبتك في حذف السجل؟"
            }
        },
        "error": {
            "system": "حدث خطأ ما"
        },
        "multi": {
            "title": "قيم متعدية",
            "restore": "تراجع",
            "info": "القيم المختارة تحتوى على عدة قيم لهذا المدخل. لتعديل وتحديد جميع القيم لهذا المدخل، اضغط او انتقل هنا، عدا ذلك سيبقى نفس القيم",
            "noMulti": "هذا المدخل مفرد وليس ضمن مجموعة"
        }
    },
    "processing": "جارٍ المعالجة...",
    "emptyTable": "لا يوجد بيانات متاحة في الجدول",
    "infoEmpty": "يعرض 0 إلى 0 من أصل 0 مُدخل",
    "thousands": ".",
    "stateRestore": {
        "creationModal": {
            "columns": {
                "search": "إمكانية البحث للعمود",
                "visible": "إظهار العمود"
            },
            "toggleLabel": "تتضمن",
            "button": "تكوين الحالة",
            "name": "اسم الحالة",
            "order": "فرز",
            "paging": "تصحيف",
            "scroller": "مكان السحب",
            "search": "بحث",
            "searchBuilder": "مكون البحث",
            "select": "تحديد",
            "title": "تكوين حالة جديدة"
        },
        "duplicateError": "حالة مكررة بنفس الاسم",
        "emptyError": "لا يسمح بأن يكون اسم الحالة فارغة.",
        "emptyStates": "لا توجد حالة محفوظة",
        "removeConfirm": "هل أنت متأكد من حذف الحالة %s؟",
        "removeError": "لم استطع ازالة الحالة.",
        "removeJoiner": "و",
        "removeSubmit": "حذف",
        "removeTitle": "حذف حالة",
        "renameButton": "تغيير اسم حالة",
        "renameLabel": "الاسم الجديد للحالة %s:",
        "renameTitle": "تغيير اسم الحالة"
    },
    "autoFill": {
        "cancel": "إلغاء الامر",
        "fill": "املأ كل الخلايا بـ <i>%d<\/i>",
        "fillHorizontal": "تعبئة الخلايا أفقيًا",
        "fillVertical": "تعبئة الخلايا عموديا",
        "info": "تعبئة تلقائية"
    },
    "decimal": ",",
    "infoFiltered": "(مرشحة من مجموع _MAX_ مُدخل)",
    "searchPlaceholder": "مثال بحث"
  }
});
$(
  ".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel"
).addClass("btn btn-warning");

// 
//  Show / hide columns dynamically                 //
// 

var table = $("#show_hide_col").DataTable({
  scrollY: "200px",
  paging: false,
});

$("a.toggle-vis").on("click", function (e) {
  e.preventDefault();

  // Get the column API object
  var column = $("#show_hide_col")
    .dataTable()
    .api()
    .column($(this).attr("data-column"));
  // Toggle the visibility
  column.visible(!column.visible());
});

// 
//    Column rendering                         //
// 
$("#col_render").DataTable({
  columnDefs: [
    {
      // The `data` parameter refers to the data for the cell (defined by the
      // `data` option, which defaults to the column being worked with, in
      // this case `data: 0`.
      render: function (data, type, row) {
        return data + " (" + row[3] + ")";
      },
      targets: 0,
    },
    { visible: false, targets: [3] },
  ],
});

// 
//     Row grouping                            //
// 
var table = $("#row_group").DataTable({
  pageLength: 10,
  columnDefs: [{ visible: false, targets: 2 }],
  order: [[2, "asc"]],
  displayLength: 25,
  drawCallback: function (settings) {
    var api = this.api();
    var rows = api.rows({ page: "current" }).nodes();
    var last = null;

    api
      .column(2, { page: "current" })
      .data()
      .each(function (group, i) {
        if (last !== group) {
          $(rows)
            .eq(i)
            .before(
              '<tr class="group"><td colspan="5">' + group + "</td></tr>"
            );

          last = group;
        }
      });
  },
});

// 
// Order by the grouping
// 
$("#row_group tbody").on("click", "tr.group", function () {
  var currentOrder = table.order()[0];
  if (currentOrder[0] === 2 && currentOrder[1] === "asc") {
    table.order([2, "desc"]).draw();
  } else {
    table.order([2, "asc"]).draw();
  }
});

// 
//    Multiple table control element           //
// 
$("#multi_control").DataTable({
  dom: '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
});

// 
//    DOM/jquery events                        //
// 
var table = $("#dom_jq_event").DataTable();

$("#dom_jq_event tbody").on("click", "tr", function () {
  var data = table.row(this).data();
  alert("You clicked on " + data[0] + "'s row");
});

// 
//    Language File                            //
// 
$("#lang_file").DataTable({
  language: {
    url: "../../assets/js/datatable/German.json",
  },
});

// 
//    Complex headers with column visibility   //
// 

$("#complex_head_col").DataTable({
  columnDefs: [
    {
      visible: false,
      targets: -1,
    },
  ],
});

// 
//    Setting defaults                         //
// 
var defaults = {
  searching: false,
  ordering: false,
};

$("#setting_defaults").dataTable($.extend(true, {}, defaults, {}));

// 
//    Footer callback                          //
// 
$("#footer_callback").DataTable({
  footerCallback: function (row, data, start, end, display) {
    var api = this.api(),
      data;

    // Remove the formatting to get integer data for summation
    var intVal = function (i) {
      return typeof i === "string"
        ? i.replace(/[\$,]/g, "") * 1
        : typeof i === "number"
        ? i
        : 0;
    };

    // Total over all pages
    total = api
      .column(4)
      .data()
      .reduce(function (a, b) {
        return intVal(a) + intVal(b);
      }, 0);

    // Total over this page
    pageTotal = api
      .column(4, { page: "current" })
      .data()
      .reduce(function (a, b) {
        return intVal(a) + intVal(b);
      }, 0);

    // Update footer
    $(api.column(4).footer()).html(
      "$" + pageTotal + " ( $" + total + " total)"
    );
  },
});

// 
//    Custom toolbar elements                  //
// 

$("#custom_tool_ele").DataTable({
  dom: '<"toolbar">frtip',
});

$("div.toolbar").html("<b>Custom tool bar! Text/images etc.</b>");

// 
//    Row created callback                     //
// 
$("#row_create_call").DataTable({
  createdRow: function (row, data, index) {
    if (data[5].replace(/[\$,]/g, "") * 1 > 150000) {
      $("td", row).eq(5).addClass("highlight");
    }
  },
});
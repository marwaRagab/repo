<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>كشف حساب </title>
    <!-- Cairo Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet"/>
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ asset('template/layout/plugins/images/login_img.jpeg')}}">
    <!-- Bootstrap-->


    <link rel="stylesheet"
          href="{{ asset('template/layout/invoice_assets/vendor/bootstrap/css/bootstrap.min.css')}}"
          type="text/css"/>
    <link rel="stylesheet"
          href="{{ asset('template/layout/invoice_assets/vendor/bootstrap/css/bootstrap.min.css.map')}}"
          type="text/css"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('template/layout/invoice_assets/styles/styles.css')}}"/>

    <style type="text/css">
        /* @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
            }*/



        .print-section {
            width: 100%;


        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        td {
            min-width: 250px;
        }

        tbody {
            width: 100%;
        }

        table {
            table-layout: fixed;
            width: 100%;
        }

        tr {
            width: 100%;
        }

        @page {
            size: A4;

            margin-top: 5px;
            margin-bottom: 5px;
        }

        thead.report-header {
            display: table-header-group;
        }

        body {
            padding: 0px 50px;
        }
        @media print {
            .page {
                page-break-after: always;
            }}
    </style>
</head>

<body>
<script type="text/javascript">
    window.onload = addPageNumbers;
    onClick = "document.title = "
    My
    new title
    ";window.print();"


    // function addPageNumbers() {
    //     var totalPages = Math.ceil(document.body.scrollHeight /
    //         1123); //842px A4 pageheight for 72dpi, 1123px A4 pageheight for 96dpi,
    //     for (var i = 1; i <= totalPages; i++) {
    //         var pageNumberDiv = document.createElement("div");
    //         var pageNumber = document.createTextNode("Page " + i);
    //         pageNumberDiv.style.position = "absolute";
    //         pageNumberDiv.style.textAlign = "center";
    //         pageNumberDiv.style.marginTop = "80px";
    //         pageNumberDiv.style.marginBottom = "3px";
    //         pageNumberDiv.style.fontSize = "14px";
    //         pageNumberDiv.style.fontWeight = "500";
    //         pageNumberDiv.style.color = "#000";

    //         pageNumberDiv.style.top = "calc((" + i +
    //             " * (296mm - 0.5px)) - 25px)"; //297mm A4 pageheight; 0,5px unknown needed necessary correction value; additional wanted 40px margin from bottom(own element height included)
    //         pageNumberDiv.style.height = "10px";
    //         pageNumberDiv.appendChild(pageNumber);
    //         document.body.insertBefore(pageNumberDiv, document.getElementById("content"));
    //         pageNumberDiv.style.left = "calc(50% - (" + pageNumberDiv.offsetWidth + "px + 10px))";
    //     }
    // }
</script>

<style type="text/css">
    .itemtext {
        direction: rtl;
    }
    /* @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
        }*/


    .print-section {
        width: 100%;


    }

    .center {
        margin-left: auto;
        margin-right: auto;
    }

    td {
        min-width: 250px;
    }

    tbody {
        width: 100%;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    tr {
        width: 100%;
    }

    @page {
        size: A4;

        margin-top: 5px;
        margin-bottom: 5px;
    }

    thead.report-header {
        display: table-header-group;
    }

    body {
        padding: 0px 50px;
    }
    @media print {
        .page {
            page-break-after: always;
        }}
    /* @media print {
        div.fix-break-print-page {
            page-break-inside: avoid;
        }

        .print {
            display: block;
        }
    }

    .print:last-child {
        page-break-after: auto;
    }

    footer {
        clear: both;
        position: relative;
        height: 40px;
        margin-top: -40px;
    } */
</style>
<div class="page" >
    <main>

        <!-- hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh -->
        <header>


            <div class="all d-flex justify-content-between">
                <div class="first">
                    <br> رقم العملية :  <?=   $serial  ?> <br>وقت الطباعة : <?= date('H:i:s')?>
                </div>

                <div class="second"> <?=$title1?></div>
                <div class="first">
                    شركة الكترون <br> تاريخ : <?= date('d-m-Y') ?> <br> <?php  echo $user_name; ?> : اسم المستخدم
                </div>


            </div>





        </header>
        <div class="table-responsive ">
            <table style="font-size: 0.8rem; margin-bottom: 5px;">
                <h1 style="text-align:center">
                    سند قبض

                </h1>
                <tr class="table-data">

                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php echo $installment_month['id'] ?>                                    </p>
                    </td>
                    <td class="item" colspan=3>
                        <h2> رقم السند </h2>
                    </td>
                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php echo  $installment_month['payment_date'] ?> </p>
                    </td>
                    <td class="item" colspan=4>
                        <h2>التاريخ</h2>
                    </td>

                </tr>
                <tr class="table-data">

                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php echo $installment_month['amout'] ?>
                            (<?php echo $first_sum ?>
                            دينار
                            <?php if (strlen($secound_sum) > 3) { ?>
                                و
                                <?php echo $secound_sum ?>
                                فلس
                            <?php } ?>)
                        </p>
                    </td>
                    <td class="item" colspan=3>
                        <h2> المبلغ</h2>
                    </td>
                    <td class="tableitem" colspan=4>
                        <p class="itemtext"><?php echo $client['name'] ?> </p>
                    </td>
                    <td class="item" colspan=4>
                        <h2> اسم العميل</h2>
                    </td>

                </tr>

                <tr class="table-data">

                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php echo $installment_month['installment_id'] ?>                                    </p>
                    </td>
                    <td class="item" colspan=3>
                        <h2> معاملة رقم </h2>
                    </td>
                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php switch ($installment_month['payment_type']) {
                                case "cash":
                                    echo 'كاش';
                                    break;
                                case "knet":
                                    echo 'كي نت';
                                    break;
                                case "cash/knet":
                                    echo 'كاش / كي نت';
                                    break;
                                case "part":
                                    echo 'استقطاع  ';
                                    break;
                                default:
                                    break;
                            } ?></p>
                    </td>
                    <td class="item" colspan=4>
                        <h2>طريقة الدفع</h2>
                    </td>

                </tr>

                <tr class="table-data">

                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php echo $item['not_done_count_lated'] ?>     </p>
                    </td>
                    <td class="item" colspan=3>
                        <h2> عدد الشهور المتأخرة </h2>
                    </td>
                    <td class="tableitem" colspan=4>
                        <p class="itemtext">
                            <?php if ($installment_month['installment_type'] == "first_amount") { ?>
                                المقدم
                            <?php } else { ?>
                                <?php echo  $installment_month['date'] ?>
                            <?php } ?>
                        </p>
                    </td>
                    <td class="item" colspan=4>
                        <h2>قسط شهري</h2>
                    </td>

                </tr>

            </table>
        </div>

        <!--  -->

        <div class="table-responsive "  style="font-size: 0.8rem;" >
            <table class=" table-bordered" >
                <?php $x = 1;
                $n = 1; ?>
                <thead style="text-align: center;">
                <h1 style="text-align:center">
                    اّخر عمليات بكشف الحساب
                </h1>
                <tr class="table-data" >

                    <th class="item" style="width: 50px;">
                        <h2>اليوزر</h2>
                    </th>
                    <th class="item" style="width: 60px;">
                        <h2> البيان طريق الدفع</h2>
                    </th>
                    <th class="item" style="width: 90px;">
                        <h2>رقم العمليه  السند </h2>
                    </th>
                    <th class="item" style="width: 85px;">
                        <h2>التاريخ</h2>
                    </th>
                    <th class="item" style="width: 88px;">
                        <h2>مدين</h2>
                    </th>
                    <th class="item" style="width: 91px;">
                        <h2>دائن</h2>
                    </th>
                    <th class="item" style="width: 95px;">
                        <h2>  الرصيد </h2>
                    </th>

                    <th class="item" style="width: 35px; height: 20px;">
                        <h2 style="padding-block:10px ;">م</h2>
                    </th>
                </tr>
                </thead>

                <tbody >
                <?php if ($n <= 8) { ?>
                    <tr>
                        <?php
                        if ($item['installment_clients'] > 0) {
                            $the_balance = $item['total_madionia'];
                        } else {
                            $the_balance = $total_madionia - ($laws_item_amount ?? 0) + $first_amount;

                        }

                        ?>
                        <td > </td>
                        <td > </td>
                        <td >
                            <br>

                        </td>
                        <td ><?php echo  $item['date'] ?></td>
                        <td ></td>
                        <td ><?php echo number_format(($the_balance), 3, '.', ','); ?></td>
                        <td ><?php echo number_format(($the_balance), 3, '.', ','); ?></td>
                        <td ><?php echo $x;
                            $x++; ?></td>

                    </tr>
                    <?php $n++;
                } ?>
                <?php if (isset($item['months']) && $item['months'] == 24) { ?>
                    <?php if (isset($laws_item_amount) && ($laws_item_amount > 0)) { ?>
                        <?php
                        if ($item['installment_clients'] > 0) {
                            $the_balance = $item['eqrardain_amount'];
                        } else {
                            $the_balance = $total_madionia;
                        }
                        ?>
                        <?php if ($n <= 8) { ?>
                            <!-- //////////////// -->
                            <tr>

                                <td > <?php
                                    $fullname = get_admin_user_name($item['user_id']);

                                    $name = explode(" ", $fullname);
                                    if (isset($name[1])) {
                                        if ($name[0] == 'عبد' || $name[1] == 'عبد') {
                                            echo $name[0];
                                            echo $name[1];
                                            echo $name[2];


                                        } else {
                                            echo $name[0];
                                            echo $name[1];
                                        }
                                    } else {
                                        echo $name[0];
                                    }


                                    ?></td>
                                <td > أتعاب المحامى</td>
                                <td >

                                </td>
                                <td ><?php echo  $item['date'] ?></td>
                                <td ></td>
                                <td ><?php echo number_format(($laws_item_amount), 3, '.', ','); ?></td>
                                <td ><?php echo number_format(($the_balance), 3, '.', ','); ?></td>
                                <td ><?php echo $x;
                                    $x++; ?></td>

                            </tr>
                            <?php $n++;
                        } ?>
                    <?php }
                } ?>
                <?php $total_madionia = $the_balance; ?>
                <?php foreach ($items_done as $item) { ?>
                    <?php if ($item['status'] == 'done') { ?>
                        <?php if ($n <= 8) { ?>
                            <tr>

                                <td > <?php
                                    $fullname = $user_name;

                                    $name = explode(" ", $fullname);
                                    if (isset($name[1])) {
                                        if ($name[0] == 'عبد' || $name[1] == 'عبد') {
                                            echo $name[0];
                                            echo $name[1];
                                            echo $name[2];


                                        } else {
                                            echo $name[0];
                                            echo $name[1];
                                        }
                                    } else {
                                        echo $name[0];
                                    }


                                    ?></td>
                                <td > قسط شهرى <br> <?php
                                        switch ($item['payment_type']) {
                                            case 'cash':
                                                echo '<span class="label label-success font-weight-100 ">'
                                                    . 'دفع يدوي'
                                                    . '</span>';
                                                break;
                                            case 'part':
                                                echo 'دفع رابط';
                                                break;

                                        }

                                        if ($item['installment_type'] == 'discount') {
                                            echo '<span class="label label-warning font-weight-100 ">'
                                                . 'خصم  '
                                                . '</span>';
                                        } ?></br>
                                <td >
                                    <?php  if(isset($item['knet'])){  echo $item['knet'];}  ?> <br> <?php echo $item['id']; ?>
                                </td>
                                <td ><?php echo  $item['payment_date'] ?></td>
                                <td ><?php echo $item['amout']; ?></td>
                                <td > - </td>
                                <td > <?php $total_madionia = $total_madionia - $item["amout"]; ?>
                                    <?php echo number_format(($total_madionia), 3, '.', ','); ?></td>
                                <td ><?php echo $x;
                                    $x++; ?></td>

                            </tr>
                            <?php $n++;
                        } ?>
                    <?php }
                } ?>
                <?php $total_checkat = 0; ?>
                <?php if (!empty($military_affairs_checks)) { ?>

                    <?php foreach ($military_affairs_checks as $military_affairs_check) { ?>
                        <?php $total_checkat = $total_checkat + $military_affairs_check["amount"]; ?>
                        <?php if ($n <= 8) { ?>
                            <tr >
                                <td >

                                    <?php
                                    $fullname = get_admin_user_name($military_affairs_check['deposit_user_id']);

                                    $name = explode(" ", $fullname);
                                    if (isset($name[1])) {
                                        if ($name[0] == 'عبد' || $name[1] == 'عبد') {
                                            echo $name[0];
                                            echo $name[1];
                                            echo $name[2];


                                        } else {
                                            echo $name[0];
                                            echo $name[1];
                                        }
                                    } else {
                                        echo $name[0];
                                    }


                                    ?>

                                </td>

                                <td >
                                    شيك

                                </td>
                                <td >
                                    <?php echo  $military_affairs_check['date'] ?>
                                </td>
                                <td >
                                    <?php echo $military_affairs_check['amount']; ?>

                                </td>
                                <td >
                                    -
                                </td>
                                <td >
                                    -
                                </td>
                                <td >

                                    <?php $total_madionia = $total_madionia - $military_affairs_check["amount"]; ?>
                                    <?php echo number_format(($total_madionia), 3, '.', ','); ?>

                                </td>
                                <td >
                                    <?php echo $x;
                                    $x++; ?>

                                </td>
                            </tr>
                            <?php $n++;
                        } ?>
                    <?php } ?>
                <?php } ?>
                <?php $total_amounts = 0; ?>
                <?php if (!empty($military_affairs_amounts)) { ?>
                    <?php foreach ($military_affairs_amounts as $military_affairs_amount) { ?>
                        <?php $total_amounts = $total_amounts + $military_affairs_amount["amount"]; ?>


                        <?php $total_diff = $total_amounts - $total_checkat; ?>
                        <?php if ($military_affairs_amount['check_type'] != "update") {
                            if ($military_affairs_amount['military_affairs_check_id'] != -1) {

                                ?>
                                <?php if ($total_diff > 0) { ?>
                                    <?php if ($n <= 8) { ?>
                                        <tr class="service">
                                            <td class="tableitem">
                                                <p class="itemtext">
                                                    <?php
                                                    $fullname = get_admin_user_name($military_affairs_amount['user_id']);

                                                    $name = explode(" ", $fullname);
                                                    if (isset($name[1])) {
                                                        if ($name[0] == 'عبد' || $name[1] == 'عبد') {
                                                            echo $name[0];
                                                            echo $name[1];
                                                            echo $name[2];


                                                        } else {
                                                            echo $name[0];
                                                            echo $name[1];
                                                        }
                                                    } else {
                                                        echo $name[0];
                                                    }


                                                    ?>
                                                </p>
                                            </td>

                                            <td class="tableitem">
                                                <p class="itemtext"> <span
                                                        class="label label-danger font-weight-100 ">
                                                    <?php

                                                    switch ($military_affairs_amount['check_type']) {

                                                        case 'salary':
                                                            echo 'حجز راتب';
                                                            break;

                                                        case 'banks':
                                                            echo 'حجز بنوك';
                                                            break;

                                                        case 'cars':
                                                            echo 'حجز سيارة';
                                                            break;

                                                        case 'mahkama_installment':
                                                            echo 'تقسيط محكمة';
                                                            break;

                                                        case 'mahkama_madionia_sadad':
                                                            echo ' سداد مديونية محكمة';
                                                            break;

                                                        default:
                                                            echo '    رصيد تنفيذ';
                                                            break;
                                                    } ?>

                                                </span></p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext">
                                                    <?php echo  $military_affairs_amount['date'] ?>
                                                </p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext">
                                                    <?php echo $military_affairs_amount['amount']; ?>
                                                </p>
                                            </td>

                                            <td class="tableitem">
                                                <p class="itemtext"> -</p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext">
                                                    <?php $total_madionia = $total_madionia - $military_affairs_amount["amount"]; ?>
                                                    <?php echo number_format(($total_madionia), 3, '.', ','); ?>
                                                </p>
                                            </td>
                                            <td class="tableitem">
                                                <p class="itemtext"> <?php echo $x;
                                                    $x++; ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php $n++;
                                    } ?>
                                <?php } ?>
                                <?php
                            } ?>
                            <?php
                        } ?>
                    <?php } ?>
                    <?php if (!empty($installment_discount)) {

                        foreach ($installment_discount as $item_2) { ?>
                            <?php if ($n <= 8) { ?>
                                <tr >
                                    <td >
                                        <?php echo get_admin_user_name($item_2['user_id']); ?>
                                    </td>
                                    <td >
                                        <?php
                                        switch ($item_2['type']) {
                                            case 'income':
                                                echo '<span class="label label-success font-weight-100 ">'
                                                    . 'دفع '
                                                    . '</span>';
                                                break;
                                            case 'expenses_pending':
                                                echo '<span class="label label-warning font-weight-100 ">'
                                                    . 'خصم  '
                                                    . '</span>';
                                                break;
                                            case 'knet':
                                                echo 'دفع رابط';
                                                break;

                                        } ?>
                                    </td>
                                    <td >
                                        <?php echo  $item_2['date'] ?>
                                    </td>

                                    <td >
                                        <?php echo $item_2['amount']; ?>
                                    </td>
                                    <td >
                                        -
                                    </td>
                                    <td >
                                        <?php $total_madionia = $total_madionia - $item_2["amount"]; ?>
                                        <?php echo number_format(($total_madionia), 3, '.', ','); ?>
                                    </td>
                                    <td >
                                        <?php echo $x;
                                        $x++; ?>
                                    </td>
                                </tr>
                                <?php $n++;
                            } ?>
                        <?php }
                    }
                } ?>

                </tbody>
            </table>
        </div>
        <footer>
            <div class="legalcopy  justify-content-between d-sm-flex align-items-center"
                 style="border:none !important;">

                <div style="  position: fixed;bottom: 0; margin-top: 25px;width:100%;text-align:center;
    padding-top: 16px;
    font-size: 14px;
    font-weight: 500;
    color: #000;    border-top: 1px solid #000;">


                    <span>User : </span>
                    <span>

                                            <?php echo $user_name;


                                            ?>
                                        </span>

                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </span>


                    <span>Date</span>
                    <span><?= date('d-m-Y') ?><?php
                        date_default_timezone_set('Asia/Kuwait');
                        $time = date('h:i A');
                        ?><?= $time ?></span>


                </div>
            </div>
        </footer>

    </main>
</div>
<!-- Bootstrap-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src=" {{asset('template/layout/invoice_assets/vendor/bootstrap/js/bootstrap.js')}}">
</script>
<script>
    var win = nw.Window.get();
    alert(win);
    win.print({

        "printer": "Foxit Reader PDF Printer",
        "copies": 5
    });
</script>

</body>

</html>

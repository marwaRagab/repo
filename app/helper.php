<?php

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\FixedPrintData;
use Illuminate\Support\Facades\DB;
use App\Models\InvoicesInstallment;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\military_affairs_deligation;
use App\Models\military_affairs_deligations;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_times;

if (!function_exists('whats_send')) {
    function whats_send($mobile, $message, $country_code)
    {

        // dd("ss");
        //
        $mobile = $country_code . $mobile;
        // dd($mobile);
        $params = array(
            'token' => 'rouxlvet3m3jl0a3',
            'to' => $mobile,
            'body' => $message,
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance31865/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        // dd($err);
        curl_close($curl);
        return $response;
    }
}

if (!function_exists('send_sms_code_msg')) {
    function send_sms_code_msg($msg, $phone, $country_code)
    {
        $phone = $country_code . $phone;
        $url = "http://62.150.26.41/SmsWebService.asmx/send";
        $params = array(
            'username' => 'Electron',
            'password' => 'LZFDD1vS',
            'token' => 'hjazfzzKhahF3MHj5fznngsb',
            'sender' => '7agz',
            'message' => $msg,
            'dst' => $phone,
            'type' => 'text',
            'coding' => 'unicode',
            'datetime' => 'now',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
        }

        // dd($result);
        curl_close($ch);

        // if ($result) {

        //   $status = "success";

        // } else {

        //  // echo $response;
        // }
        // return $status;

    }
}

if (!function_exists('send_sms_code')) {
    function send_sms_code($msg, $phone, $country_code)
    {

        // dd("Ff");
        $response = whats_send($phone, $msg, $country_code);
        //  dd($ff);
        return $response;

        //  send_sms_code_msg($msg, $phone, $country_code);
    }
}
/**
 * Upload Files
 * @path =>physical path to save files in
 * @image => name of file image in database
 * @realname =>real name file in db
 * @model => $model where to save files in
 * @request => the file input request which holds the file uploading
 */

// if (!function_exists('UploadFiles')) {

//     function UploadFiles($path, $image, $realname, $model, $request)
//     {

//         $thumbnail = $request;
//         $destinationPath = $path;
//         $filerealname = $thumbnail->getClientOriginalName();
//         $filename = $model->id . time() . '.' . $thumbnail->getClientOriginalExtension();
//         // $destinationPath = asset($path) . '/' . $filename;
//         $thumbnail->move($destinationPath, $filename);
//         // $thumbnail->resize(1080, 1080);
//         //  $thumbnail = Image::make(public_path() . '/'.$path.'/' . $filename);
//         //Storage::move('public')->put($destinationPath, file_get_contents($thumbnail));

//         $model->$image = asset($path) . '/' . $filename;
//         $model->$realname = asset($path) . '/' . $filerealname;

//         $model->save();
//     }
// }

// function getLatLongFromUrl($url)
// {

//     $shortenerDomains = [
//         'bit.ly',
//         'goo.gl',
//         't.co',
//         'tinyurl.com',
//         'ow.ly',
//         'buff.ly',
//         'is.gd',
//         'tiny.cc',
//         'maps.app.goo.gl',
//         // 'gis.paci.gov.kw'
//     ];

//     // Parse the domain from the URL
//     $host = parse_url($url, PHP_URL_HOST);
//     if (in_array($host, $shortenerDomains) == true) {
//         $ch = curl_init();
//         // dd($ch);
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
//         curl_exec($ch);
//         $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
//         curl_close($ch);
//     }

//     $pattern = '/@([-+]?[\d]*\.?[\d]+),([-+]?[\d]*\.?[\d]+)/';
//     preg_match($pattern, $url, $matches);
//     // dd($matches);
//     if (isset($matches[1]) && isset($matches[2])) {
//         return [
//             'latitude' => $matches[1],
//             'longitude' => $matches[2]
//         ];
//     }

//     return null;
// }

function UploadImage($path, $image, $model, $file)
{
    // Ensure the directory exists
    // if (!file_exists($path)) {
    //     mkdir($path, 0755, true);
    // }

    // Generate a unique filename
    $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Move the uploaded file to the specified directory
    $file->move(public_path($path), $filename);

    // Set the file path in the model
    $model->$image = $path . '/' . $filename;

    // Save the model
    $model->save();
}

// function UploadImage($path, $field, $model, $file)
// {
//     // Define the destination path within the storage/app/public directory
//     $storagePath = 'public/' . $path;

//     // Generate a unique filename
//     $filename = time() . '-' . $file->getClientOriginalName();

//     // Store the file and get the path
//     $filePath = $file->storeAs($storagePath, $filename);

//     // Save the publicly accessible path in the model
//     $model->$field = asset('storage/' . $path . '/' . $filename);

//     // Save the model
//     $model->save();
// }
// function UploadFilesIM($path, $image, $model, $request)
// {

//     // dd($request);

//     $imagePaths = [];
//     $thumbnail = $request;
//     $destinationPath = $path;
//     foreach ($thumbnail as $key => $item) {
//         if (is_object($item)) {
//             $filename = $key . time() . '.' . $item->getClientOriginalExtension();
//             $item->move($destinationPath, $filename);
//             $imagePaths[] = asset($path) . '/' . $filename;
//         } else {
//             $imagePaths[] = $item;
//         }
//     }
//     // dd($model->image);
//     $model->$image = implode(',', $imagePaths);

//     $model->save();
// }

// function showUserDepartment()
// {
//     // Retrieve the authenticated user
//     $user = Auth::user();

//     // Access the department name
//     // dd($user->department);
//     $departmentName = $user->department != null ? ($user->department->name != null ? $user->department->name : 'القسم الرئيسي') : '';

//     return $departmentName;
// }

// function formatTime($time)
// {

//     $to = Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
//     $toDay = str_replace(['AM', 'PM'], ['ص', 'م'], $to);
//     return $toDay;
// }

function formatTime($time)
{
    if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
        return '';
    }
    $to = Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
    $toDay = str_replace(['AM', 'PM'], ['ص', 'م'], $to);
    return $toDay;
}
function expolde_date($date){
    $new_date= explode(' ',$date);
    return  $new_date;

}
function Add_note($array_old, $array_new, $id)
{

    // dd($id);
    $notesData = [
        'note' => " تم التحويل من قسم $array_old->name_ar  الى قسم $array_new->name_ar",
        'type' => $array_new->type,
        'date' => date('Y-m-d H:i:s'),
        'military_affairs_id' => $id,
        'times_type_id' => $array_new->id,
        'cat2' => $array_new->slug,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user() ? Auth::user()->id : null,
        'updated_at' => date('Y-m-d H:i:s'),


    ];

    $res = Military_affairs_notes::create($notesData);
    // dd($res);
}

function Add_note_time($array_new, $id)
{

    $notesData = [

        'date_start' => date('Y-m-d H:i:s'),
        'military_affairs_id' => $id,
        'times_type_id' => $array_new->id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' =>Auth::user() ? Auth::user()->id : null,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user() ? Auth::user()->id : null,


    ];

    $res = Military_affairs_times::create($notesData);
    // dd($res);
}

function Add_note_general($array)
{

    $notesData = [
        'note' => $array->note,
        'type' => $array->type,
        'notes_type' => $array->notes_type,
        'date' => date('Y-m-d H:i:s'),
        'military_affairs_id' => $array->military_affairs_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user() ? Auth::user()->id : null,
        'updated_at' => Auth::user() ? Auth::user()->id : null,

    ];
    //dd($notesData);
    \App\Models\Military_affairs\Military_affairs_notes::create($notesData);
}

function log_move($user_id, $message)
{
    // dd($user_id);
    $log = new Log;
    $log->user_id = $user_id;
    $log->date = now()->format('Y-m-d');
    $log->time = now()->format('h:i:s');
    $log->description = $message;
    $log->save();
}

function change_status($array_status, $id)
{


    //dd($array_status);
    if ($array_status->hasFile('img_dir')) {
        $filename = time() . '-' . $array_status->file('img_dir')->getClientOriginalName();
        $path = $array_status->file('img_dir')->move(public_path('military_affairs'), $filename);
        $data_img_dir = 'military_affairs' . '/' . $filename;
//        $data_img_dir = $array_status->file('img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
    } else {
        $data_img_dir = '';
    }

    $array_status = [
        'type' => $array_status->type,
        'type_id' => $array_status->type_id,
        'date' => $array_status->date,
        'note' => $array_status->note ?? $array_status->note,
        'military_affairs_id' => $id,
        'img_dir' => $data_img_dir,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user() ? Auth::user()->id : null,
    ];

    \App\Models\Military_affairs\Military_affairs_status::create($array_status);
}

function get_all_notes($type, $military_affairs_id)
{

    $notes = Military_affairs_notes::where(['military_affairs_id' => $military_affairs_id, 'type' => $type])->get();
    // dd($notes);
    return $notes;

}

function get_all_actions($military_affairs_id)
{


    $notes = Military_affairs_times::where(['military_affairs_id' => $military_affairs_id])->get();

    //dd($notes);
    return $notes;

}

function get_all_delegations($military_affairs_id)
{


    $notes = military_affairs_deligation::where(['military_affairs_id' => $military_affairs_id])->get();

    //dd($notes);
    return $notes;

}

function get_all_banks($military_affairs_id)
{

    $notes = DB::table('military_affairs_bank_info')
        ->where('military_affairs_id', $military_affairs_id)
        ->get();

    return $notes;

}

function get_all_jobs($military_affairs_id)
{

    $notes = DB::table('military_affairs_job_info')
        ->where('military_affairs_id', $military_affairs_id)
        ->get();

    return $notes;

}


function get_modal_name($id)
{
    $item_bank = new \App\Models\Military_affairs\Military_affairs_stop_bank_type();
    $item_car = new \App\Models\Military_affairs\Military_affairs_stop_car_type();
    $item_salary = new \App\Models\Military_affairs\Military_affairs_stop_salary_type();
    $item_travel = new \App\Models\Military_affairs\Stop_travel_types();
    $item_settlement = new \App\Models\Military_affairs\Military_affairs_settlement_type();
    $item_certificate = new \App\Models\Military_affairs\Military_affairs_certificate_type();
    $item_types = new \App\Models\Military_affairs\Military_affairs_times_type();

    // Array of all item models
    $array_types = [
        'bank' => $item_bank,
        'car' => $item_car,
        'salary' => $item_salary,
        'travel' => $item_travel,
        'settlement' => $item_settlement,
        'certificate' => $item_certificate,
        'times' => $item_types
    ];

    // Iterate over the array and check if the ID exists
    foreach ($array_types as $key => $item) {
        try {
            $item_time = $item::findOrFail($id);
            return $item_time;  // Return the key (model type) as the modal name
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If the model is not found, continue to the next one
            continue;
        }
    }

    // If no model was found, return null or an error message
    return null;
}

function get_by_dates($type_id)
{
    $date_arr = Military_affairs_times::where(['times_type_id' => $type_id])->whereYear('date_start',now()->year)
        ->whereMonth('date_start', now()->month)
        ->selectRaw('DAY(date_start) as day, count(*) as count')
        ->groupBy(DB::raw('DAY(date_start)'))
        ->get();
    // dd($date_arr);
    return $date_arr;
}


function count_client($array_data)
{
    $governorates = Governorate::with('clients')->get();

}

function get_different_dates($first_end_date, $second_end_date)
{
    // Validate and parse the first date
    $datetime1 = is_numeric($first_end_date) ? date_create(date('Y-m-d', $first_end_date)) : date_create($first_end_date);

    // Validate and parse the second date
    $datetime2 = is_numeric($second_end_date) ? date_create(date('Y-m-d', $second_end_date)) : date_create($second_end_date);

    // Ensure both dates are valid
    if (!$datetime1 || !$datetime2) {
        return 'تاريخ غير صالح'; // Return a friendly error message
    }

    // Calculate the difference
    $interval = date_diff($datetime1, $datetime2);

    // Format and return the difference
    $days = $interval->format('%d يوم');
    $months = $interval->format('%m شهر');
    $years = $interval->format('%y سنة');

    // Return combined result if needed, or just days
    return $years . ', ' . $months . ', ' . $days;
}


function get_diff_date($date1,$date2){

    $date1 = new DateTime($date1); // First date
    $date2 = new DateTime($date2); // Second date

// Get the difference
    $interval = $date1->diff($date2);

// Output the difference in days
    return  $interval->days;


}

function get_different_date($first_end_date, $second_end_date)
{
    // Convert timestamps to DateTime strings if necessary
    if (is_numeric($first_end_date)) {
        $first_end_date = date('Y-m-d', $first_end_date);
    }
    if (is_numeric($second_end_date)) {
        $second_end_date = date('Y-m-d', $second_end_date);
    }

    // Ensure both dates are valid
    $datetime1 = date_create($first_end_date);
    $datetime2 = date_create($second_end_date);

    if (!$datetime1 || !$datetime2) {
        return 'تاريخ غير صالح';
    }

    // Calculate the difference
    $interval = date_diff($datetime1, $datetime2);

    // Format the output
    return $interval->days . ' يوم';
}

function add_money_to_bank($bank_id, $installment_id, $amount, $come_from, $description, $process_type, $payment_type)
{

    $bank = \App\Models\Bank::findorfail($bank_id);

    if ($process_type == 'income') {
        $add_data['debtor'] = 1;
        $add_data['type'] = "income";

        $add_data_bank['amount'] = $bank['amount'] + $amount;
    } else {
        $add_data['creditor'] = 1;
        $add_data_bank['amount'] = $bank['amount'] - $amount;
        $add_data['type'] = "export";
    }
    $bank->update($add_data_bank);

    $add_data['amount'] = $amount;

    $add_data['installment_id'] = $installment_id;

    $add_data['bank_id'] = $bank_id;

    $add_data['payment_type'] = $payment_type;

    $add_data['come_from'] = $come_from;

    $add_data['description'] = $description;

    $add_data['date'] = time();

    $cond['bank_id'] = $bank_id;

    $item2 = DB::table('banks_invoices')->where('bank_id', $bank_id)->first();

    $item = $item2[0];
    $sum = $amount;
    //  echo '<pre>';  print_r($item);
    if (!empty($item)) {

        switch ($add_data['type']) {
            case "income":
                $sum = $item['balance'] + $sum;
                // echo 'xx<pre>';  print_r($sum); exit;
                break;
            case "share_capital":
                $sum = $item['balance'] + $sum;
                break;
            case "expenses":
                $sum = $item['balance'] - $sum;
                break;
            case "export":
                $sum = $item['balance'] - $sum;
                break;
            case "advance":
                $sum = $item['balance'] - $sum;
                break;
            case "income_pending":
                $sum = $item['balance'];
                break;
            case "expenses_pending":
                $sum = $item['balance'];
                break;

            default:
                break;
        }
    } else {
        //echo 'xx<pre>';  print_r($item); exit;
        $sum = $sum;
    }
    $add_data['balance'] = $sum;

    //  echo '<pre>';  print_r($add_data); exit;

    $id = DB::table('banks_invoices')->create($add_data);

    return $id;
}

function add_main_cash_invices($military_id, $installment_id, $client_id)
{

    $item_military_affairs = \App\Models\Military_affairs\Military_affair::findorfail($military_id);
    $item_installment = \App\Models\Installment::findorfail($installment_id);
    $item_client = \App\Models\Client::findorfail($client_id);
//echo '<pre>';print_r($data);exit;
    $sum = $add_data['amount'] = abs($item_military_affairs->reminder_amount);

    $add_data['description'] = '   تسليم مبلغ متبقي للعميل بعد  تحصيل كامل المديونية'
        . '  العميل'
        . '  '
        . $item_client->namer_ar
        . ' '
        . 'معاملة رقم '
        . '( '
        . $item_installment->id
        . ' )';

    $payment_type = $add_data['payment_type'] = 'cash';

    $add_data['knet_code'] = '';

    $add_data['type'] = 'expenses';

    $add_data['date'] = time();

    //echo '<pre>';  print_r($add_data); exit;

    $item = invoice::latest();

    switch ($add_data['type']) {
        case "income":
            $add_data['debtor'] = 1;
            $sum = $item['balance'] + $sum;
            update_invoice_central_bank('cash', '+', $add_data['amount'], 'central');
            break;
        case "share_capital":
            $add_data['debtor'] = 1;
            update_invoice_central_bank('cash', '+', $add_data['amount'], 'central');
            $sum = $item['balance'] + $sum;
            break;
        case "expenses":
            $add_data['creditor'] = 1;
            update_invoice_central_bank('cash', '-', $add_data['amount'], 'central');
            $sum = $item['balance'] - $sum;
            break;
        case "export":
            $add_data['creditor'] = 1;
            update_invoice_central_bank('cash', '-', $add_data['amount'], 'central');
            $sum = $item['balance'] - $sum;
            break;
        case "advance":
            $sum = $item['balance'] - $sum;
            break;
        case "income_pending":
            $sum = $item['balance'];
            break;
        case "expenses_pending":
            $sum = $item['balance'];
            break;
        case "law_transfer":
            $add_data['creditor'] = 1;
            // echo '<pre>';  print_r($sum);  exit;
            // $this->transfer_money_to_section('laws_invoices', $payment_type, $sum);
            $sum = $item['balance'] - $sum;
            update_invoice_central_bank('cash', '-', $add_data['amount'], 'central');
            break;
        case "lawyer":
            $add_data['creditor'] = 1;
            // echo '<pre>';  print_r($sum);  exit;
            // $this->transfer_money_to_section('lawsaffairs_invoices', $payment_type, $sum);
            $sum = $item['balance'] - $sum;
            update_invoice_central_bank('cash', '-', $add_data['amount'], 'central');
            break;
        case "easy":
            $add_data['creditor'] = 1;
            // echo '<pre>';  print_r($sum);  exit;
            //  $this->transfer_money_to_section('easy', $payment_type, $sum);
            $sum = $item['balance'] - $sum;
            update_invoice_central_bank('cash', '-', $add_data['amount'], 'central');
            break;
        default:
            break;
    }

    $add_data['balance'] = $sum;

    $add_data['user_id'] = Auth::user() ? Auth::user()->id : '';

    $add_data['img_dir'] = $item_military_affairs->reminder_img_dir;

    DB::table('invoices')->create($add_data);
    // $val_id = $this->db_get->add_and_get_last_id('invoices', $add_data);

}

function increase_decrease_slug($table, $column, $operation, $value, $column2, $value2)
{

    DB::table($table)
        ->where($column2, $value2)
        ->update([$column => DB::raw("$column $operation $value")]);

}

function all_eqrardeain_sql_for_year($year, $status)
{
    $query = \App\Models\Installment::selectRaw('SUM(eqrardain_amount) as sum_amount')->
    join('clients', 'installment.client_id', '=', 'clients.id')
        ->where('installment.finished', 0)
        ->where('installment.type', 'installment')
        ->where('installment.status', 'finished');
    if ($status) {
        $query->where('installment.laws', 0);
    }

    if ($year) {
        $query->where('qard_year', $year);
    }

    $item = $query->first();

    return $item->sum_amount ?? 0;

}

function getTotalAmount($year = 2023)
{
    // Start the query
    $query = DB::table('military_affairs')
        ->join('installment', 'military_affairs.installment_id', '=', 'installment.id')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->select(DB::raw('SUM(military_affairs.eqrar_dain_amount) as the_amount'))
        ->where('tahseel', 0)
        ->where('installment.finished', 0)
        ->where('military_affairs.archived', 0)
        ->whereYear(DB::raw('FROM_UNIXTIME(military_affairs.date)'), $year);

    // Execute the query and get the result
    $item = $query->first();

}

function getSumAmount($status, $year)
{
    $query = DB::table('installment')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->where('installment.finished', 0)
        ->where('installment.type', 'installment')
        ->where('installment.status', 'finished');

    // Add conditions based on status and year
    if ($status) {
        $query->where('installment.laws', 0);
    }

    if ($year) {
        $query->where('qard_year', $year);
    }

    // Get the sum of eqrardain_amount
    $sumAmount = $query->sum('eqrardain_amount');

    // Return the sum, ensuring it's an integer
    return $sumAmount ?: 0; // Defaults to 0 if sum is null
}

if (!function_exists('english_to_arabic')) {
    function english_to_arabic($number)
    {
        $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic_digits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($english_digits, $arabic_digits, $number);
    }
}
if (!function_exists('numberToArabicWords')) {
    function numberToArabicWords($number)
    {
        $arabic_numbers = [
            0 => 'صفر',
            1 => 'واحد',
            2 => 'اثنان',
            3 => 'ثلاثة',
            4 => 'أربعة',
            5 => 'خمسة',
            6 => 'ستة',
            7 => 'سبعة',
            8 => 'ثمانية',
            9 => 'تسعة',
            10 => 'عشرة',
            11 => 'إحدى عشرة',
            12 => 'إثنا عشر',
            13 => 'ثلاثة عشر',
            14 => 'أربعة عشر',
            15 => 'خمسة عشر',
            16 => 'ستة عشر',
            17 => 'سبعة عشر',
            18 => 'ثمانية عشر',
            19 => 'تسعة عشر',
            20 => 'عشرون',
            30 => 'ثلاثون',
            40 => 'أربعون',
            50 => 'خمسون',
            60 => 'ستون',
            70 => 'سبعون',
            80 => 'ثمانون',
            90 => 'تسعون',
            100 => 'مئة',
            200 => 'مئتان',
            1000 => 'ألف',
            // Add more numbers if necessary
        ];

        if (array_key_exists($number, $arabic_numbers)) {
            return $arabic_numbers[$number];
        }

        // For numbers between 21 and 99 (like 65)
        $tens = floor($number / 10) * 10;
        $ones = $number % 10;

        if ($tens && $ones) {
            return $arabic_numbers[$tens] . ' و ' . $arabic_numbers[$ones];
        }

        return $arabic_numbers[$number] ?? $number;
    }
}

function getOrderDetails($id)
{
    $query = \App\Models\Order::
    join('orders_items', 'orders.id', '=', 'orders_items.order_id')
        ->join('products', 'products.id', '=', 'orders_items.product_id')
        ->join('classes', 'classes.id', '=', 'products.class')
        ->join('marks', 'marks.id', '=', 'products.mark')
        ->join('clients', 'clients.id', '=', 'orders.client_id')
        ->select(
            'orders_items.*',
            DB::raw('SUM(orders_items.counter) AS counter_item'),
            'products.model',
            'orders_items.id AS item_id',
            'clients.id AS client_id',
            'classes.name AS class_name',
            'marks.name AS mark_name',
            'clients.name AS client_name'
        )
        ->where('orders.id', $id)
        ->groupBy('orders_items.product_id')
        ->get();

    return $query;
}

function all_previous_invoices($start_date, $end_date, $type)
{
    if ($type) {
        $payment_type = $type;

    } else {
        $payment_type = '!=part';
    }

    return Invoices_installment::where('type', 'export')->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->where('payment_type', $payment_type) /*->where('branch_id', Auth::user()->branch_id )*/->orderBy('id', 'desc')->get();
}
function all_invoices_by_date_sql2($pay_type)
{
    if (!$pay_type) {
        $payment_type = '';
    } else {
        $payment_type = $pay_type;
    }

    $firstDay = (new DateTime('first day of last month'))->format('Y-m-d');

    $lastDay = (new DateTime('first day of this month'))->format('Y-m-d');
    $data['previous_items'] = all_previous_invoices($firstDay, $lastDay, $payment_type);
    //$data['items']= $this->all_invoices();

    if (!empty($data['previous_items'][0]['date'])) {
        $firstDay = $data['previous_items'][0]['date'];
    } else {
        // $firstDay = strtotime(date('Y-m-01 00:00:00', strtotime('first day of this month')));
        $firstDay = (new DateTime('first day of this month'))->format('Y-m-d');
    }
    // $lastDay = strtotime(date('Y-m-01 00:00:00', strtotime('first day of next month')));
    $lastDay = (new DateTime('first day of next month'))->format('Y-m-d');

    //$branch_id = Auth::user()->branch_id  ;

    $all_invoices = Invoices_installment::when($payment_type, function ($q) use ($payment_type) {
        return $q->where('payment_type', $payment_type);
    })->whereDate('date', '>=', $firstDay)->whereDate('date', '<=', $lastDay)->orderBY('id', 'desc')->get();

    $cash = 0;
    $knet = 0;

    foreach ($all_invoices as $item) {
        if ($item['debtor'] == 1) {
            if ($item['payment_type'] == 'cash') {
                $cash = $cash + $item['amount'];
            }
            if ($item['payment_type'] == 'knet') {
                $knet = $knet + $item['amount'];
            }
        } else {
            if ($item['payment_type'] == 'cash') {
                $cash = $cash - $item['amount'];
            }
            if ($item['payment_type'] == 'knet') {
                $knet = $knet - $item['amount'];
            }
        }

    }
    $data_total['total_balance'] = $knet + $cash;
    $data_total['cash'] = $cash;
    $data_total['knet'] = $knet;

    return json_encode($data_total);
}

function all_invoices($id, $type, $payment_type)
{
    // Get the branch_id from the session
    $branch_id = Auth::user()->branch_id;

    // Start building the query using Laravel Query Builder
    $query = Invoices_installment::
    join('installment', 'invoices_installment.installment_id', '=', 'installment.id')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->select('invoices_installment.*', 'clients.name as client_name')
        ->where('invoices_installment.type', '=', $type)
        ->where('invoices_installment.branch_id', '=', $branch_id)
        ->where('invoices_installment.id', '>', $id);

    // Apply payment_type filter if it's provided
    if (!empty($payment_type)) {
        $query->where('invoices_installment.payment_type', '=', $payment_type);
    }

    // Execute the query and return the results
    return $query->get();
}

if (!function_exists('update_big_invoice_cash')) {
    function update_big_invoice_cash($come_from, $amount, $description)
    {

        $sum = $amount;

        //$item = $db_get->get_last_id('invoices');
        $item = DB::table('invoices')->lastInsertId();

        $add_data_cash['debtor'] = 1;
        $sum = $item['balance'] + $sum;
        update_invoice_central_bank('cash', '+', $amount, 'central');

        $add_data_cash['balance'] = $sum;

        $add_data_cash['created_by'] = Auth::user()->id;

        $add_data_cash['payment_type'] = 'cash';

        $add_data_cash['come_from'] = $come_from;

        $add_data_cash['amount'] = $amount;

        $add_data_cash['type'] = 'income';

        $add_data_cash['date'] = date('Y-m-d');

        $add_data_cash['description'] = 'ايرادات  الكاش  من   ' . $description;

        // $db_get->add_tb('invoices', $add_data_cash);
        DB::table('invoices')->insert($add_data_cash);
    }
}
if (!function_exists('update_big_invoice_knet')) {
    function update_big_invoice_knet($come_from, $amount, $description)
    {

        $sum = $amount;

        // $item = $db_get->get_last_id('central_bank');
        $item = DB::table('central_bank')->lastInsertId();

        $add_data_cash['debtor'] = 1;

        $sum = $item['balance'] + $sum;

        update_invoice_central_bank('knet', '+', $amount, 'central_bank');

        $add_data_cash['payment_type'] = 'knet';

        $add_data_cash['come_from'] = $come_from;

        $add_data_cash['amount'] = $amount;

        $add_data_cash['type'] = 'income';

        $add_data_cash['date'] = date('Y-m-d H:i:s');

        $add_data_cash['description'] = 'ايرادات  الكي نت   من   ' . $description;

        // $db_get->add_tb('central_bank', $add_data_cash);
        DB::table('central_bank')->create($add_data_cash);
    }
}
if (!function_exists('update_invoice_central_bank')) {
    function update_invoice_central_bank($col, $operation, $val, $slug)
    {
        ;

        increase_decrease_slug('invoices_central_bank', $col, $operation, $val, 'slug', $slug);
    }
}

function allInvoicesLimit($start_id, $end_id, $type, $payment_type)
{
    $branch_id = Auth::user()->branch_id; // Retrieve the branch_id from the session

    // Start building the query using the InvoiceInstallment model
    $query = Invoices_installment::join('installment', 'invoices_installment.installment_id', '=', 'installment.id')
        ->join('clients', 'clients.id', '=', 'installment.client_id')
        ->where('invoices_installment.branch_id', $branch_id) // Filter by branch_id
        ->where('invoices_installment.type', $type) // Filter by type
        ->whereBetween('invoices_installment.id', [$start_id, $end_id]); // Filter by id range

    // If payment_type is provided, add an additional condition
    if (!empty($payment_type)) {
        $query->where('invoices_installment.payment_type', $payment_type);
    }

    // Select the columns you need, including client name
    $result = $query->select('invoices_installment.*', 'clients.name as client_name')
        ->get(); // Execute the query and get the result

    return $result;
}



function get_responsible()
{
    $users = User::where('set_delegate',1)->get();
    return $users;
}

function update_responsible($user_id, $military_id, $status)
{

    // dd($user_id);

    $dateFields = [
        'open_file' => 'open_file_date',
        'Execute_alert' => 'execute_date',
        'image' => 'image_date',
        'case_proof' => 'case_proof_date',
        'stop_travel' => 'travel_date',
        'Certificate' => 'certificate_date',
        'stop_salary' => 'salary_date',
        'stop_car' => 'car_date',
        'stop_bank' => 'bank_date',
        'eqrar_dain_received'=>'eqrar_dain_received',
    ];

    // dd($military_id);
    $up = Military_affair::where('id',$military_id)->first();
    $up->emp_id = $user_id;
    $up->save();

    $check = military_affairs_deligation::where([
        'military_affairs_id' => $military_id,
        'emp_id' => $user_id,
        'end_date' => NULL,
    ])->first();

    if ($check) {
        if (array_key_exists($status, $dateFields)) {
            $check->{$dateFields[$status]} = Carbon::now();
            $check->save();
        }
        return true;
    } else {
        $lastRecord = military_affairs_deligation::where('military_affairs_id', $military_id)
            ->orderBy('id', 'desc')
            ->first();
        if ($lastRecord) {
            $lastRecord->end_date = Carbon::now();
            $lastRecord->save();
        }
        $newRecord = new military_affairs_deligation();
        $newRecord->military_affairs_id = $military_id;
        $newRecord->assign_date = Carbon::now();
        $newRecord->emp_id = $user_id;
        if (array_key_exists($status, $dateFields)) {
            $newRecord->{$dateFields[$status]} = Carbon::now();
        }
        $newRecord->save();
        return true;
    }

}


function get_fixed_prin_data()
{
    return FixedPrintData::all();
}
function specific_fixed_prin_data($id)
{
    return FixedPrintData::find($id);
}

//  function count_court($court_id, $stop_type,$minst_id,$time_type)
//     {
//         return Military_affair::with('installment')->with('installment.client')
//                 ->with('status_all')->with('mil_times.salaryType')
//                 ->whereHas('installment.client', function ($q) use($court_id,$stop_type, $minst_id) {
//                     if($stop_type == 'stop_salary')
//                     {
//                     $q->where('job_type','military')->whereIN('ministry_last',[5,14,27]);
//                     }
//                     if($court_id != '')
//                     {
//                         $q->where('governorate_id', $court_id);
//                     }

//                 })
//                 ->whereHas('installment', function ($q){
//                     return $q->where('finished',0);
//                 })
//                 // ->whereHas('status_all', function ($q) use($time_type, $minst_id) {
//                 //         $q->where('type','stop_salary')->where('type_id',$time_type)->where('ministry',$minst_id)->where('flag',0);
//                 //     })
//                 ->where('archived',operator: 0)
//                 ->when($stop_type == 'open_file', function ($q) {
//                     $q->where('military_affairs.status', 'military');
//                 }, function ($q) use ($stop_type) {
//                     $q->where('military_affairs.status', 'execute')
//                       ->where($stop_type, 1);
//                 })
//                 ->count();


//     }


function count_court($court_id, $stop_type,$minst_id,$time_type)
{

    return Military_affair::with('installment')->with('installment.client')
        ->with('status_all')->with('mil_times.salaryType')
        ->whereHas('installment.client', function ($q) use($court_id,$stop_type, $minst_id) {
            if($stop_type == 'stop_salary')
            {
                $q->where('job_type','military')->whereIN('ministry_last',[5,14,27]);
            }
            if($court_id != '')
            {
                $q->where('governorate_id', $court_id);
            }

        })
        ->whereHas('installment', function ($q){
            return $q->where('finished',0);
        })
        ->when($stop_type === "stop_salary", function ($query) use ($time_type, $minst_id, $court_id) {
            $query->whereHas('status_all', function ($q) use ($time_type, $minst_id, $court_id) {
                if ($minst_id && $court_id) {
                    $q->where('type', 'stop_salary')
                        ->where('ministry', $minst_id)
                        ->where('type_id', $time_type)
                        ->where('flag', 0);
                }
            });
        })
        //  ->whereHas('status_all', function ($q) use($time_type, $minst_id, $court_id) {
        //     if($minst_id && $court_id)
        //     {
        //       $q->where('type','stop_salary')->where('ministry',$minst_id)->where('type_id',$time_type)->where('flag',0);
        //     }
        //     })
        ->where('archived',operator: 0)
        ->when($stop_type == 'stop_salary', function ($q) use ($stop_type) {
            $q->where('military_affairs.status', 'execute')
                ->where($stop_type, 1);

        }, function ($q) use ($stop_type)  {
            if($stop_type == 'open_file')
            {
                $q->where('military_affairs.status', 'military');
            }
            if($stop_type == 'case_proof')
            {
                $q->where('military_affairs.status', 'case_proof');
            }


        })
        ->count();


}
function count_minstry($id, $stop_type, $minst_id)
{
    return Military_affair::with('installment.client')->with('installment')
        ->whereHas('installment.client', function ($q) use($minst_id, $id) {
            $q->where('job_type','military')->whereIN('ministry_last',[5,14,27])
                ->where('governorate_id', $id);
        })
        ->whereHas('installment.client.get_ministry', function ($q) use($minst_id) {
            $q->where('id', $minst_id);
        })
        ->whereHas('installment', function ($q){
            $q->where('finished',0);
        })
        ->where('archived',0)
        ->where(['military_affairs.status' => 'execute', $stop_type => 1  ])->count();
}


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم رفض الوصول</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-xl p-6 max-w-md text-center">
        <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-red-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.104 0 2-.896 2-2V7a2 2 0 00-2-2H5.062a2 2 0 00-2 2v10c0 1.104.896 2 2 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">تم رفض الوصول</h2>
            <p class="text-gray-600 mt-2">ليس لديك الصلاحيات اللازمة للوصول إلى هذه الصفحة.</p>
            <a href="{{ url()->previous() }}" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow">العودة للخلف</a>
        </div>
    </div>

</body>
</html>

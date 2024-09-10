<?php

//use App\Models\Leave;
//use App\Models\Holiday;
//use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Events\NotificationEvent;

// file upload common function
function fileUpload($image, $path = null, $name = null)
{
    $image_name = $image->getClientOriginalName();

    if ($name) {
        $image_name = $name . '.' . $image->getClientOriginalExtension();
    }
    if ($path) {
        $image->move(public_path($path), $image_name);
    } else {
        $image->move(public_path('uploads'), $image_name);
    }

    return $path . $image_name;
}

// unlink file common function
function unlinkFile($filePath)
{
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    }
    return false;
}

if (!function_exists('image')) {
    /**
     * Image URL generating
     *
     * @param mixed $file File including path
     * @param string $name Default name to create placeholder image
     * @return string URL of the file
     */
    function image($file, $name = 'Avatar')
    {
        if (Storage::exists($file))
            // $url = asset('uploads/' . $file);
            $url = asset($file);
        else
            $url = 'https://i2.wp.com/ui-avatars.com/api/' . Str::slug($name) . '/400';

        return $url;
    }
}

if (!function_exists('user')) {

    /**
     * Get the authenticated user instance
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user()
    {
        return auth()->user();
    }
}


if (!function_exists('sendNotification')) {

    /**
     * Send a notification to multiple users.
     *
     * @param array  $users     An array of user instances or user IDs.
     * @param string $title     The title of the notification.
     * @param string $message   The message body of the notification (optional).
     * @param string $web_url   A web URL associated with the notification (optional).
     * @param string $app_url   An app URL associated with the notification (optional).
     * @param string $platform  The platform on which to send the notification ('all' by default).
     */
    function sendNotification(array $users, $title = null, $notify_app_title = null,  $message = null, $web_url = null, $app_url = null, $platform = 'all')
    {
        foreach ($users as $user) {
            // store to database
            $notification = Notification::create([
                'user_id' => $user,
                'title' => $title,
                'app_title' => $notify_app_title,
                'message' => $message,
                'web_url' => $web_url,
                'app_url' => $app_url,
                'platform' => $platform,
                'created_by' => auth()->id(),
            ]);

            // Send the notification
            event(new NotificationEvent($notification));
        }
    }
}

//function is_holiday($date, $return_data = false)
//{
//    $holiday = Holiday::whereDate('from_date', '<=', $date)
//        ->whereDate('to_date', '>=', $date);
//
//    //        if($return_data){
//    //            return $holiday->get();
//    //        }
//    //return $holiday->exists();
//
//    return $holiday->first();
//}
//
////check if date is leave or not
//function is_leave_request($params = null)
//{
//    $leave = Leave::where('user_id', $params->user_id)
//        //            ->where('is_approved', 1)
//        ->whereDate('from_date', '<=', $params->date)
//        ->whereDate('to_date', '>=', $params->date);
//
//    return $leave->first();
//}
//
//function is_weekend($day_name)
//{
//    if (!$day_name) {
//        return false;
//    } else {
//        return in_array($day_name, getWeekends());
//    }
//}
//
//function getWeekends()
//{
//    // return array of day name
//    return Setting::select('weekends')->first()->weekends;
//}
//
//function getLeaves($params = null)
//{
//    $leave = Leave::where('is_approved', 1)
//        ->where('user_id', $params->user_id)
//        ->whereDate('from_date', '<=', $params->date)
//        ->whereDate('to_date', '>=', $params->date);
//
//    return $leave->first();
//}

if (!function_exists('numberFormet')) {
    function numberFormet($amount)
    {
        // dump($amount);
        if ($amount < 0) {
            $formattedAmount = rtrim(number_format(abs($amount), 4), '0');
            // Check if the formatted amount has decimal places
            if (strpos($formattedAmount, '.') !== false) {
                // Remove trailing zeros after the decimal point
                $formattedAmount = rtrim($formattedAmount, '.');
            }
            return '<span style="color: #d33333;">(' . $formattedAmount . ')</span>';
        } elseif ($amount > 0) {
            $formattedAmount = rtrim(number_format($amount, 4), '0');
            // Check if the formatted amount has decimal places
            if (strpos($formattedAmount, '.') !== false) {
                // Remove trailing zeros after the decimal point
                $formattedAmount = rtrim($formattedAmount, '.');
            }
            return $formattedAmount;
        } else {
            return '-';
        }
        // if ($amount<0) {
        //     return '<span style="color: #d33333;">(' . number_format(abs($amount), 2) . ')</span>';
        // } else {
        //     return number_format($amount, 2);
        // }
    }
}

function convertNumberToWords($num)
{
    $ones = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
        15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
    );
    $tens = array(
        0 => '', 2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
        6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
    );

    $num = (int)$num;

    if ($num == 0) {
        return 'Zero';
    }

    $crores = floor($num / 10000000);
    $num -= $crores * 10000000;

    $lakhs = floor($num / 100000);
    $num -= $lakhs * 100000;

    $thousands = floor($num / 1000);
    $num -= $thousands * 1000;

    $hundreds = floor($num / 100);
    $num -= $hundreds * 100;

    $tens_ones = $num;

    $result = '';

    if ($crores) {
        $result .= convertNumberToWords($crores) . ' Crore ';
    }

    if ($lakhs) {
        $result .= convertNumberToWords($lakhs) . ' Lakh ';
    }

    if ($thousands) {
        $result .= convertNumberToWords($thousands) . ' Thousand ';
    }

    if ($hundreds) {
        $result .= convertNumberToWords($hundreds) . ' Hundred ';
    }

    if ($tens_ones) {
        if ($tens_ones < 20) {
            $result .= $ones[$tens_ones] . ' ';
        } else {
            $result .= $tens[floor($tens_ones / 10)] . ' ' . $ones[$tens_ones % 10] . ' ';
        }
    }

    return trim($result);
}

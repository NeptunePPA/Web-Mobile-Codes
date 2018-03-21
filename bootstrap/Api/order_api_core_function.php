<?php
/**
 * Created by PhpStorm.
 * User: Punit
 * Date: 1/18/2018
 * Time: 5:03 PM
 */

use App\category;
use App\clients;
use App\client_price;
use App\customContact;
use App\device;
use App\MailList;
use App\MailTo;
use App\manufacturers;
use App\order;
use App\physciansPreference;
use App\physciansPreferenceAnswer;
use App\project;
use App\schedule;
use App\User;
use \Carbon\Carbon;

/**
 * Get Order Detials
 * @param $client_id
 * @param $category_id
 * @param $device_id
 * @param $type
 * @return array
 */
function getorder($client_id, $category_id, $device_id, $type) {

    $devices = device::where('id', $device_id)->first();

    if (!empty($devices['device_image']) && file_exists('public/upload/' . $devices['device_image'])) {
        $devices['device_image'] = URL::to('public/upload/' . $devices['device_image']);
    } else {
        $devices['device_image'] = URL::to('public/upload/default.jpg');
    }

    $manufacture = manufacturers::where('id', $devices['manufacturer_name'])->value('manufacturer_logo');

    $device = array(
        'id' => $devices['id'],
        'level_name' => $devices['level_name'],
        'project_name' => $devices['project_name'],
        'category_name' => $devices['category_name'],
        'manufacturer_name' => $devices['manufacturer_name'],
        'device_name' => $devices['device_name'],
        'model_name' => $devices['model_name'],
        'device_image' => $devices['device_image'],
        'status' => $devices['status'],
        'research_email' => $devices['research_email'],
        'performance' => $devices['performance'],
        'manufacturer_logo' => $manufacture,
    );

    if (!empty($device['manufacturer_logo']) && file_exists('public/upload/' . $device['manufacturer_logo'])) {
        $device['manufacturer_logo'] = URL::to('public/upload/' . $device['manufacturer_logo']);
    } else {
        $device['manufacturer_logo'] = URL::to('public/upload/default.jpg');
    }

    /**
     * Device Details Complete
     */

    $survey = array();

    $surveydevice = physciansPreference::where('deviceId', $device_id)->where('clientId', $client_id)->get();

    foreach ($surveydevice as $row) {

        $survey[] = array(
            'id' => $row->id,
            'question' => $row->question,
            'check' => $row->check,
        );
    }

    $data = array('device' => $device, 'survey' => $survey, 'categoryAPP' => array());

    return $data;

}

/**
 * Confirm Order Detials
 * @param $client_id
 * @param $category_id
 * @param $device_id
 * @param $type
 */
function confirmOrder($client_id, $patient, $device_id, $type, $date, $time, $survey, $bulk, $user, $researchMail,$device_cco,$device_repless) {

    $device = device::where('id', $device_id)->first();

    $device_client_price = client_price::where('device_id', $device_id)->where('client_name', $client_id)->first();

    $cco = '';
    $repless = '';

        if ($type == 'Unit') {
            $price = $device_client_price['unit_cost'];
            if ($device_cco == 'true') {

                if ($device_client_price['cco_discount_check'] == 'True') {

                    $cco = ($device_client_price['unit_cost'] * $device_client_price['cco_discount']) / 100;
                    $cco = $price - $cco;
                } else if ($device_client_price['cco_check'] == 'True') {
                    $cco = $price - $device_client_price['cco'];
                }
            }

            if ($device_repless == 'true') {

                if ($device_client_price['cco_discount_check'] == 'True') {

                    $cco = ($price * $device_client_price['cco_discount']) / 100;
                    $cco = $price - $cco;
                } else if ($device_client_price['cco_check'] == 'True') {
                    $cco = $price - $device_client_price['cco'];
                }

                if ($device_client_price['unit_repless_discount_check'] == 'True') {

                    $repless = (($cco == '' ? $price : $cco) * $device_client_price['unit_repless_discount']) / 100;
                    $repless = ($cco == '' ? $price : $cco) - $repless;
                } else if ($device_client_price['unit_rep_cost_check'] == 'True') {
                    $repless = ($cco == '' ? $price : $cco) - $device_client_price['unit_rep_cost'];
                }
            }

        }
        if ($type == 'System') {
            $price = $device_client_price['system_cost'];
            if($device_repless == true){
                if ($device_client_price['system_repless_discount_check'] == 'True') {

                    $repless = ($price * $device_client_price['system_repless_discount']) / 100;
                    $repless = $price - $repless;
                } else if ($device_client_price['system_repless_cost_check'] == 'True') {
                    $repless = $price - $device_client_price['system_repless_cost'];
                }
            }

        }


    $order = array(
        'clientId' => $client_id,
        'deviceId' => $device_id,
        'manufacturer_name' => $device['manufacturer_name'],
        'model_name' => $device['device_name'],
        'model_no' => $device['model_name'],
        'unit_cost' => $type == 'Unit' ? $device_client_price['unit_cost'] : '',
        'system_cost' => $type == 'System' ? $device_client_price['system_cost'] : '',
        'cco' => $cco,
        'reimbrusement' => $device_client_price['reimbursement'],
        'order_date' => \Carbon\Carbon::now()->format('Y-m-d'),
        'orderby' => $user->id,
        'sent_to' => $user->email,
        'status' => "New",
        'bulk_check' => $bulk,
        'is_delete' => 0,
        'is_archive' => 0,
    );

    $newOrder = new order();
    $newOrder->fill($order);
    if ($newOrder->save()) {

        /**
         * Survey Answer
         */
        $survey_answer = array();
        if (count($survey) > 0) {

            for ($i = 0; $i < count($survey); $i++) {
                $survey_answer['clientId'] = $client_id;
                $survey_answer['deviceId'] = $device_id;
                $survey_answer['userId'] = $user->id;
                $survey_answer['question'] = $survey[$i]['question'];
                $survey_answer['check'] = $survey[$i]['check'];
                $survey_answer['answer'] = $survey[$i]['answer'];
                $survey_answer['preId'] = $survey[$i]['id'];
                $survey_answer['flag'] = "True";

                $surveys = new physciansPreferenceAnswer();
                $surveys->fill($survey_answer);
                $surveys->save();
            }

        }

        /**
         * Schedule Device
         */

//        $schedule = array(
//        $schedule['project_name'] = $device['project_name'];
//        $schedule['client_name'] = $client_id;
//        $schedule['physician_name'] = $user['id'];
//        $schedule['patient_id'] = $patient;
//        $schedule['manufacturer'] = $device['manufacturer_name'];
//        $schedule['device_name'] = $device['id'];
//        $schedule['model_no'] = $device['model_name'];
//        $schedule['rep_name'] = '';
//        $schedule['event_date'] = $date;
//        $schedule['start_time'] = $time;
//        $schedule['status'] = "Active";
//        $schedule['is_delete'] = 0;
//
//        $device_schedule = new schedule();
//        $device_schedule->fill($schedule);
//        $device_schedule->save();

        /**
         * Send Email For Order
         */

        $title = "Welcome to Neptune-PPA - Order Details ";

        $maildata = customContact::where('deviceId', $device_id)
            ->where('clientId', $client_id)
            ->first();

        if (empty($maildata)) {
            $userMail = "";
            $cc1 = "";
            $cc2 = "";
            $cc3 = "";
            $cc4 = "";
            $cc5 = "";
            $cc6 = "";
        } else {
            $userMail = $maildata->order_email == '0' ? '' : $maildata->user->email;
            $cc1 = $maildata['cc1'];
            $cc2 = $maildata['cc2'];
            $cc3 = $maildata['cc3'];
            $cc4 = $maildata['cc4'];
            $cc5 = $maildata['cc5'];
            $cc6 = $maildata['cc6'];
            $title = $maildata['subject'] == "" ? $title : $maildata['subject'];

        }

        $repemail = User::repcontact()->where('users.roll', '5')
            ->where('rep_contact_info.deviceId', $device_id)
            ->where('rep_contact_info.repStatus', 'Yes')
            ->where('users.organization', $device['manufacturer_name'])
            ->where('users.is_delete', '0')
            ->where('users.status', 'Enabled')
            ->select('users.email')
            ->get();

        $mail_data = array(
            'title' => $title,
            'physician' => $user->email,
            'rep_email' => $repemail,
            'order_email' => $userMail,
            'manufacturer_name' => $device->manufacturer->manufacturer_name,
            'model_name' => $order['model_name'],
            'model_no' => $order['model_no'],
            'order_date' => $order['order_date'],
            'orderby' => $user->name,
            'rep' => '',
            'sent_to' => $user->email,
            'cc1' => $cc1,
            'cc2' => $cc2,
            'cc3' => $cc3,
            'cc4' => $cc4,
            'cc5' => $cc5,
            'cc6' => $cc6,
        );

        $email = array();
        $cc = array();
        if ($user->email != "") {
            $email[] = $user->email;
        }

        if ($userMail != "") {
            $email[] = $userMail;
        }

        foreach ($repemail as $repmail) {
            if ($repmail->email != "") {
                $email[] = $repmail->email;
            }
        }

        if ($cc1 != "") {
            $cc[] = $cc1;
        }
        if ($cc2 != "") {
            $cc[] = $cc2;
        }
        if ($cc3 != "") {
            $cc[] = $cc3;
        }
        if ($cc4 != "") {
            $cc[] = $cc4;
        }
        if ($cc5 != "") {
            $cc[] = $cc5;
        }
        if ($cc6 != "") {
            $cc[] = $cc6;
        }

        $mail['message'] = '<div style="background: #f1f1f1; text-align: left; width: 700px;"  >
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span>Your Order Details Are Mention Below</span></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Manufacturer:</b></span><span>' . $device->manufacturer->manufacturer_name . '</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Device Name:</b></span>
                                        <span>' . $order['model_name'] . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>Model Name:</b></span><span>' . $order['model_no'] . '</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Order Date:</b></span><span>' . Carbon::parse($order['order_date'])->format('m-d-Y') . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span><b>Order By:</b></span><span>' . $user->name . '</span><br></p>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span><b>Rep:</b></span><span> </span></p><br>
                                        <p style="font-weight: normal; font-size: 19px; margin-top: 15px;"><span>If, Causes Any Problem then Contact us At admin@neptneppa.com</span></p>
                                 </div>';
        $mail['from'] = 'admin@neptuneppa.com';
        $mail['subject'] = $title;
        $mail['status'] = "Send";

        $usermail = new MailList;
        $usermail->fill($mail);

        if ($usermail->save()) {
            if (count($email) > 0) {
                foreach ($email as $mails) {
                    $to['mailId'] = $usermail->id;
                    $to['mail'] = $mails;
                    $to['status'] = "TO";

                    $sendto = new MailTo;
                    $sendto->fill($to);
                    $sendto->save();
                }
            }
            if (count($cc) > 0) {
                foreach ($cc as $c) {
                    $ccmail['mailId'] = $usermail->id;
                    $ccmail['mail'] = $c;
                    $ccmail['status'] = "CC";

                    $sendcc = new MailTo;
                    $sendcc->fill($ccmail);
                    $sendcc->save();
                }
            }
        }

        orderMail($mail_data);

//        schedulemail($device_schedule->id);

        $finaldata = array(
            'client_id' => $client_id,
            'bulk' => $bulk,
            'type' => $type,
        );

        return $finaldata;

    }

}

function orderMail($data) {

    Mail::send('emails.securemail', $data, function ($message) use ($data) {
        $message->from('admin@neptuneppa.com', 'Neptune-PPA')->subject($data['title']);
        if ($data['physician'] != "") {
            $message->to($data['physician']);
        }

        if ($data['order_email'] != "") {
            $message->to($data['order_email']);
        }
        if ($data['cc1'] != "") {
            $message->cc($data['cc1']);
        }

        if ($data['cc2'] != "") {
            $message->cc($data['cc2']);
        }
        if ($data['cc3'] != "") {
            $message->cc($data['cc3']);
        }
        if ($data['cc4'] != "") {
            $message->cc($data['cc4']);
        }
        if ($data['cc5'] != "") {
            $message->cc($data['cc5']);
        }
        if ($data['cc6'] != "") {
            $message->cc($data['cc6']);
        }

        $message->cc('punit@micrasolution.com');

        foreach ($data['rep_email'] as $repmail) {
            if ($repmail->email != "") {
                $message->to($repmail->email);
            }
        }
    });
    return true;
}

function schedulemail($id) {

    $schedules = schedule::join('projects', 'projects.id', '=', 'schedule.project_name')
        ->join('users', 'users.id', '=', 'schedule.physician_name')
        ->join('manufacturers', 'manufacturers.id', '=', 'schedule.manufacturer')
        ->join('device', 'device.id', '=', 'schedule.device_name')
        ->join('clients', 'clients.id', '=', 'schedule.client_name')
        ->select('schedule.*', 'clients.client_name', 'users.name', 'manufacturers.manufacturer_name', 'device.device_name as device', 'projects.project_name as pro_name')
        ->where('schedule.id', '=', $id)
        ->first();

    $title = "Neptune-PPA - Device Schedule Created";
    $projectname = $schedules['pro_name'];
    $clientname = $schedules['client_name'];
    $physician = $schedules['name'];
    $patientid = $schedules['patient_id'];
    $manufacturer = $schedules['manufacturer_name'];
    $device = $schedules['device'];
    $model_name = $schedules['model_no'];
    $rep_name = $schedules['rep_name'];
    $event_date = $schedules['event_date'];
    $start_time = $schedules['start_time'];
    $physicianid = $schedules['physician_name'];

    $date = Carbon::parse($event_date)->format('Ymd');

    $t = Carbon::parse($start_time)->setTimezone('UTC +5:30')->format('His');

    $link = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=Product-Schedule-Details&dates=" . $date . "T" . $t . "/" . $date . "T" . $t . "&details=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . "%0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . "&location&trp=false&sf=true&output=xml#eventpage_6";

    $outlook = "https://outlook.live.com/owa/?rru=addevent&startdt=" . $date . "T" . $t . "&enddt=" . $date . "T" . $t . "&subject=Product-Schedule-Details&location=false&body=Project Name: " . $projectname . "%0A%0A Physician: " . $physician . " %0A%0A Patient ID:" . $patientid . " %0A%0A  Device: " . $device . "%0A%0A Model No.:" . $model_name . " &allday=false&path=/calendar/view/Month";

    $data = array(
        'title' => $title,
        'projectname' => $projectname,
        'clientname' => $clientname,
        'physician' => $physician,
        'patient_id' => $patientid,
        'manufacturer' => $manufacturer,
        'device' => $device,
        'model_no' => $model_name,
        'rep_name' => $rep_name,
        'event_date' => $event_date,
        'start_time' => $start_time,
        'physicianid' => $physicianid,
        'link' => $link,
        'outlook' => $outlook,
        'date' => $date,
        't' => $t,
    );

    $event = ievent($data);
    $path = realpath('public/events/icalender.ics');

    Mail::send('emails.createschedule', $data, function ($message) use ($data, $event) {

        $path = realpath('public/events/icalender.ics');

        $physicianmail = user::where('id', '=', $data['physicianid'])
            ->where('roll', '=', 3)
            ->where('status', '=', 'Enabled')
            ->where('is_delete', '=', 0)
            ->value('email');

        if ($physicianmail != "") {
            $message->to($physicianmail);
        }

        $message->from('admin@neptuneppa.com', 'Neptune-PPA')->subject($data['title']);

        $organization = clients::where('client_name', '=', $data['clientname'])->value('id');

        $deviceId = device::where('device_name', $data['device'])->value('id');

        /*Changes by punit Kathiriya  29-8-2017 12:44PM Start*/

        $customUser = customContact::where('clientId', $organization)->where('deviceId', $deviceId)->first();

        if (!empty($customUser)) {

            if ($customUser['cc1'] != "") {
                $message->cc($customUser['cc1']);
            }

            if ($customUser['cc2'] != "") {
                $message->cc($customUser['cc2']);
            }
            if ($customUser['cc3'] != "") {
                $message->cc($customUser['cc3']);
            }
            if ($customUser['cc4'] != "") {
                $message->cc($customUser['cc4']);
            }
            if ($customUser['cc5'] != "") {
                $message->cc($customUser['cc5']);
            }
            if ($customUser['cc6'] != "") {
                $message->cc($customUser['cc6']);
            }
        }
        /*Changes by punit Kathiriya  29-8-2017 12:44PM End*/

        $projectId = project::where('project_name', $data['projectname'])->value('id');

        $manufacturerId = manufacturers::where('manufacturer_name', $data['manufacturer'])->value('id');

        $projectUser = User::leftjoin('rep_contact_info', 'rep_contact_info.repId', '=', 'users.id')
            ->leftjoin('user_projects', 'user_projects.userId', '=', 'users.id')
            ->where('user_projects.projectId', $projectId)
            ->where('users.organization', $manufacturerId)
            ->where('rep_contact_info.deviceId', $deviceId)
            ->where('rep_contact_info.repStatus', 'Yes')
            ->where('users.roll', '5')
            ->where('users.status', '=', 'Enabled')
            ->where('users.is_delete', '0')
            ->get();

        foreach ($projectUser as $rmail) {
            if ($rmail != "") {
                $message->cc($rmail->email);
            }
        }
        // $message->cc('punitkathiriya@gmail.com');
        $message->cc('punit@micrasolution.com');
        $message->attach(($path), [
            'as' => 'icalender.ics',
            'mime' => 'text/calendar',
        ]);
    });
    return true;

}

function ievent($data) {

    $dat[0] = "BEGIN:VCALENDAR";
    $dat[1] = "VERSION:2.0";
    $dat[2] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
    $dat[3] = "X-PUBLISHED-TTL:P1W";
    $dat[4] = "BEGIN:VEVENT";
    $dat[5] = "UID:admin@neptune-ppa.com";
    $dat[6] = "DTSTART:" . $data['date'] . "T" . $data['t'];
    $dat[7] = "SEQUENCE:0";
    $dat[8] = "TRANSP:OPAQUE";
    $dat[9] = "DTEND:" . $data['date'] . "T" . $data['t'];
    $dat[10] = "LOCATION:";
    $dat[11] = "SUMMARY:Neptune-PPA Event Schedule";
    $dat[12] = "CLASS:PUBLIC";
    $dat[13] = "DESCRIPTION:Project Name:-" . $data['projectname'] . " Physician:- " . $data['physician'] . "  Patient ID:- " . $data['patient_id'] . "  Device:-" . $data['device'] . " Model No.:-" . $data['model_no'] . "";
    $dat[14] = "ORGANIZER:Neptune-PPA<admin@neptune-ppa.com>";
    $dat[15] = "DTSTAMP:" . $data['date'];
    $dat[16] = "END:VEVENT";
    $dat[17] = "END:VCALENDAR";

    $filenames = 'icalender.ics';
    header('Content-type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filenames);
    $dat = implode("\r\n", $dat);

    file_put_contents('public/events/' . $filenames, $dat);

}

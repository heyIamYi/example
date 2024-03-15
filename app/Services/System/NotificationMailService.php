<?php

namespace App\Services\System;

use App\Mail\ContactUsMail;
use App\Mail\ReservationMail;
use App\Repositories\ContactMailRepository;
use App\Services\System\BaseService;
use Illuminate\Support\Facades\Mail;

class NotificationMailService extends BaseService
{
    protected $contactMailRepo;

    public function __consturct(
        ContactMailRepository $contactMailRepo
    ) {
        $this->contactMailRepo = $contactMailRepo;
    }

    /**
     *  通知業主公司的郵件
     */

    public function sendContactUsEmail($input)
    {
        // 性別轉換
        $gender = (($input->gender == 0) ? '男生' : (($input->gender == 1) ? '女生' : '未指定'));

        $formData = [
            'name' => $input->name,
            'gender' => $gender ?? '未指定',
            'tel' => $input->tel,
            'email' => $input->email,
            'content' => $input->content,
            'created_at' => $input->created_at,
        ];

        $contactMails = $this->contactMailRepo->where('is_show', '=', 1)->get();

        if ($contactMails->isNotEmpty()) {
            $emails = $contactMails->pluck('email')->toArray();
            Mail::to($emails)->send(new ContactUsMail($formData));
        }

    }
    /**
     *  預約行程的郵件
     */

    public function sendReservationEmail($input)
    {
        // 性別轉換
        $gender = (($input->gender == 0) ? '男生' : (($input->gender == 1) ? '女生' : '未指定'));

        $formData = [
            'name' => $input->name,
            'gender' => $gender ?? '未指定',
            'tel' => $input->tel,
            'email' => $input->email,
            'trip_title' => $input->trip_title,
            'requirement_description' => $input->requirement_description,
            'created_at' => $input->created_at,
        ];

        $contactMails = $this->contactMailRepo->where('is_show', '=', 1)->get();

        if ($contactMails->isNotEmpty()) {
            $emails = $contactMails->pluck('email')->toArray();
            Mail::to($emails)->send(new ReservationMail($formData));
        }

    }

}

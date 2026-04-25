<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function submitContact()
    {
        helper(['form', 'url']);

        // ✅ Validation Rules
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name'  => 'required|min_length[2]|max_length[100]',
            'email'      => 'required|valid_email',
            'number'     => 'required|min_length[10]|max_length[15]',
            'message'    => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please fill all required fields correctly.',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ✅ Get sanitized POST data
        $firstName = $this->request->getPost('first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName  = $this->request->getPost('last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email     = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $phone     = $this->request->getPost('number', FILTER_SANITIZE_SPECIAL_CHARS);
        $message   = $this->request->getPost('message', FILTER_SANITIZE_SPECIAL_CHARS);

        $fullName = $firstName . ' ' . $lastName;

        // ✅ reCAPTCHA Verification
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');

        if (empty($recaptchaResponse)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please complete the captcha.'
            ]);
        }


        $client = \Config\Services::curlrequest();

        try {
        $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => '6LegYmssAAAAACsyDvgQ_urL79dLlcrfkk406k96', // Your SECRET key
                'response' => $recaptchaResponse,
                'remoteip' => $this->request->getIPAddress()
            ]
        ]);


            $body = json_decode($res->getBody());

        } catch (\Exception $e) {
            $body = null;
        }

        if (empty($body) || !$body->success) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Captcha verification failed. Please try again.'
            ]);
        }

        // ✅ Email HTML Template
        $html = "
        <h2>New Contact Enquiry</h2>
        <p><strong>First Name:</strong> {$firstName}</p>
        <p><strong>Last Name:</strong> {$lastName}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
        <hr>
        <small>Sent on: " . date('d M Y h:i A') . "</small>
        ";

        // ✅ Email Configuration (SMTP Recommended)
        $emailService = \Config\Services::email();

        $emailService->initialize([
            'protocol'   => 'smtp',
            'SMTPHost'   => 'mail.whatelse.in',
            'SMTPUser'   => 'info@whatelse.in',
            'SMTPPass'   => 'HjB(0y#Z8^!$',
            'SMTPPort'   => 465,
            'SMTPCrypto' => 'ssl',
            'mailType'   => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
        ]);

        $emailService->setFrom('info@whatelse.in', 'Your Company Name');
        $emailService->setTo('jayamweb.developer@gmail.com');
        $emailService->setSubject("New Enquiry from $fullName");
        $emailService->setMessage($html);

        // ✅ Send Email
        if ($emailService->send()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Your enquiry has been sent successfully!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Failed to send email. Please try again later.'
        ]);
    }
}

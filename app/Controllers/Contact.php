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
            'name'        => 'required|min_length[2]|max_length[100]',
            'phone'       => 'required|min_length[10]|max_length[15]',
            'message'     => 'permit_empty',
        ];

        // Email, destination, etc. are only required if they are present in the form (detailed enquiry)
        if ($this->request->getPost('email') !== null) {
            $rules['email'] = 'required|valid_email';
        }
        if ($this->request->getPost('destination') !== null) {
            $rules['destination'] = 'required';
        }
        if ($this->request->getPost('travel_date') !== null) {
            $rules['travel_date'] = 'required';
        }
        if ($this->request->getPost('passengers') !== null) {
            $rules['passengers'] = 'required';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please fill all required fields correctly.',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // ✅ Get sanitized POST data
        $name        = $this->request->getPost('name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email       = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $phone       = $this->request->getPost('phone', FILTER_SANITIZE_SPECIAL_CHARS);
        $destination = $this->request->getPost('destination', FILTER_SANITIZE_SPECIAL_CHARS);
        $travelDate  = $this->request->getPost('travel_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $passengers  = $this->request->getPost('passengers', FILTER_SANITIZE_SPECIAL_CHARS);
        $message     = $this->request->getPost('message', FILTER_SANITIZE_SPECIAL_CHARS);
        $service     = $this->request->getPost('service', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'General Enquiry';

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
            $secretKey = '6LdV548sAAAAAAV49uu_3Aa4Zh5uI2RNrQCKBLFP'; 
            $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => $secretKey,
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

        // ✅ Build Email Content dynamically
        $html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee;'>
            <h2 style='color: #2C79BB;'>New Travel Enquiry</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Phone:</strong> {$phone}</p>";

        if (!empty($email))       $html .= "<p><strong>Email:</strong> {$email}</p>";
        if (!empty($destination)) $html .= "<p><strong>Destination:</strong> {$destination}</p>";
        if (!empty($travelDate))  $html .= "<p><strong>Travel Date:</strong> {$travelDate}</p>";
        if (!empty($passengers))  $html .= "<p><strong>Number of Passengers:</strong> {$passengers}</p>";

        $html .= "
            <p><strong>Service Interested:</strong> {$service}</p>
            <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
            <hr style='border: none; border-top: 1px solid #eee;'>
            <p style='font-size: 12px; color: #777;'>Sent from Travel Needs Website Enquiry Form on " . date('d M Y h:i A') . "</p>
        </div>";

        $db = \Config\Database::connect();
        $smtp = $db->table('web_smtp')->where('web_smtp_id', 1)->get()->getRowArray();

        $smtpHost = !empty($smtp['web_host_mail']) ? $smtp['web_host_mail'] : 'mail.whatelse.in';
        $smtpUser = !empty($smtp['web_user_mail']) ? $smtp['web_user_mail'] : 'info@whatelse.in';
        $smtpPass = !empty($smtp['web_pass']) ? $smtp['web_pass'] : 'HjB(0y#Z8^!$';
        $smtpPort = !empty($smtp['web_port']) ? $smtp['web_port'] : 587;
        $smtpCrypto = !empty($smtp['web_crypto']) ? $smtp['web_crypto'] : 'tls';
        $toMail = !empty($smtp['web_to_mail']) ? $smtp['web_to_mail'] : 'jayamweb.developer2@gmail.com';

        $emailService = \Config\Services::email();

        $emailService->initialize([
            'protocol'   => 'smtp',
            'SMTPHost'   => $smtpHost,
            'SMTPUser'   => $smtpUser,
            'SMTPPass'   => $smtpPass,
            'SMTPPort'   => (int)$smtpPort,
            'SMTPCrypto' => $smtpCrypto,
            'mailType'   => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
        ]);

        $emailService->setFrom($smtpUser, 'Travel Needs');
        $emailService->setTo($toMail);
        $emailService->setSubject("New Travel Enquiry - " . $name);
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

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class MainPage extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper("util");
    }

    public function reorderDisplayOrder(
        string $table,
        string $primaryKey,
        int $currentId,
        int $newOrder,
        string $operation,
        string $isDeletedField = 'is_deleted'
    ): void {
        $builder = $this->db->table($table);
        $orderField = 'display_order';
        if ($operation === 'delete') {
            $row = $builder->where($primaryKey, $currentId)->get()->getRow();
            if (!$row)
                return;
            $deletedOrder = (int) $row->$orderField;
            $builder->set($orderField, "$orderField - 1", false)
                ->where($orderField . ' >', $deletedOrder)
                ->where("{$isDeletedField} !=", 1)
                ->update();
        } elseif ($operation === 'insert') {
            $builder->set($orderField, "$orderField + 1", false)
                ->where($orderField . ' >=', $newOrder)
                ->where("{$isDeletedField} !=", 1)
                ->update();
        } elseif ($operation === 'update') {
            $row = $builder->where($primaryKey, $currentId)->get()->getRow();
            if (!$row)
                return;

            $oldOrder = (int) $row->$orderField;

            if ($newOrder < $oldOrder) {
                $builder->set($orderField, "$orderField + 1", false)
                    ->where($orderField . ' >=', $newOrder)
                    ->where($orderField . ' <', $oldOrder)
                    ->where($primaryKey . ' !=', $currentId)
                    ->where("{$isDeletedField} !=", 1)
                    ->update();
            } elseif ($newOrder > $oldOrder) {
                $builder->set($orderField, "$orderField - 1", false)
                    ->where($orderField . ' <=', $newOrder)
                    ->where($orderField . ' >', $oldOrder)
                    ->where($primaryKey . ' !=', $currentId)
                    ->where("{$isDeletedField} !=", 1)
                    ->update();
            }
        }
    }

    //Menu
    public function pageMenu()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Menu";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Menu <i style="font-size:14px" class="fas fa-chevron-right"></i> <span> </span></div>';
        return view('admin/pages/menu', $page);
    }

    public function getMenu()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_menu')
            ->select('web_menu_id,web_title,web_url, 
            concat("' . MENU_IMG . '",web_image) as web_image,created_on,meta_title,meta_desc,meta_key,is_active')
            ->where('is_deleted', 0)
            ->where('web_menu_id !=', 1);
        if ($this->request->getPost('web_menu_id', NULL)) {
            $data->where('web_menu_id', $this->request->getPost('web_menu_id', NULL));
        }
        $data = $data->orderBy('web_menu_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        return $this->respond(data: $data, message: 'successfully');
    }

    public function saveMenu()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "edit":
                $manda_arr = ['web_menu_id'];
                $allowedFields = ['web_title', 'web_image', 'meta_title', 'meta_desc', 'meta_key', 'is_active'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the upload directory (root folder)
            $uploadPath = ROOTPATH . 'images/menu/';

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = "menu_" . rand(99, 9999) . time() . '.' . $file->getExtension();

            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }
            $data['web_image'] = $newName;
        } else if ($data['web_menu_id'] == -1) {
            return $this->respond([], "Unable to save Image OR Missing Image", 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if (isset($updateData['web_title']) && isset($data['web_menu_id']) && $data['web_menu_id'] != 1) {
            $updateData['web_url'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $updateData['web_title']), '-'));
        }

        $builder = $this->db->table('web_menu');

        if ($data['web_menu_id'] > 0) {

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_menu_id', $data['web_menu_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {
            return $this->respond($data, 'Unable to save Data', 404);
        }
        return $this->respond([], 'successfully');
    }

    //Home Page Meta Tags SEO
    public function pageHomeMeta()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Home Meta Tags";
        $page['data'] = $this->db->table('web_menu')
            ->select('meta_title, meta_desc, meta_key')
            ->where('web_menu_id', 1)
            ->get()->getRowArray();
        return view('admin/pages/home_meta', $page);
    }

    public function saveHomeMeta()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check format
        if (($data['for'] ?? '') !== "edit_home_meta") {
            return $this->respond([], "Missing Data 'for'", 404);
        }

        $allowedFields = ['meta_title', 'meta_desc', 'meta_key'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $this->db->table('web_menu')->where('web_menu_id', 1)->update($updateData);
        return $this->respond([], 'successfully');
    }

    //Setting
    public function pageSetting()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Setting";
        $page['data'] = $this->db->table('web_setting')
            ->select('*')
            ->where('web_setting_id', 1)
            ->get()->getRowArray();
        $page['breadcrumb'] = '<div class="own-breadcrumb">Contact Us <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Contact Us </span></div>';
        return view('admin/pages/setting', $page);
    }

    public function saveSetting()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $data['web_setting_id'] = 1;
        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "edit":
                $manda_arr = [];
                $allowedFields = [
                    "about_content",
                    "social_title",
                    "facebook_url",
                    "x_url",
                    "instagram_url",
                    "linkedin_url",
                    "youtube_url",
                    "pinterest_url",
                    "whatsapp_url",
                    "user_email",
                    "user_phone_1",
                    "user_phone_2",
                    "contentus_title",
                    "contentus_title_content",
                    "map_url",
                    "address_1",
                    "address_2",
                    "address_3",
                    "address_4",
                    "state",
                    "country",
                    "pincode",
                    "web_content_1",
                    "web_content_2",
                    "web_content_3",
                    "usa_address",
                    "usa_phone",
                    "usa_email",
                    "uae_address",
                    "uae_phone",
                    "uae_email",
                    "usa_flag",
                    "uae_flag"
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        // File handling for flags
        $path = ROOTPATH . 'images/event/';
        if (!is_dir($path)) mkdir($path, 0755, true);

        $usa_flag = $this->request->getFile('usa_flag');
        if ($usa_flag && $usa_flag->isValid() && !$usa_flag->hasMoved()) {
            $newName = 'usa_flag_' . time() . '.' . $usa_flag->getExtension();
            $usa_flag->move($path, $newName);
            $data['usa_flag'] = $newName;
        }

        $uae_flag = $this->request->getFile('uae_flag');
        if ($uae_flag && $uae_flag->isValid() && !$uae_flag->hasMoved()) {
            $newName = 'uae_flag_' . time() . '.' . $uae_flag->getExtension();
            $uae_flag->move($path, $newName);
            $data['uae_flag'] = $newName;
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_setting');
        if ($data['web_setting_id'] > 0) {
            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_setting_id', $data['web_setting_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {
            return $this->respond($data, 'Unable to save Data', 404);
        }
        return $this->respond([], 'successfully');
    }

    //SMTP Setting
    public function pageSmtp()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "SMTP Setting";
        $page['data'] = $this->db->table('web_smtp')
            ->select('*')
            ->where('web_smtp_id', 1)
            ->get()->getRowArray();
        $page['breadcrumb'] = '<div class="own-breadcrumb">SMTP<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>SMTP Setting </span></div>';
        return view('admin/pages/smtp', $page);
    }

    public function saveSmtp()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $data['web_smtp_id'] = 1;
        // Check Mandatory Fields
        switch ($data['for'] ?? '') {
            case "edit":
                $manda_arr = [];
                $allowedFields = [
                    "web_host_mail",
                    "web_user_mail",
                    "web_pass",
                    "web_port",
                    "web_crypto",
                    "web_to_mail"
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_smtp');
        if ($data['web_smtp_id'] > 0) {
            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_smtp_id', $data['web_smtp_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {
            return $this->respond($data, 'Unable to save Data', 404);
        }
        return $this->respond([], 'successfully');
    }

    //Banner
    public function pageBanner()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Banner";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Banner </span></div>';

        // Fetch menus for the button_url select
        $menus = $this->db->table('web_menu')
            ->select('web_menu_id, web_title, web_url')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()->getResultArray();

        foreach ($menus as &$menu) {
            if (empty($menu['web_url']) || $menu['web_url'] === '0') {
                if ($menu['web_menu_id'] == 1) $menu['web_url'] = '/';
                elseif ($menu['web_menu_id'] == 2) $menu['web_url'] = 'about-us';
                elseif ($menu['web_menu_id'] == 3) $menu['web_url'] = 'services';
                elseif ($menu['web_menu_id'] == 4) $menu['web_url'] = 'gallery';
                elseif ($menu['web_menu_id'] == 5) $menu['web_url'] = 'contact-us';
            }
        }
        $page['menus'] = $menus;

        // Fetch services for the button_url select
        $services = $this->db->table('web_approach')
            ->select('web_approach_id, web_title, web_url')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($services as &$service) {
            if (empty($service['web_url']) || $service['web_url'] === '0') {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $service['web_title']), '-'));
                $service['web_url'] = 'services/' . $slug;
            }
        }
        $page['services'] = $services;

        return view('admin/pages/banner', $page);
    }

    public function getBanner()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_banner')
            ->select('web_banner_id,
            web_title,
            web_content,
            web_description, 
            concat("' . BANNER_IMG . '",web_image) as web_image,
            display_order,
            created_on,
            is_active,
            button_url')
            ->where('is_deleted', 0);
        if ($this->request->getPost('web_banner_id', NULL)) {
            $data->where('web_banner_id', $this->request->getPost('web_banner_id', NULL));
        }
        $data = $data->orderBy('web_banner_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_banner')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function saveBanner()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fields
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_banner_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_banner',
                    primaryKey: 'web_banner_id',
                    currentId: $data['web_banner_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_banner_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = ['web_banner_id'];
                // Add 'button_url' field (the slug/url for the banner button)
                $allowedFields = ['web_title', 'web_content', 'web_image', 'display_order', 'web_description', 'button_url'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the upload directory (root folder)
            $uploadPath = ROOTPATH . 'images/banner/';

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = "banner_" . rand(99, 9999) . time() . '.' . $file->getExtension();

            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }
            $data['web_image'] = $newName;
        } else if ($data['web_banner_id'] == -1) {
            return $this->respond([], "Unable to save Image OR Missing Image", 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_banner');

        if ($data['web_banner_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_banner',
                    primaryKey: 'web_banner_id',
                    currentId: $data['web_banner_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_banner_id', $data['web_banner_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_banner',
                primaryKey: 'web_banner_id',
                currentId: $data['web_banner_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }

    //enable ||disable function 
    public function pagefunctionmanage()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        $web_content_id = $data['web_content_id'];
        $is_active = $data['is_active'];

        $page['data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', $web_content_id)
            ->get()->getRowArray();
        $builder = $this->db->table('web_content');

        $updateData['status'] = $is_active;
        $updateData['updated_by'] = session()->get('user_login_id');
        $updateData['updated_on'] = date('Y-m-d H:i:s');
        $builder->where('web_content_id', $web_content_id);
        if (!$builder->update($updateData)) {
            return $this->respond($data, 'Unable Update Data', 404);
        }
        return $this->respond([], 'successfully');
    }

    // Home Page About
    public function pageHomeAbout()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*, concat("' . CONTENT_IMG . '", web_image_1) as image, concat("' . CONTENT_IMG . '", web_image_2) as image2')
            ->where('web_content_id', 1)
            ->get()->getRowArray();
        // log_message('error', print_r($page['data'], true));

        $page['title'] = "Home About";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span> Home About Content </span></div>';
        return view('admin/pages/homeaboutcontent', $page);
    }

    public function pageHomeMission()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 22)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $default_text = "Circuit Brilliance is built to be more than a design service — it is a growing power electronics design hub, bringing together deep engineering expertise, structured processes, and real-world project exPerience to serve the global EV and renewable energy community.";
            $this->db->table('web_content')->insert(['web_content_id' => 22, 'status' => 1, 'web_content_1' => $default_text]);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 22)->get()->getRowArray();
        }

        $page['title'] = "Mission Hub";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Mission Hub</span></div>';
        return view('admin/pages/homemission', $page);
    }

    // Home our services
    public function pageAboutOurBusiness()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }



        $page['title'] = "What We Design";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>What We Design</span></div>';
        $page['data'] = $this->db->table('web_business')
            ->select('web_business_id, web_title, web_content, CONCAT("' . BUSINESS_IMG . '", web_image) as web_image, display_order, created_on, is_active')
            ->where('is_deleted', 0)
            ->orderBy('display_order')
            ->get()->getResultArray();

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 2)
            ->get()->getRowArray();
        // $page['title'] = "About";
        // $page['breadcrumb'] = '<div class="own-breadcrumb">About Our Industry <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Content</span></div>';
        return view('admin/pages/whatwedesign', $page);
    }

    public function getAboutOurBusiness()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->db->table('web_business')
            ->select('web_business_id, web_title, CONCAT("' . BUSINESS_IMG . '", web_image) as web_image,web_content,display_order, created_on, is_active')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_business_id', NULL)) {
            $data->where('web_business_id', $this->request->getPost('web_business_id', NULL));
        }
        $data = $data->orderBy('web_business_id')->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_business')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: ($data_count['data_count'] ?? 1)
        );
    }

    public function saveAboutOurBusiness()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $db = \Config\Database::connect();
        $data = $this->request->getPost();
        $action = $data['for'] ?? '';
        $isNew  = ($data['web_business_id'] == -1);
        $builder = $db->table('web_business');

        // Handle Image Upload First
        $uploadedImage = null;
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = ROOTPATH . 'images/business/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = 'business_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientExtension();
            if ($file->move($uploadPath, $newName)) {
                $uploadedImage = $newName;
            } else {
                return $this->respond([], 'Failed to upload image', 500);
            }
        }

        switch ($action) {
            case 'delete':
                if (empty($data['web_business_id'])) {
                    return $this->respond([], 'ID required', 400);
                }

                $this->reorderDisplayOrder(
                    table: 'web_business',
                    primaryKey: 'web_business_id',
                    currentId: $data['web_business_id'],
                    newOrder: 0,
                    operation: 'delete'
                );

                $builder->where('web_business_id', $data['web_business_id'])
                    ->update(['is_deleted' => 1]);
                break;

            case 'status':
                if (empty($data['web_business_id']) || !isset($data['is_active'])) {
                    return $this->respond([], 'Invalid status', 400);
                }

                $builder->where('web_business_id', $data['web_business_id'])
                    ->update(['is_active' => $data['is_active'] ? 1 : 0]);
                break;

            case 'edit':
                // Required fields: Title and Display Order only. Content is NOT required.
                if (empty($data['web_title']) || !isset($data['display_order'])) {
                    return $this->respond([], 'Title and Display Order are required', 400);
                }

                if ($isNew && !$uploadedImage) {
                    return $this->respond([], 'Image is required when adding new item', 400);
                }

                $saveData = [
                    'web_title'     => trim($data['web_title']),
                    'display_order' => (int)$data['display_order'],
                ];

                // Only set web_content if it's set in the data
                if (isset($data['web_content'])) {
                    $saveData['web_content'] = $data['web_content'];
                }

                if ($uploadedImage) {
                    $saveData['web_image'] = $uploadedImage;
                }

                if ($isNew) {
                    // INSERT NEW
                    $this->reorderDisplayOrder(
                        table: 'web_business',
                        primaryKey: 'web_business_id',
                        currentId: 0,
                        newOrder: $saveData['display_order'],
                        operation: 'insert'
                    );

                    $saveData['is_active']   = 1;
                    $saveData['is_deleted']  = 0;
                    $saveData['created_at']  = date('Y-m-d H:i:s');

                    $builder->insert($saveData);
                } else {
                    // UPDATE EXISTING
                    $this->reorderDisplayOrder(
                        table: 'web_business',
                        primaryKey: 'web_business_id',
                        currentId: $data['web_business_id'],
                        newOrder: $saveData['display_order'],
                        operation: 'update'
                    );

                    $saveData['updated_at'] = date('Y-m-d H:i:s');

                    $builder->where('web_business_id', $data['web_business_id'])
                        ->update($saveData);
                }
                break;

            default:
                return $this->respond([], 'Invalid action', 400);
        }

        return $this->respond([], 'successfully');
    }

    //Our Design

    public function pageServiceCate()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 4)
            ->get()->getRowArray();
        $page['title'] = "Our Design";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Our Design</span></div>';
        return view('admin/pages/ourdesign', $page);
    }

    public function getServiceCate()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_service_cate')
            ->select('web_service_cate_id,web_title,web_icon,web_content,display_order,created_on,display_order,is_active')
            ->where('is_deleted', 0);
        if ($this->request->getPost('web_service_cate_id', NULL)) {
            $data->where('web_service_cate_id', $this->request->getPost('web_service_cate_id', NULL));
        }
        $data = $data->orderBy('web_service_cate_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_service_cate')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function saveServiceCate()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_service_cate_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_service_cate',
                    primaryKey: 'web_service_cate_id',
                    currentId: $data['web_service_cate_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_service_cate_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = ['web_service_cate_id', 'web_title', 'web_icon', 'web_content',];
                $allowedFields = ['web_title', 'web_icon', 'web_content', 'display_order'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }


        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_service_cate');

        if ($data['web_service_cate_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_service_cate',
                    primaryKey: 'web_service_cate_id',
                    currentId: $data['web_service_cate_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_service_cate_id', $data['web_service_cate_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_service_cate',
                primaryKey: 'web_service_cate_id',
                currentId: $data['web_service_cate_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }

    //page why choose
    public function pageWhyChooseUs()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 12)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 12, 'status' => 1, 'web_content_1' => '', 'web_content_2' => '']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 12)->get()->getRowArray();
        }

        $page['title'] = "Why Choose Us";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Why Choose Us</span></div>';
        return view('admin/pages/whychoose', $page);
    }

    public function getWhyChooseUs()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_why_choose')
            ->select('web_why_choose_id,web_title,web_subtitle,web_heading,web_icon,web_content,display_order,created_on,is_active')
            ->where('is_deleted', 0);
        if ($this->request->getPost('web_why_choose_id', NULL)) {
            $data->where('web_why_choose_id', $this->request->getPost('web_why_choose_id', NULL));
        }
        $data = $data->orderBy('web_why_choose_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_why_choose')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function saveWhyChooseUs()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_why_choose_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_why_choose',
                    primaryKey: 'web_why_choose_id',
                    currentId: $data['web_why_choose_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_why_choose_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = ['web_why_choose_id', 'web_title', 'web_heading', 'web_icon', 'web_content',];
                $allowedFields = ['web_title', 'web_subtitle', 'web_heading', 'web_icon', 'web_content', 'display_order'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }


        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_why_choose');

        if ($data['web_why_choose_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_why_choose',
                    primaryKey: 'web_why_choose_id',
                    currentId: $data['web_why_choose_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_why_choose_id', $data['web_why_choose_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_why_choose',
                primaryKey: 'web_why_choose_id',
                currentId: $data['web_why_choose_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }
    // page home industry


    // AJAX - Get About Our Business Data
    // <?php

    // Add these methods to the MainPage controller class in MainPage.php






    // our products
    public function pageClients()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 3)
            ->get()->getRowArray();

        $page['title'] = "Home Gallery";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Home Gallery</span></div>';

        return view('admin/pages/brand', $page);
    }

    public function getBrand()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_brand')
            ->select('web_brand_id,
            concat("' . BRAND_IMG . '",web_image) as web_image,display_order,is_active')
            ->where('is_deleted', 0);
        if ($this->request->getPost('web_brand_id', NULL)) {
            $data->where('web_brand_id', $this->request->getPost('web_brand_id', NULL));
        }
        $data = $data->orderBy('web_brand_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_brand')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function saveBrand()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_brand_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_brand',
                    primaryKey: 'web_brand_id',
                    currentId: $data['web_brand_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_brand_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "dashboard":
                $manda_arr = ['web_brand_id', 'is_dashboard'];
                $allowedFields = ['is_dashboard'];
                break;

            case "edit":
                $manda_arr = ['web_brand_id'];
                $allowedFields = ['web_image', 'display_order'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the upload directory (root folder)
            $uploadPath = ROOTPATH . 'images/brand/';

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = "project_" . rand(99, 9999) . time() . '.' . $file->getExtension();

            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }
            $data['web_image'] = $newName;
        } else if ($data['web_brand_id'] == -1) {
            return $this->respond([], "Unable to save Image OR Missing Image", 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_brand');

        if ($data['web_brand_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_brand',
                    primaryKey: 'web_brand_id',
                    currentId: $data['web_brand_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_brand_id', $data['web_brand_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_brand',
                primaryKey: 'web_brand_id',
                currentId: $data['web_brand_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }


    // ABOUT

    public function pageAboutAbout()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', 7)
            ->get()->getRowArray();

        $page['title'] = "About";
        $page['breadcrumb'] = '<div class="own-breadcrumb">About<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>About Us</span></div>';
        return view('admin/pages/aboutcontent', $page);
    }
    //About Vision
    public function pageAboutVision()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "About Vision & HUB";
        $page['breadcrumb'] = '<div class="own-breadcrumb">About<i style="font-size:14px" class="fas fa-chevron-right"></i> <span> Our Vision & HUB</span></div>';
        $page['data'] = $this->db->table('web_content')
            ->select('*, concat("' . CONTENT_IMG . '", web_image_1) as image')
            ->where('web_content_id', 5)
            ->get()->getRowArray();
        return view('admin/pages/aboutvision', $page);
    }
    public function pageAboutMission()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Our Approach";
        $page['breadcrumb'] = '<div class="own-breadcrumb">About<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Our Approach</span></div>';
        $page['data'] = $this->db->table('web_content')
            ->select('*, concat("' . CONTENT_IMG . '", web_image_1) as image')
            ->where('web_content_id', 6)
            ->get()->getRowArray();
        return view('admin/pages/aboutapproach', $page);
    }

    // our core values
    public function pageAboutOurIndustry()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }



        // $page['title'] = " Our offer ";
        // $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span> our offer</span></div>';
        $page['data'] = $this->db->table('web_industry')
            ->select('web_industry_id, web_title,CONCAT("' . INDUSTRY_IMG . '", web_image) as web_image, display_order, created_on, is_active')
            ->where('is_deleted', 0)
            ->orderBy('display_order')
            ->get()->getResultArray();

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 8)
            ->get()->getRowArray();
        $page['title'] = "Our Core Values";
        $page['breadcrumb'] = '<div class="own-breadcrumb"> About<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Our Core Values</span></div>';

        return view('admin/pages/ouroffer', $page);
    }
    public function getAboutOurIndustry()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->db->table('web_industry')
            ->select('web_industry_id, web_title, CONCAT("' . INDUSTRY_IMG . '", web_image) as web_image, web_content,display_order, created_on, is_active')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_industry_id', NULL)) {
            $data->where('web_industry_id', $this->request->getPost('web_industry_id', NULL));
        }
        $data = $data->orderBy('web_industry_id')->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_industry')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: ($data_count['data_count'] ?? 1)
        );
    }

    public function saveAboutOurIndustry()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $db = \Config\Database::connect();
        $data = $this->request->getPost();
        $action = $data['for'] ?? '';
        $isNew  = ($data['web_industry_id'] == -1);
        $builder = $db->table('web_industry');

        // Handle Image Upload First
        $uploadedImage = null;
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = ROOTPATH . 'images/industry/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = 'industry_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientExtension();
            if ($file->move($uploadPath, $newName)) {
                $uploadedImage = $newName;
            } else {
                return $this->respond([], 'Failed to upload image', 500);
            }
        }

        switch ($action) {
            case 'delete':
                if (empty($data['web_industry_id'])) {
                    return $this->respond([], 'ID required', 400);
                }

                $this->reorderDisplayOrder(
                    table: 'web_industry',
                    primaryKey: 'web_industry_id',
                    currentId: $data['web_industry_id'],
                    newOrder: 0,
                    operation: 'delete'
                );

                $builder->where('web_industry_id', $data['web_industry_id'])
                    ->update(['is_deleted' => 1]);
                break;

            case 'status':
                if (empty($data['web_industry_id']) || !isset($data['is_active'])) {
                    return $this->respond([], 'Invalid status', 400);
                }

                $builder->where('web_industry_id', $data['web_industry_id'])
                    ->update(['is_active' => $data['is_active'] ? 1 : 0]);
                break;

            case 'edit':
                // Required fields
                if (empty($data['web_title']) || !isset($data['display_order'])) {
                    return $this->respond([], 'Title and Display Order are required', 400);
                }

                if ($isNew && !$uploadedImage) {
                    return $this->respond([], 'Image is required when adding new item', 400);
                }

                $saveData = [
                    'web_title'     => trim($data['web_title']),
                    'display_order' => (int)$data['display_order'],
                ];

                // content is not required, but include it if present
                if (isset($data['web_content'])) {
                    $saveData['web_content'] = $data['web_content'];
                }

                if ($uploadedImage) {
                    $saveData['web_image'] = $uploadedImage;
                }

                if ($isNew) {
                    // INSERT NEW
                    $this->reorderDisplayOrder(
                        table: 'web_industry',
                        primaryKey: 'web_industry_id',
                        currentId: 0,
                        newOrder: $saveData['display_order'],
                        operation: 'insert'
                    );

                    $saveData['is_active']   = 1;
                    $saveData['is_deleted']  = 0;
                    $saveData['created_at']  = date('Y-m-d H:i:s');

                    $builder->insert($saveData);
                } else {
                    // UPDATE EXISTING
                    $this->reorderDisplayOrder(
                        table: 'web_industry',
                        primaryKey: 'web_industry_id',
                        currentId: $data['web_industry_id'],
                        newOrder: $saveData['display_order'],
                        operation: 'update'
                    );

                    $saveData['updated_at'] = date('Y-m-d H:i:s');

                    $builder->where('web_industry_id', $data['web_industry_id'])
                        ->update($saveData);
                }
                break;

            default:
                return $this->respond([], 'Invalid action', 400);
        }

        return $this->respond([], 'successfully');
    }

    // Cred Badges
    public function pageCredBadges()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title'] = "Cred Badges";
        $page['breadcrumb'] = '<div class="own-breadcrumb"> About <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Cred Badges</span></div>';
        return view('admin/pages/cred_badges', $page);
    }

    // What We Believe - About Page
    public function pageAboutBeliefs()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 14)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 14, 'status' => 1, 'web_content_1' => 'What We Believe']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 14)->get()->getRowArray();
        }

        $page['title'] = "What We Believe";
        $page['breadcrumb'] = '<div class="own-breadcrumb">About <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>What We Believe</span></div>';
        return view('admin/pages/aboutbeliefs', $page);
    }

    public function getCredBadges()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->db->table('web_cred_badge')
            ->select('web_cred_badge_id, web_icon, web_title, web_label, display_order, created_at, is_active')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_cred_badge_id', NULL)) {
            $data->where('web_cred_badge_id', $this->request->getPost('web_cred_badge_id', NULL));
        }
        $data = $data->orderBy('display_order')->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_cred_badge')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: ($data_count['data_count'] ?? 1)
        );
    }

    // How We Work - About Page
    public function pageAboutHowWeWork()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 9)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 9, 'status' => 1, 'web_content_1' => 'How We Work']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 9)->get()->getRowArray();
        }

        $page['title'] = "How We Work";
        $page['breadcrumb'] = '<div class="own-breadcrumb">About <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>How We Work</span></div>';
        return view('admin/pages/howwework', $page);
    }

    public function saveCredBadge()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $action = $data['for'] ?? '';
        $isNew  = ($data['web_cred_badge_id'] == -1);
        $builder = $this->db->table('web_cred_badge');

        switch ($action) {
            case 'delete':
                if (empty($data['web_cred_badge_id'])) {
                    return $this->respond([], 'ID required', 400);
                }

                $this->reorderDisplayOrder(
                    table: 'web_cred_badge',
                    primaryKey: 'web_cred_badge_id',
                    currentId: $data['web_cred_badge_id'],
                    newOrder: 0,
                    operation: 'delete'
                );

                $builder->where('web_cred_badge_id', $data['web_cred_badge_id'])
                    ->update(['is_deleted' => 1]);
                break;

            case 'status':
                if (empty($data['web_cred_badge_id']) || !isset($data['is_active'])) {
                    return $this->respond([], 'Invalid status', 400);
                }

                $builder->where('web_cred_badge_id', $data['web_cred_badge_id'])
                    ->update(['is_active' => $data['is_active'] ? 1 : 0]);
                break;

            case 'edit':
                if (empty($data['web_title']) || empty($data['web_icon']) || !isset($data['display_order'])) {
                    return $this->respond([], 'Title, Icon and Display Order are required', 400);
                }

                $saveData = [
                    'web_icon'      => trim($data['web_icon']),
                    'web_title'     => trim($data['web_title']),
                    'web_label'     => trim($data['web_label'] ?? ''),
                    'display_order' => (int)$data['display_order'],
                ];

                if ($isNew) {
                    $this->reorderDisplayOrder(
                        table: 'web_cred_badge',
                        primaryKey: 'web_cred_badge_id',
                        currentId: 0,
                        newOrder: $saveData['display_order'],
                        operation: 'insert'
                    );

                    $saveData['is_active']   = 1;
                    $saveData['is_deleted']  = 0;
                    $saveData['created_at']  = date('Y-m-d H:i:s');

                    $builder->insert($saveData);
                } else {
                    $this->reorderDisplayOrder(
                        table: 'web_cred_badge',
                        primaryKey: 'web_cred_badge_id',
                        currentId: $data['web_cred_badge_id'],
                        newOrder: $saveData['display_order'],
                        operation: 'update'
                    );

                    $saveData['updated_at'] = date('Y-m-d H:i:s');

                    $builder->where('web_cred_badge_id', $data['web_cred_badge_id'])
                        ->update($saveData);
                }
                break;

            default:
                return $this->respond([], 'Invalid action', 400);
        }

        return $this->respond([], 'successfully');
    }
    // services 

    public function pageApproach()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Our Services";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Services<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Our Services</span></div>';
        return view('admin/pages/services', $page);
    }

    public function getApproach()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        // Fetch all active records first to get correct total count
        $all_data = $this->db->table('web_approach')
            ->select('web_approach_id,web_title,web_content,web_content_1,web_content_2,web_content_3,web_content_4,web_content_5,web_content_6,web_content_7,
            web_image,web_image_1,web_image_2,
            display_order,created_on,is_active') // Removed duplicate web_image fields and display_order
            ->where('is_deleted', 0)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        $total_active = count($all_data);

        // If a specific ID is requested, filter the full list
        $requested_id = $this->request->getPost('web_approach_id');
        if ($requested_id && $requested_id > 0) {
            $data = array_filter($all_data, function ($row) use ($requested_id) {
                return $row['web_approach_id'] == $requested_id;
            });
            $data = array_values($data); // Re-index the array
        } else {
            $data = $all_data;
        }

        // Attach full image URLs and serial numbers
        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
            if (!empty($row['web_image'])) {
                $row['web_image'] = base_url('images/approach/' . $row['web_image']);
            }
            if (!empty($row['web_image_1'])) {
                $row['web_image_1'] = base_url('images/approach/' . $row['web_image_1']);
            }
            if (!empty($row['web_image_2'])) {
                $row['web_image_2'] = base_url('images/approach/' . $row['web_image_2']);
            }
        }
        unset($row);

        return $this->respond(data: $data, message: 'successfully', last_count: $total_active);
    }

    public function saveApproach()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fields
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_approach_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_approach',
                    primaryKey: 'web_approach_id',
                    currentId: $data['web_approach_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_approach_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = [
                    'web_approach_id',
                    'web_title',
                    'display_order'
                ];
                $allowedFields = [
                    'web_title',
                    'web_content',
                    'web_content_1',
                    'web_content_2',
                    'web_content_3',
                    'web_content_4',
                    'web_content_5',
                    'web_content_6',
                    'web_content_7',
                    'web_image',
                    'web_image_1',
                    'web_image_2',
                    'display_order'
                ];

                // Decode all content fields if present
                for ($i = 0; $i <= 7; $i++) {
                    $field = $i === 0 ? 'web_content' : 'web_content_' . $i;
                    if (!empty($data[$field])) {
                        $data[$field] = html_entity_decode(
                            $data[$field],
                            ENT_QUOTES | ENT_HTML5,
                            'UTF-8'
                        );
                    }
                }
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        // Handle file uploads
        $fileMain = $this->request->getFile('web_image');
        $file1 = $this->request->getFile('web_image_1');
        $file2 = $this->request->getFile('web_image_2');

        $uploadPath = ROOTPATH . 'images/approach/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($fileMain && $fileMain->isValid() && !$fileMain->hasMoved()) {
            $newName = $fileMain->getRandomName();
            $fileMain->move($uploadPath, $newName);
            $data['web_image'] = $newName;
        }

        if ($file1 && $file1->isValid() && !$file1->hasMoved()) {
            $newName = $file1->getRandomName();
            $file1->move($uploadPath, $newName);
            $data['web_image_1'] = $newName;
        }

        if ($file2 && $file2->isValid() && !$file2->hasMoved()) {
            $newName = $file2->getRandomName();
            $file2->move($uploadPath, $newName);
            $data['web_image_2'] = $newName;
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if (isset($updateData['web_title']) && isset($data['web_approach_id'])) {
            $updateData['web_url'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $updateData['web_title']), '-'));
        }

        $builder = $this->db->table('web_approach');

        if ($data['web_approach_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_approach',
                    primaryKey: 'web_approach_id',
                    currentId: $data['web_approach_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_approach_id', $data['web_approach_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_approach',
                primaryKey: 'web_approach_id',
                currentId: $data['web_approach_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }

    public function pageProducts()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title'] = "Products";
        $page['breadcrumb'] =
            '<div class="own-breadcrumb">
            Products<i class="fas fa-chevron-right"></i>
            <span>Products</span>
        </div>';

        return view('admin/pages/products', $page);
    }

    public function getEvent()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $builder = $this->db->table('web_event')
            ->select('
        *,
        concat("' . base_url(ADMIN_NAME) . '/product-manage/what-we-offer/", web_event_id) as image_url,
        concat("' . base_url(ADMIN_NAME) . '/product-manage/industry-appplications/", web_event_id) as video_url
    ')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_event_id')) {
            $builder->where('web_event_id', $this->request->getPost('web_event_id'));
        }

        $data = $builder
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
            $row['event_cover_url'] = $row['event_image']
                ? base_url('images/event/' . $row['event_image'])
                : '';
        }
        unset($row);

        $count = $this->db->table('web_event')
            ->where('is_deleted', 0)
            ->countAllResults();

        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: $count ?: 1
        );
    }


    public function saveEvent()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->request->getPost();

        switch ($data['for'] ?? '') {

            // ---------- DELETE ----------
            case "delete":
                $manda_arr     = ['web_event_id'];
                $allowedFields = ['is_deleted'];

                $this->reorderDisplayOrder(
                    table: 'web_event',
                    primaryKey: 'web_event_id',
                    currentId: $data['web_event_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            // ---------- STATUS ----------
            case "status":
                $manda_arr     = ['web_event_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            // ---------- ADD / EDIT ----------
            case "edit":
                $manda_arr = [
                    'web_event_id',
                    'event_title',
                    // 'event_date',
                    'event_content',
                    'display_order'
                ];

                $data['event_slug'] = slugify($data['event_title']);

                $allowedFields = [
                    'event_title',
                    'event_slug',
                    // 'event_date',
                    'event_content',
                    'display_order',
                    'is_active',
                    'event_image'
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        // ---------- MANDATORY ----------
        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        // ---------- IMAGE ----------
        $file = $this->request->getFile('event_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $path = ROOTPATH . 'images/event/';
            if (!is_dir($path)) mkdir($path, 0755, true);

            $newName = 'event_' . rand(100, 9999) . time() . '.' . $file->getExtension();
            $file->move($path, $newName);

            $data['event_image'] = $newName;
        }
        // Note: image is not mandatory anymore, so don't return error if not present

        // ---------- FILTER ----------
        $updateData = array_intersect_key($data, array_flip($allowedFields));
        $builder    = $this->db->table('web_event');

        // ---------- UPDATE ----------
        if (!empty($data['web_event_id']) && (int)$data['web_event_id'] > 0) {

            if (!in_array($data['for'], ['delete', 'status'])) {
                $this->reorderDisplayOrder(
                    table: 'web_event',
                    primaryKey: 'web_event_id',
                    currentId: $data['web_event_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');

            $builder->where('web_event_id', $data['web_event_id']);
            $builder->update($updateData);
        }
        // ---------- INSERT ----------
        else {
            $this->reorderDisplayOrder(
                table: 'web_event',
                primaryKey: 'web_event_id',
                currentId: 0,
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            $updateData['created_on'] = date('Y-m-d H:i:s');

            $builder->insert($updateData);
        }

        return $this->respond([], 'successfully');
    }


    public function pageImages($eventId)
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title']      = "What We Offer";
        $page['event']      = $this->db->table('web_event')->where('web_event_id', $eventId)->get()->getRowArray();
        $page['data']       = $this->db->table('web_content')->select('*')->where('web_content_id', 6)->get()->getRowArray();
        $page['event_id']   = $eventId;
        $page['breadcrumb'] =
            '<div class="own-breadcrumb">
            Products <i class="fas fa-chevron-right"></i>
            <span>whatweoffer </span>
        </div>';



        return view('admin/pages/whatweoffer', $page);
    }

    // ---------------- GET ----------------
    public function getEventImages()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $eventId = $this->request->getPost('web_event_id');

        $data = $this->db->table('web_event_images')
            ->where('web_event_id', $eventId)
            ->where('is_deleted', 0)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;

            // SAME STYLE AS TRIP GALLERY
            $row['image_url'] = base_url('images/event/' . $row['image_path']);
        }
        unset($row);


        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: count($data) ?: 1
        );
    }

    // ---------------- SAVE ----------------
    public function saveEventImage()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->request->getPost();

        switch ($data['for'] ?? '') {

            // DELETE
            case "delete":
                $manda_arr     = ['image_id'];
                $allowedFields = ['is_deleted'];
                break;

            // STATUS
            case "status":
                $manda_arr     = ['image_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            // ADD
            case "edit":
                $manda_arr     = ['web_event_id', 'display_order'];
                $allowedFields = [
                    'web_event_id',
                    'image_path',
                    'web_title',
                    'display_order',
                    'is_active'
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        // Mandatory
        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        // Upload image
        // Upload image
        if (($data['for'] ?? '') === 'edit') {

            $file = $this->request->getFile('image');
            if (!$file || !$file->isValid()) {
                return $this->respond([], "Image Required", 404);
            }

            // SAME STYLE AS TRIP GALLERY
            $uploadPath = ROOTPATH . 'images/event/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newName = 'event_' . time() . rand(100, 9999) . '.' . $file->getExtension();

            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }

            $data['image_path'] = $newName;
        }



        $updateData = array_intersect_key($data, array_flip($allowedFields));
        $builder    = $this->db->table('web_event_images');

        // Insert
        if (($data['for'] ?? '') === 'edit') {
            $updateData['created_by'] = session()->get('user_login_id');
            $updateData['created_on'] = date('Y-m-d H:i:s');

            $builder->insert($updateData);
        }

        // Update (delete / status)
        else {
            $builder->where('image_id', $data['image_id']);
            $builder->update($updateData);
        }

        return $this->respond([], 'successfully');
    }


    public function pageVideos($eventId)
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title']    = "Industry Applications";
        $page['event_id'] = $eventId;
        $page['breadcrumb'] =
            '<div class="own-breadcrumb">
            Product<i class="fas fa-chevron-right"></i>
            <span>Industry Applications</span>
        </div>';

        $page['event']      = $this->db->table('web_event')->where('web_event_id', $eventId)->get()->getRowArray();
        $page['data']       = $this->db->table('web_content')->select('*')->where('web_content_id', 7)->get()->getRowArray();

        return view('admin/pages/industryapplications', $page);
    }

    // ---------------- GET ----------------
    public function getEventVideos()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $eventId = $this->request->getPost('web_event_id');

        $data = $this->db->table('web_event_videos')
            ->where('web_event_id', $eventId)
            ->where('is_deleted', 0)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
            $row['image_url'] = base_url('images/event/' . $row['video_url']);
        }
        unset($row);

        return $this->respond(
            data: $data,
            message: 'successfully',
            last_count: count($data) ?: 1
        );
    }

    // ---------------- SAVE ----------------
    public function saveEventVideo()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }

        $data = $this->request->getPost();

        switch ($data['for'] ?? '') {

            // DELETE
            case "delete":
                $manda_arr     = ['video_id'];
                $allowedFields = ['is_deleted'];
                break;

            // STATUS
            case "status":
                $manda_arr     = ['video_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            // ADD / EDIT
            case "edit":
                $manda_arr     = ['web_event_id', 'video_url', 'video_title', 'display_order'];
                $allowedFields = [
                    'web_event_id',
                    'video_url',
                    'video_title',
                    'display_order',
                    'is_active'
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        // Mandatory
        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));
        $builder    = $this->db->table('web_event_videos');

        // Insert
        if (($data['for'] ?? '') === 'edit') {
            $updateData['created_by'] = session()->get('user_login_id');
            $updateData['created_on'] = date('Y-m-d H:i:s');

            $builder->insert($updateData);
        }

        // Update (delete / status)
        else {
            $builder->where('video_id', $data['video_id']);
            $builder->update($updateData);
        }

        return $this->respond([], 'successfully');
    }

    public function saveContent()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        log_message('error', 'saveContent called, for=' . ($data['for'] ?? 'NONE') . ' web_content_id=' . ($data['web_content_id'] ?? 'NONE'));
        
        // Handle checkbox status (if unchecked, it's not sent)
        if (($data['for'] ?? '') == 'save_training') {
            $data['status'] = isset($data['status']) ? 1 : 0;
        }
        $file = $this->request->getFile('web_file_1');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the upload directory
            $uploadPath = ROOTPATH . 'files/content/';

            // Ensure the directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Create a new file name
            $newName = "file_" . rand(1000, 9999) . time() . '.' . $file->getExtension();

            // Move the file
            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save file", 404);
            }

            // Save to the data array
            $data['web_file_1'] = $newName;
        }
        // If missionStatusHidden is posted, set status accordingly
        $missionStatus = $this->request->getPost('missionStatusHidden');
        if ($missionStatus !== null && $missionStatus !== '') {
            $data['status'] = $missionStatus;
        }


        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "save_training":
            case "save_research":
            case "edit":
                $manda_arr = [];
                $allowedFields = [
                    "web_content_1",
                    "web_content_2",
                    "web_content_3",
                    "web_content_4",
                    "web_content_5",
                    "web_content_6",
                    "web_content_7",
                    "web_content_8",
                    "web_content_9",
                    "web_content_10",
                    "web_content_11",
                    "web_content_12",
                    "web_content_13",
                    "web_content_14",
                    "web_content_15",
                    "web_content_16",
                    "web_content_17",
                    "web_content_18",
                    "web_content_19",
                    "web_content_20",
                    "web_content_21",
                    "web_content_22",
                    "web_content_23",
                    "web_content_24",
                    "web_content_25",
                    "web_content_26",
                    "web_content_27",
                    "web_content_28",
                    "web_content_29",
                    "web_content_30",
                    "web_content_31",
                    "web_content_32",
                    "web_content_33",
                    "web_content_34",
                    "web_content_35",
                    "web_content_36",
                    "web_content_37",
                    "web_file_1",
                    "web_image_1",
                    "web_image_2",
                    "web_image_3",
                    "web_image_4",
                    "web_image_5",
                    "status",
                ];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        // Handle web_image_1 to web_image_5 and web_file_1
        $fileFields = ['web_image_1', 'web_image_2', 'web_image_3', 'web_image_4', 'web_image_5', 'web_file_1'];
        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Use FCPATH which is the precise entry point (usually same as root in this project)
                $uploadPath = strpos($field, 'image') !== false ? FCPATH . 'images/content/' : FCPATH . 'files/content/';
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
                
                $newName = "content_" . rand(99, 9999) . time() . '.' . $file->getExtension();
                if ($file->move($uploadPath, $newName)) {
                    $data[$field] = $newName;
                } else {
                    return $this->respond([], "Unable to save " . $field, 404);
                }
            } else {
                // IMPORTANT: Unset if not uploaded to keep existing value in DB
                unset($data[$field]);
            }
        }
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        try {
            $builder = $this->db->table('web_content');
            if (($data['web_content_id'] ?? 0) > 0) {
                $updateData['updated_by'] = session()->get('user_login_id');
                $updateData['updated_on'] = date('Y-m-d H:i:s');
                $builder->where('web_content_id', $data['web_content_id']);
                if (!$builder->update($updateData)) {
                    log_message('error', 'Update failed for ID ' . $data['web_content_id']);
                    return $this->respond($data, 'Unable Update Data', 404);
                }
            } else {
                return $this->respond($data, 'Invalid ID for Update', 404);
            }
        } catch (\Exception $e) {
            log_message('error', 'SQL Error: ' . $e->getMessage());
            return $this->respond([], 'Database Error: ' . $e->getMessage(), 500);
        }

        return $this->respond(['status' => 'success'], 'successfully');
    }

    public function pageMeasured()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 10)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 10, 'status' => 1, 'web_content_2' => '[]']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 10)->get()->getRowArray();
        }

        $page['title'] = "Key Achievements";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Key Achievements</span></div>';
        return view('admin/pages/measured', $page);
    }

    //page framework
    public function pageFramework()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 13)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 13, 'status' => 1, 'web_content_2' => '[]']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 13)->get()->getRowArray();
        }

        $page['title'] = "Engineering Assurance Framework";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Engineering Assurance Framework</span></div>';
        return view('admin/pages/framework', $page);
    }
    public function pageGallery()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 11)
            ->get()->getRowArray();
        $page['title'] = "Gallery";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Gallery<i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Gallery</span></div>';
        // $page['gallerymaster'] = $this->db->table('web_content')
        //                     ->select('status')
        //                     ->where('web_content_id', )->get()->getRowArray();

        return view('admin/pages/gallery', $page);
    }



    public function getGallery()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_gallery')
            ->select('web_gallery_id,concat("' . GALLERY_IMG . '",web_image) as web_image,display_order,created_on,display_order,is_active')
            ->where('is_deleted', 0);
        if ($this->request->getPost('web_gallery_id', NULL)) {
            $data->where('web_gallery_id', $this->request->getPost('web_gallery_id', NULL));
        }
        $data = $data->orderBy('web_gallery_id')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);
        $data_count = $this->db->table('web_gallery')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function saveGallery()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();

        // Check Mandatory Fielda
        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_gallery_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_gallery',
                    primaryKey: 'web_gallery_id',
                    currentId: $data['web_gallery_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                break;

            case "status":
                $manda_arr = ['web_gallery_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = ['web_gallery_id'];
                $allowedFields = ['web_title', 'web_image', 'display_order'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }
        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the upload directory (root folder)
            $uploadPath = ROOTPATH . 'images/gallery/';

            // Ensure the upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = "gallery_" . rand(99, 9999) . time() . '.' . $file->getExtension();

            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }
            $data['web_image'] = $newName;
        } else if ($data['web_gallery_id'] == -1) {
            return $this->respond([], "Unable to save Image OR Missing Image", 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        $builder = $this->db->table('web_gallery');

        if ($data['web_gallery_id'] > 0) {
            if (!in_array(($data['for'] ?? ''), ["delete", "status"])) {
                $this->reorderDisplayOrder(
                    table: 'web_gallery',
                    primaryKey: 'web_gallery_id',
                    currentId: $data['web_gallery_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }

            $updateData['updated_by'] = session()->get('user_login_id');
            $updateData['updated_on'] = date('Y-m-d H:i:s');
            $builder->where('web_gallery_id', $data['web_gallery_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {

            $this->reorderDisplayOrder(
                table: 'web_gallery',
                primaryKey: 'web_gallery_id',
                currentId: $data['web_gallery_id'],
                newOrder: $data['display_order'],
                operation: 'insert',
            );

            $updateData['created_by'] = session()->get('user_login_id');
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }

    public function pageHomeContact()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 4)
                ->get()->getRowArray();

            $page['title'] = "Home Contact";
            $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Home Contact</span></div>';
            return view('admin/pages/homecontact', $page);
        }

        public function pageAboutQuote()
        {
            if (!session()->get('user_login_id')) {
                return redirect()->to(base_url(ADMIN_NAME));
            }

            $page['data'] = $this->db->table('web_content')
                ->select('*')
                ->where('web_content_id', 15)
                ->get()->getRowArray();

            // If no data exists, create a default record
            if (!$page['data']) {
                $default = [
                    'web_content_id' => 15,
                    'status' => 1,
                    'web_content_1' => '"Every square millimetre of a power electronics PCB is a design decision. We make sure every one of them is the right one"',
                    'web_content_2' => 'The Circuit Brilliance Philosophy',
                    'page_name' => 'About',
                    'section_name' => 'Pull Quote'
                ];
                $this->db->table('web_content')->insert($default);
                $page['data'] = $this->db->table('web_content')->where('web_content_id', 15)->get()->getRowArray();
            }

            $page['title'] = "About Pull Quote";
            $page['breadcrumb'] = '<div class="own-breadcrumb">About <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Pull Quote</span></div>';
            return view('admin/pages/aboutquote', $page);
        }

    // Portfolio
    public function pagePortfolio()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Portfolio Management";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Portfolio <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Domain Management</span></div>';

        // Fetch intro text from web_content ID 16
        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 16)
            ->get()->getRowArray();

        if (!$page['data']) {
            $default = [
                'web_content_id' => 16,
                'status' => 1,
                'web_content_1' => 'Portfolio Intro',
                'web_content_2' => 'If you are developing a power electronics product — an EV charger, a battery management system, a solar inverter, or a high-power converter — you already know that finding a design partner who genuinely understands the hardware is not straightforward.',
                'page_name' => 'Portfolio',
                'section_name' => 'Intro'
            ];
            $this->db->table('web_content')->insert($default);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 16)->get()->getRowArray();
        }

        return view('admin/pages/portfolio', $page);
    }

    public function pageShowcase()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        // Fetch the first showcase project (singleton style)
        $data = $this->db->table('web_portfolio_showcase')
            ->where('is_deleted', 0)
            ->orderBy('web_portfolio_showcase_id', 'ASC')
            ->get()->getRowArray();

        if (!$data) {
            // Create default record if none exists
            $defaultData = [
                'web_title' => '10kW Bidirectional <span>On-Board Charger</span>',
                'web_anchor_id' => 'ev',
                'web_status_text' => 'In Active Execution',
                'web_tech_line' => 'SiC MOSFET | 400V Bus | DAB + Active PFC | >96% Efficiency',
                'web_hook' => 'If your product needs bidirectional power flow, Vehicle-to-Grid capability, or high-efficiency EV charging at the 400V bus level — this design covers exactly that ground.',
                'execution_progress' => json_encode(['Schematic:Complete', 'Simulation:In Progress', 'PCB Layout:Upcoming', 'Documentation:Upcoming']),
                'key_specifications' => json_encode(['Power Rating:10kW continuous', 'Efficiency:>96% Target']),
                'design_highlights' => json_encode(['Dual Active Bridge (DAB) topology — phase shift modulation', 'Active PFC front end — unity power factor']),
                'pcb_challenges' => json_encode(['High Voltage Layout:Creepage compliance', 'Thermal Management:Copper pour array']),
                'frameworks_applied' => json_encode(['CB-SCC:Insulation coordination', 'CB-Thermal:Thermal stress analysis']),
                'design_deliverables' => json_encode(['Schematic:Full system', 'PCB Layout:High-voltage compliant']),
                'display_order' => 1,
                'is_active' => 1,
                'is_deleted' => 0
            ];
            $this->db->table('web_portfolio_showcase')->insert($defaultData);
            $data = $this->db->table('web_portfolio_showcase')->where('is_deleted', 0)->get()->getRowArray();
        }

        // Decode JSON for easy access in view (just in case)
        $data['execution_progress'] = json_decode($data['execution_progress'], true) ?? [];
        $data['key_specifications'] = json_decode($data['key_specifications'], true) ?? [];
        $data['design_highlights'] = json_decode($data['design_highlights'], true) ?? [];
        $data['pcb_challenges'] = json_decode($data['pcb_challenges'], true) ?? [];
        $data['frameworks_applied'] = json_decode($data['frameworks_applied'], true) ?? [];
        $data['design_deliverables'] = json_decode($data['design_deliverables'], true) ?? [];

        $page = [
            'title' => "Flagship Showcase",
            'breadcrumb' => '<div class="own-breadcrumb">Portfolio <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Flagship Showcase </span></div>',
            'data' => $data
        ];

        return view('admin/pages/showcase', $page);
    }

    public function getPortfolioDomain()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_portfolio_domain')
            ->select('web_portfolio_domain_id, web_title, web_content, CONCAT("' . PORTFOLIO_IMG . '", web_image) as web_image, web_url, display_order, created_on, is_active')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_portfolio_domain_id', NULL)) {
            $data->where('web_portfolio_domain_id', $this->request->getPost('web_portfolio_domain_id', NULL));
        }

        $data = $data->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        unset($row);

        $data_count = $this->db->table('web_portfolio_domain')->select('count(*) as data_count')->where('is_deleted', 0)->get()->getRowArray();

        return $this->respond(data: $data, message: 'successfully', last_count: ($data_count['data_count'] ?? 1));
    }

    public function savePortfolioDomain()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_portfolio_domain');

        switch ($data['for'] ?? '') {
            case "delete":
                $manda_arr = ['web_portfolio_domain_id'];
                $allowedFields = ['is_deleted'];
                $this->reorderDisplayOrder(
                    table: 'web_portfolio_domain',
                    primaryKey: 'web_portfolio_domain_id',
                    currentId: $data['web_portfolio_domain_id'],
                    newOrder: 0,
                    operation: 'delete',
                );
                $updateData = ['is_deleted' => 1];
                $builder->where('web_portfolio_domain_id', $data['web_portfolio_domain_id']);
                if (!$builder->update($updateData)) {
                    return $this->respond($data, 'Unable Update Data', 404);
                }
                return $this->respond([], 'successfully');
                break;

            case "status":
                $manda_arr = ['web_portfolio_domain_id', 'is_active'];
                $allowedFields = ['is_active'];
                break;

            case "edit":
                $manda_arr = ['web_portfolio_domain_id'];
                $allowedFields = ['web_title', 'web_content', 'web_image', 'web_url', 'display_order'];
                break;

            default:
                return $this->respond([], "Missing Data 'for'", 404);
        }

        $manda = checkMandatory($manda_arr, $data);
        if ($manda) {
            return $this->respond([], $manda, 404);
        }

        $file = $this->request->getFile('web_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = ROOTPATH . 'images/portfolio/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = "portfolio_" . rand(99, 9999) . time() . '.' . $file->getExtension();
            if (!$file->move($uploadPath, $newName)) {
                return $this->respond([], "Unable to save Image", 404);
            }
            $data['web_image'] = $newName;
        } else if ($data['web_portfolio_domain_id'] == -1 && !in_array(($data['for'] ?? ''), ["delete", "status"])) {
            return $this->respond([], "Image is required", 404);
        }

        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if ($data['web_portfolio_domain_id'] > 0) {
            if (($data['for'] ?? '') == "edit") {
                $this->reorderDisplayOrder(
                    table: 'web_portfolio_domain',
                    primaryKey: 'web_portfolio_domain_id',
                    currentId: $data['web_portfolio_domain_id'],
                    newOrder: $data['display_order'],
                    operation: 'update',
                );
            }
            $builder->where('web_portfolio_domain_id', $data['web_portfolio_domain_id']);
            if (!$builder->update($updateData)) {
                return $this->respond($data, 'Unable Update Data', 404);
            }
        } else {
            $this->reorderDisplayOrder(
                table: 'web_portfolio_domain',
                primaryKey: 'web_portfolio_domain_id',
                currentId: $data['web_portfolio_domain_id'],
                newOrder: (isset($data['display_order']) ? $data['display_order'] : 1),
                operation: 'insert',
            );
            if (!$builder->insert($updateData)) {
                return $this->respond($data, 'Unable to save Data', 404);
            }
        }
        return $this->respond([], 'successfully');
    }

    // Portfolio Showcase

    public function getPortfolioShowcase()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->db->table('web_portfolio_showcase')
            ->select('*')
            ->where('is_deleted', 0);

        if ($this->request->getPost('web_portfolio_showcase_id', NULL)) {
            $data->where('web_portfolio_showcase_id', $this->request->getPost('web_portfolio_showcase_id', NULL));
        }

        $data = $data->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($data as $i => &$row) {
            $row['serial_no'] = $i + 1;
            // Decode JSON fields for easier editing in JS
            $row['execution_progress'] = json_decode($row['execution_progress'], true);
            $row['key_specifications'] = json_decode($row['key_specifications'], true);
            $row['design_highlights'] = json_decode($row['design_highlights'], true);
            $row['pcb_challenges'] = json_decode($row['pcb_challenges'], true);
            $row['frameworks_applied'] = json_decode($row['frameworks_applied'], true);
            $row['design_deliverables'] = json_decode($row['design_deliverables'], true);
        }
        unset($row);

        return $this->respond(data: $data, message: 'successfully');
    }

    public function savePortfolioShowcase()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_portfolio_showcase');

        if (($data['for'] ?? '') == "delete") {
            $builder->where('web_portfolio_showcase_id', $data['web_portfolio_showcase_id']);
            $builder->update(['is_deleted' => 1]);
            return $this->respond([], 'successfully');
        }

        // Combine structured JSON fields from separate input arrays
        $structuredFields = [
            'execution_progress'   => ':',
            'key_specifications'   => ':',
            'design_highlights'    => '—',
            'pcb_challenges'       => ':',
            'frameworks_applied'   => ':',
            'design_deliverables'  => ':'
        ];

        foreach ($structuredFields as $field => $sep) {
            $icons = $this->request->getPost($field . '_icon');
            $titles = $this->request->getPost($field . '_title');
            $values = $this->request->getPost($field . '_val');
            
            $combined = [];
            if (is_array($titles)) {
                foreach ($titles as $idx => $title) {
                    $icon = !empty($icons[$idx]) ? trim($icons[$idx]) . " || " : "";
                    $val = $values[$idx] ?? '';
                    if (!empty($title)) {
                        $combined[] = $icon . trim($title) . " " . $sep . " " . trim($val);
                    }
                }
            }
            $data[$field] = json_encode($combined);
        }

        $allowedFields = ['web_title', 'web_anchor_id', 'web_status_text', 'web_tech_line', 'web_hook', 'execution_progress', 'key_specifications', 'design_highlights', 'pcb_challenges', 'frameworks_applied', 'design_deliverables', 'display_order', 'is_active'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if ($data['web_portfolio_showcase_id'] > 0) {
            $builder->where('web_portfolio_showcase_id', $data['web_portfolio_showcase_id']);
            $builder->update($updateData);
        } else {
            $builder->insert($updateData);
        }
        return $this->respond([], 'successfully');
    }

    public function pagePlannedShowcase()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(ADMIN_NAME);
        }
        $data = [
            'title' => "Planned Showcase Designs",
            'breadcrumb' => '<div class="own-breadcrumb">Portfolio <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Planned Showcase</span></div>',
            'intro' => $this->db->table('web_content')->where('web_content_id', 17)->get()->getRowArray() ?: [
                'web_content_id' => 17,
                'web_content_1' => 'Planned <span>Showcase Designs</span>',
                'web_content_2' => 'Demonstrating full domain breadth — these designs are currently in preparation to showcase our complete engineering capability across the power electronics landscape.',
                'status' => 1
            ]
        ];
        return view('admin/pages/planned_showcase', $data);
    }

    public function getPlannedShowcase()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_planned_showcase')->where('is_deleted', 0);

        // Seed default content if table is empty
        $total_active = $builder->countAllResults(false);
        if ($total_active == 0) {
            $defaults = [
                [
                    'web_tag' => 'Battery Management Systems',
                    'web_title' => '20kW High Voltage BMS — 96S Lithium Ion Pack',
                    'web_tech_line' => 'Mixed Signal | Distributed 96S Architecture | 350V Bus | 20kW',
                    'web_features' => '<ul><li>96S daisy-chain cell monitoring — LTC6813 or BQ79616</li><li>Active cell balancing — inductor-based energy transfer between cells</li><li>High voltage isolation barrier — 1000V+ rated for full pack safety</li><li>Precision current measurement — coulomb counting for SOC estimation</li><li>CAN bus communication — pack state, SOC, SOH reporting</li></ul>',
                    'web_footer' => "Planned showcase design — demonstrating Circuit Brilliance's full domain capability in this application area.",
                    'theme_class' => 'bms-theme',
                    'anchor_id' => 'bms',
                    'display_order' => 1
                ],
                [
                    'web_tag' => 'Renewable Energy Electronics',
                    'web_title' => '15kW Three-Phase Solar PV Grid-Tie Inverter',
                    'web_tech_line' => 'IGBT Modules | Three-Phase Full Bridge + LCL Filter | 700V DC Bus | 15kW',
                    'web_features' => '<ul><li>Three-phase IGBT full bridge — six-switch topology with dead-time control</li><li>LCL output filter — harmonic attenuation for grid compliance, THD <3%</li><li>DSP controller — MPPT algorithm, grid synchronisation, protection</li><li>Phase Locked Loop (PLL) — precise grid voltage synchronisation</li><li>Anti-islanding protection — active frequency drift implementation</li></ul>',
                    'web_footer' => "Planned showcase design — demonstrating Circuit Brilliance's full domain capability in this application area.",
                    'theme_class' => 'renewable-theme',
                    'anchor_id' => 'renewable',
                    'display_order' => 2
                ],
                [
                    'web_tag' => 'Power Converters & SMPS',
                    'web_title' => '7kW Three-Phase GaN Vienna Rectifier',
                    'web_tech_line' => 'GaN HEMT | Three-Level Vienna Topology | 800V DC Output | 7kW',
                    'web_features' => '<ul><li>Three-level Vienna topology — reduced voltage stress, lower THD</li><li>GaN HEMT at 300-500kHz — ultra-low gate charge, zero reverse recovery</li><li>800V DC output — next-generation EV charging and industrial drive ready</li><li>Ultra-high efficiency target >98% — GaN switching loss advantage</li><li>Ultra-low parasitic inductance layout — Kelvin connections, tight power loop</li></ul>',
                    'web_footer' => "Planned showcase design — demonstrating Circuit Brilliance's full domain capability in this application area.",
                    'theme_class' => 'power-theme',
                    'anchor_id' => 'power',
                    'display_order' => 3
                ]
            ];
            foreach($defaults as $d) { $this->db->table('web_planned_showcase')->insert($d); }
            $total_active = count($defaults);
        }

        if (!empty($data['web_planned_showcase_id'])) {
            $res = $builder->where('web_planned_showcase_id', $data['web_planned_showcase_id'])->get()->getRowArray();
            if ($res && !empty($res['web_features'])) {
                // If it's legacy JSON, convert to HTML for the editor
                $decoded = json_decode($res['web_features'], true);
                if (is_array($decoded)) {
                    $res['web_features'] = '<ul><li>' . implode('</li><li>', $decoded) . '</li></ul>';
                }
            }
            return $this->respond(data: $res, message: 'successfully');
        }

        $res = $builder->orderBy('display_order', 'ASC')->get()->getResultArray();
        foreach ($res as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        return $this->respond(data: $res, message: 'successfully', last_count: $total_active);
    }

    public function savePlannedShowcase()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_planned_showcase');

        switch ($data['for'] ?? '') {
            case "delete":
                $builder->where('web_planned_showcase_id', $data['web_planned_showcase_id']);
                $builder->update(['is_deleted' => 1]);
                return $this->respond([], 'successfully');

            case "status":
                $builder->where('web_planned_showcase_id', $data['web_planned_showcase_id']);
                $builder->update(['is_active' => $data['is_active']]);
                return $this->respond([], 'successfully');

            case "edit":
                $allowedFields = ['web_tag', 'web_title', 'web_tech_line', 'web_features', 'web_footer', 'theme_class', 'anchor_id', 'display_order', 'is_active'];
                $updateData = array_intersect_key($data, array_flip($allowedFields));

                if ($data['web_planned_showcase_id'] > 0) {
                    $builder->where('web_planned_showcase_id', $data['web_planned_showcase_id']);
                    $builder->update($updateData);
                } else {
                    $builder->insert($updateData);
                }
                return $this->respond([], 'successfully');
        }

        return $this->respond([], "Missing 'for' action", 404);
    }

    public function pagePERIContent()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 18)
            ->get()->getRowArray();

        // Seed if missing
        if (!$page['data']) {
            $defaultData = [
                'web_content_id' => 18,
                'page_name' => 'PERI',
                'web_tag' => 'Introduction',
                'web_content_1' => 'Power Electronics Research Institute',
                'web_content_2' => 'PERI exists at the intersection of rigorous engineering practice and structured knowledge development. Where Circuit Brilliance applies domain expertise to client design engagements, PERI directs that same expertise in two directions — toward developing engineers who are genuinely ready for industry, and toward advancing power electronics knowledge through research, publication, and academic collaboration.',
                'status' => 1
            ];
            $this->db->table('web_content')->insert($defaultData);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 18)->get()->getRowArray();
        }

        $page['title'] = "PERI Content";
        $page['breadcrumb'] = '<div class="own-breadcrumb">PERI <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Introduction</span></div>';
        $page['routeName'] = "peri-content-manage";
        return view('admin/pages/peri_content', $page);
    }

    public function pagePERITraining()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 19)
            ->get()->getRowArray();

        // Seed if missing
        if (!$page['data']) {
            $defaultData = [
                'web_content_id' => 19,
                'web_content_1'  => 'For Students & Graduates',
                'web_content_2'  => 'The Recruiter Moment',
                'web_content_3'  => 'A technical recruiter sits across 40 final-year students. Interview after interview — textbook answers, nervous faces, same pattern. Then one student walks in.',
                'web_content_4'  => 'Asked about gate drive design for a SiC MOSFET, he does not recite a definition. He talks about turn-on resistance, Miller plateau, negative bias requirements, layout parasitics — the way a working engineer speaks after two years on the job.',
                'web_content_5'  => 'The recruiter stops writing. Looks up. "Where did you learn this?"',
                'web_content_6'  => 'Certificate Programme in Power Electronics Product Development',
                'web_content_7'  => 'A 3-month structured programme — 30% concepts, 70% real design work. Students design a real power electronics product from blank schematic to fabrication-ready output, using the same tools that engineers use in real companies.',
                'web_content_8'  => json_encode([
                    ['num' => '40', 'text' => 'Students interviewed, same generic result'],
                    ['num' => '1', 'text' => 'Student who stood apart with real design instinct'],
                    ['badge' => 'DAY 1', 'text' => 'Ready to contribute, what recruiters actually want']
                ]),
                'web_content_9'  => json_encode([
                    ['icon' => 'fa-clock', 'name' => 'Duration', 'text' => '3 months'],
                    ['icon' => 'fa-laptop', 'name' => 'Delivery', 'text' => 'Online delivery'],
                    ['icon' => 'fa-calendar-alt', 'name' => 'Schedule', 'text' => 'Weekend + weekday sessions'],
                    ['icon' => 'fa-medal', 'name' => 'Outcome', 'text' => 'Certificate + Digital Badge + Project Portfolio']
                ]),
                'web_image_1' => 'peri-interview.webp',
                'status'      => 1,
                'web_content_10' => json_encode([
                    'Engineering Product Development Life Cycle',
                    'Power Electronics Concepts & Circuit Design',
                    'Schematic Design & SPICE Simulation',
                    'PCB Layout — Placement, Routing & DRC',
                    'Signal Integrity & Power Delivery Network Analysis',
                    'Documentation, BOM & Design for Manufacturing',
                    'Final Project — Design, Review & Presentation'
                ]),
                'web_content_11' => json_encode([
                    ['name' => 'Altium Designer', 'desc' => 'Professional EDA'],
                    ['name' => 'LTSpice / PSpice', 'desc' => 'Simulation'],
                    ['name' => 'HyperLynx', 'desc' => 'Signal & Power Integrity'],
                    ['name' => 'Ansys Q3D', 'desc' => 'Parasitic Extraction'],
                    ['name' => 'Gerber / ODB++', 'desc' => 'Fabrication Output']
                ]),
                'web_content_12' => 'AI teaches you what to say. PERI teaches you what to know',
                'web_content_13' => json_encode([
                    'Explain every formula in your textbook',
                    'Define SiC, GaN, PFC, DAB on demand',
                    'Generate circuit descriptions instantly',
                    'Produce a perfect-looking resume'
                ]),
                'web_content_14' => json_encode([
                    'Show you what a real PCB failure looks like',
                    'Build the instinct that comes from experience',
                    'Explain why a layout burns real hardware',
                    'Make a recruiter stop and lean forward'
                ]),
                'web_content_15' => 'Course fees and enrolment details available on request.'
            ];
            $this->db->table('web_content')->insert($defaultData);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 19)->get()->getRowArray();
        }

        $page['title'] = "Students & Graduates";
        $page['breadcrumb'] = '<div class="own-breadcrumb">PERI <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Students & Graduates</span></div>';
        $page['routeName'] = "peri-training-manage";
        return view('admin/pages/peri_training', $page);
    }

    public function pagePERIAnchors()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title'] = "PERI Anchor Cards";
        $page['breadcrumb'] = '<div class="own-breadcrumb">PERI <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Anchor Cards</span></div>';
        return view('admin/pages/peri_anchors', $page);
    }

    public function getPERIAnchors()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_peri_anchors');

        // Seed defaults if empty
        $total_active = $builder->where('is_deleted', 0)->countAllResults(false);
        if ($total_active == 0) {
            $defaults = [
                ['title' => 'For Students & Graduates', 'description' => 'Build real engineering skills that make recruiters stop mid-interview.', 'anchor_link' => '#training', 'anchor_text' => 'Explore PERI Training ↓', 'display_order' => 1],
                ['title' => 'For Institutions & Universities', 'description' => 'Partner with PERI to develop your students and strengthen placement outcomes.', 'anchor_link' => '#institutions', 'anchor_text' => 'Explore Collaboration ↓', 'display_order' => 2],
                ['title' => 'For Industry & Research', 'description' => 'Collaborate on research, publications, and framework validation.', 'anchor_link' => '#research', 'anchor_text' => 'Explore Research ↓', 'display_order' => 3]
            ];
            foreach ($defaults as $d) { $builder->insert($d); }
            $total_active = count($defaults);
        }

        if (!empty($data['web_peri_anchor_id'])) {
            $res = $builder->where('web_peri_anchor_id', $data['web_peri_anchor_id'])->get()->getRowArray();
            return $this->respond(data: $res, message: 'successfully');
        }

        $res = $builder->where('is_deleted', 0)->orderBy('display_order', 'ASC')->get()->getResultArray();
        foreach ($res as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        return $this->respond(data: $res, message: 'successfully', last_count: $total_active);
    }

    public function savePERIAnchors()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_peri_anchors');

        switch ($data['for']) {
            case "delete":
                $builder->where('web_peri_anchor_id', $data['web_peri_anchor_id']);
                $builder->update(['is_deleted' => 1]);
                return $this->respond([], 'successfully');

            case "status":
                $builder->where('web_peri_anchor_id', $data['web_peri_anchor_id']);
                $builder->update(['is_active' => $data['is_active']]);
                return $this->respond([], 'successfully');

            case "edit":
                $allowedFields = ['title', 'description', 'anchor_link', 'anchor_text', 'display_order', 'is_active'];
                $updateData = array_intersect_key($data, array_flip($allowedFields));

                if ($data['web_peri_anchor_id'] > 0) {
                    $builder->where('web_peri_anchor_id', $data['web_peri_anchor_id']);
                    $builder->update($updateData);
                } else {
                    $builder->insert($updateData);
                }
                return $this->respond([], 'successfully');
        }
        return $this->respond([], "Missing 'for' action", 404);
    }

    public function pagePERIResearch()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')->where('web_content_id', 20)->get()->getRowArray();

        // Self-heal/Seed if Row 20 missing
        if (!$page['data']) {
            $defaultData = [
                'web_content_id' => 20,
                'for'            => 'peri_research',
                'web_content_1'  => 'For Institutions , Universities <span>and Industry Partners</span>',
                'web_content_2'  => 'PERI is the structured research and academic collaboration arm of Circuit Brilliance. It provides the environment through which Circuit Brilliance\'s proprietary analytical frameworks are academically validated, where technical whitepapers and research notes are developed and published, and where partnerships with university power electronics departments are established and grown.',
                'web_image_1'    => 'PERI_p1.webp',
                'web_content_3'  => json_encode([
                    ['num' => '01', 'name' => 'Research & Framework Validation', 'text' => 'Academically validates Circuit Brilliance\'s six proprietary frameworks across real power electronics design scenarios.'],
                    ['num' => '02', 'name' => 'Technical Publications', 'text' => 'Publishes whitepapers and research notes grounded in 18 years of real engineering experience — written for practising engineers.'],
                    ['num' => '03', 'name' => 'University Collaboration', 'text' => 'Research partnerships with power electronics departments — joint research, knowledge exchange, and co-publication.'],
                    ['num' => '04', 'name' => 'Engineer Development', 'text' => 'Structured training programmes developing engineers from graduate fundamentals to advanced SiC/GaN, magnetics, and EMI.']
                ]),
                'web_content_4'  => 'Interested in collaborating with PERI? We welcome conversations with university research groups, industry partners, and institutions at any stage of interest.',
                'web_content_5'  => 'Conventional Engineering Education',
                'web_content_6'  => 'The PERI Approach',
                'web_content_7'  => json_encode([
                    "Chapter-by-chapter theory — without design context",
                    "Concepts delivered before the design demands them",
                    "Simulation only — no real design workflow",
                    "No exposure to professional EDA tools",
                    "Assessment by examination — not by doing",
                    "Resume skills that are never actually practised"
                ]),
                'web_content_8'  => json_encode([
                    "Built around a real power electronics product development journey",
                    "Every concept introduced when the design actually needs it",
                    "Real design workflow — tools, trade-offs, and fabrication outputs",
                    "Altium Designer, LTSpice, HyperLynx, Ansys Q3D — industry standard",
                    "Assessment by project delivery and demonstration",
                    "Every skill listed is a skill practised. Every project is real."
                ]),
                'web_content_9'  => '"A PERI student does not walk into a placement interview as a fresher. He walks in as an engineer who has not yet received his first payslip."',
                'status'         => 1
            ];
            $this->db->table('web_content')->insert($defaultData);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 20)->get()->getRowArray();
        }

        $page['title'] = "Institutions & Research";
        $page['breadcrumb'] = '<div class="own-breadcrumb">PERI <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Institutions & Research</span></div>';
        $page['routeName'] = "peri-research-manage";
        return view('admin/pages/peri_research', $page);
    }
    public function pagePERICTAs()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title'] = "PERI Action Cards";
        $page['breadcrumb'] = '<div class="own-breadcrumb">PERI <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Action Cards</span></div>';
        return view('admin/pages/peri_ctas', $page);
    }

    public function getPERICTAs()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_peri_ctas');

        $total_active = $builder->where('is_deleted', 0)->countAllResults(false);

        if (!empty($data['web_peri_cta_id'])) {
            $res = $builder->where('web_peri_cta_id', $data['web_peri_cta_id'])->get()->getRowArray();
            return $this->respond(data: $res, message: 'successfully');
        }

        $res = $builder->where('is_deleted', 0)->orderBy('display_order', 'ASC')->get()->getResultArray();
        foreach ($res as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        return $this->respond(data: $res, message: 'successfully', last_count: $total_active);
    }

    public function savePERICTAs()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_peri_ctas');

        switch ($data['for']) {
            case "delete":
                $builder->where('web_peri_cta_id', $data['web_peri_cta_id']);
                $builder->update(['is_deleted' => 1]);
                return $this->respond([], 'successfully');

            case "status":
                $builder->where('web_peri_cta_id', $data['web_peri_cta_id']);
                $builder->update(['is_active' => $data['is_active']]);
                return $this->respond([], 'successfully');

            case "edit":
                $allowedFields = ['title', 'description', 'icon', 'link', 'link_text', 'theme_color', 'display_order', 'is_active'];
                $updateData = array_intersect_key($data, array_flip($allowedFields));

                if ($data['web_peri_cta_id'] > 0) {
                    $builder->where('web_peri_cta_id', $data['web_peri_cta_id']);
                    $builder->update($updateData);
                } else {
                    $builder->insert($updateData);
                }
                return $this->respond([], 'successfully');
        }
        return $this->respond([], "Missing 'for' action", 404);
    }

    public function pageDomainServices()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['title'] = "Domain Services Management";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Services <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Domain Services</span></div>';
        
        // Hero Section Content
        $page['hero'] = $this->db->table('web_content')->where('for', 'domain_service_hero')->get()->getRowArray();
        
        return view('admin/pages/domain_services', $page);
    }

    public function getDomainServices()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_service_details');

        if (!empty($data['web_service_details_id'])) {
            $res = $builder->where('web_service_details_id', $data['web_service_details_id'])->get()->getRowArray();
            if ($res) {
                $res['what_we_design'] = json_decode($res['what_we_design'], true) ?: [];
                $res['deliverables'] = json_decode($res['deliverables'], true) ?: [];
                $res['technologies'] = json_decode($res['technologies'], true) ?: [];
            }
            return $this->respond(data: $res, message: 'successfully');
        }

        $res = $builder->where('is_deleted', 0)->orderBy('display_order', 'ASC')->get()->getResultArray();
        foreach ($res as $i => &$row) {
            $row['serial_no'] = $i + 1;
        }
        return $this->respond(data: $res, message: 'successfully');
    }

    public function saveDomainServices()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_service_details');

        switch ($data['for']) {
            case "delete":
                $builder->where('web_service_details_id', $data['web_service_details_id']);
                $builder->update(['is_deleted' => 1]);
                return $this->respond([], 'successfully');

            case "status":
                $builder->where('web_service_details_id', $data['web_service_details_id']);
                $builder->update(['is_active' => $data['is_active']]);
                return $this->respond([], 'successfully');

            case "edit":
                // Handle JSON fields from arrays
                $data['what_we_design'] = json_encode(array_filter($this->request->getPost('what_we_design') ?: []));
                $data['deliverables'] = json_encode(array_filter($this->request->getPost('deliverables') ?: []));
                $data['technologies'] = json_encode(array_filter($this->request->getPost('technologies') ?: []));

                $allowedFields = ['section_anchor', 'title_eb', 'heading', 'description', 'image', 'theme_color', 'what_we_design', 'deliverables', 'technologies', 'display_order', 'is_active'];
                $updateData = array_intersect_key($data, array_flip($allowedFields));

                // Image Upload
                $file = $this->request->getFile('image');
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $uploadPath = ROOTPATH . 'assets/img/'; // Using assets/img as per existing structure
                    $newName = "svc_" . rand(99, 9999) . time() . '.' . $file->getExtension();
                    if ($file->move($uploadPath, $newName)) {
                        $updateData['image'] = $newName;
                    }
                }

                if ($data['web_service_details_id'] > 0) {
                    $updateData['updated_on'] = date('Y-m-d H:i:s');
                    $builder->where('web_service_details_id', $data['web_service_details_id']);
                    $builder->update($updateData);
                } else {
                    $updateData['created_on'] = date('Y-m-d H:i:s');
                    $builder->insert($updateData);
                }
                return $this->respond([], 'successfully');
        }
        return $this->respond([], "Missing 'for' action", 404);
    }

    public function saveDomainHero()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $builder = $this->db->table('web_content');

        $updateData = [
            'web_content_1' => $data['title'],
            'web_content_2' => $data['description'],
            'status' => $data['status'] ?? 1,
            'updated_on' => date('Y-m-d H:i:s')
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = ROOTPATH . 'assets/img/';
            $newName = "hero_" . rand(99, 9999) . time() . '.' . $file->getExtension();
            if ($file->move($uploadPath, $newName)) {
                $updateData['web_image_1'] = $newName;
            }
        }

        $builder->where('for', 'domain_service_hero');
        if ($builder->update($updateData)) {
            return $this->respond([], 'successfully');
        } else {
            // If update fails (e.g. row doesn't exist), try insert
            $updateData['for'] = 'domain_service_hero';
            $builder->insert($updateData);
            return $this->respond([], 'successfully');
        }
    }
    public function pageFrameworks()
    {
        $db = \Config\Database::connect();
        
        $contents = $db->table('web_framework_content')->get()->getResultArray();
        $frameworks_content = [];
        foreach($contents as $c) {
            $frameworks_content[$c['framework_slug']][$c['section_key']] = $c['content_value'];
        }

        $data = [
            'title' => 'Engineering Frameworks',
            'hero'  => $db->table('web_content')->where('for', 'framework_hero')->get()->getRowArray(),
            'frameworks_content' => $frameworks_content,
            'routeName' => 'frameworks-manage'
        ];
        return view('admin/pages/frameworks', $data);
    }

    public function saveFrameworkContent()
    {
        $db = \Config\Database::connect();
        $postData = $this->request->getPost();
        
        $frameworkSlug = $postData['framework_slug'] ?? null;
        if(!$frameworkSlug) return $this->response->setJSON(['success' => false, 'message' => 'Missing slug']);
        
        unset($postData['framework_slug']);
        
        foreach($postData as $key => $value) {
            $existing = $db->table('web_framework_content')
                           ->where('framework_slug', $frameworkSlug)
                           ->where('section_key', $key)
                           ->get()->getRow();
            if($existing) {
                $db->table('web_framework_content')
                   ->where('id', $existing->id)
                   ->update(['content_value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
            } else {
                $db->table('web_framework_content')
                   ->insert([
                       'framework_slug' => $frameworkSlug,
                       'section_key' => $key,
                       'content_value' => $value,
                       'created_at' => date('Y-m-d H:i:s'),
                       'updated_at' => date('Y-m-d H:i:s')
                   ]);
            }
        }
        
        return $this->response->setJSON(['success' => true, 'message' => 'Saved successfully']);
    }

    public function saveFrameworkHero()
    {
        $db = \Config\Database::connect();
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');

        $data = [
            'web_content_1' => $title,
            'web_content_2' => $description,
            'updated_on' => date('Y-m-d H:i:s')
        ];

        $check = $db->table('web_content')->where('for', 'framework_hero')->get()->getRowArray();
        if ($check) {
            $db->table('web_content')->where('for', 'framework_hero')->update($data);
        } else {
            $data['for'] = 'framework_hero';
            $db->table('web_content')->insert($data);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Hero section saved']);
    }

    public function saveFramework()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('web_framework_id');
        
        $data = [
            'anchor_id' => $this->request->getPost('anchor_id'),
            'title_eb' => $this->request->getPost('title_eb'),
            'heading' => $this->request->getPost('heading'),
            'quote' => $this->request->getPost('quote'),
            'description' => $this->request->getPost('description'),
            'theme_color' => $this->request->getPost('theme_color'),
            'chart_label' => $this->request->getPost('chart_label'),
            'chart_data' => $this->request->getPost('chart_data'),
            'counters' => $this->request->getPost('counters'),
            'deliverables' => $this->request->getPost('deliverables'),
            'extra_content' => $this->request->getPost('extra_content'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($id > 0) {
            $db->table('web_framework_details')->where('web_framework_id', $id)->update($data);
            $message = 'Pillar updated successfully';
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $db->table('web_framework_details')->insert($data);
            $message = 'Pillar added successfully';
        }

        return $this->response->setJSON(['status' => 'success', 'message' => $message]);
    }

    public function deleteFramework()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('web_framework_id');
        $db->table('web_framework_details')->where('web_framework_id', $id)->delete();
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pillar deleted successfully']);
    }

    public function seedFrameworks()
    {
        $db = \Config\Database::connect();
        
        $db->table('web_content')->where('for', 'framework_hero')->delete();
        $db->table('web_content')->insert([
            'for' => 'framework_hero',
            'web_content_1' => 'Six Proprietary Analytical Pillars',
            'web_content_2' => 'Our design process is built on six independent analytical pillars — ensuring that every engineering decision is validated against international standards, physical phenomena, and failure mode libraries.',
            'web_image_1' => 'hero_tech_banner_clean_v1_1775825435158.png',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $db->table('web_framework_details')->truncate();

        $frameworks = [
            [
                'anchor_id' => 'scc',
                'title_eb' => 'CB-SCC: Standards Compliance Checklist',
                'heading' => 'Standards <span>Compliance Checklist</span>',
                'quote' => '"Find the compliance gap at the design stage — not at the certification stage."',
                'description' => 'A structured audit framework evaluating PCB design and documentation against applicable international standards covering PCB design, insulation coordination, reliability prediction, and product safety. Clause-level traceability. Cross-standard conflict identification.',
                'theme_color' => '#008d61',
                'chart_label' => 'CB-SCC | Compliance Coverage Evaluation',
                'chart_data' => json_encode([
                    'labels' => ['PCB Design', 'Insulation', 'Reliability', 'Safety', 'Conflict Check', 'Traceability'],
                    'datasets' => [
                        ['label' => 'Ad-Hoc', 'data' => [40, 30, 20, 35, 10, 25]],
                        ['label' => 'CB-SCC', 'data' => [95, 95, 90, 92, 88, 97]]
                    ]
                ]),
                'counters' => json_encode([
                    ['target' => 96, 'suffix' => '%', 'label' => 'Compliance Depth', 'class' => 'c-scc'],
                    ['target' => 100, 'suffix' => '%', 'label' => 'Traceability', 'class' => 'h4 fw-bold']
                ]),
                'deliverables' => json_encode([
                    'Compliance status across applicable international standards',
                    'Clause-level findings traceable to specific standard and section',
                    'Cross-standard conflict identification'
                ]),
                'display_order' => 1
            ],
            [
                'anchor_id' => 'thermal',
                'title_eb' => 'CB-Thermal: Thermal Analysis Framework',
                'heading' => 'Thermal <span>Analysis Framework</span>',
                'quote' => '"Every degree above junction limit is a reliability debt — CB-Thermal finds it before it compounds."',
                'description' => 'Complete junction-to-ambient thermal chain analysis. Maps every Rth node per heat-generating component. Identifies hotspot risks, validates thermal via arrays, estimates worst-case junction temperatures.',
                'theme_color' => '#FF4DB8',
                'chart_label' => 'CB-Thermal | Junction-to-Ambient Chain °C',
                'chart_data' => json_encode([
                    'labels' => ['Ambient', 'Heatsink', 'TIM', 'Case', 'Junction'],
                    'datasets' => [
                        ['label' => 'Temp (°C)', 'data' => [45, 68, 79, 98, 142]]
                    ]
                ]),
                'counters' => json_encode([
                    ['target' => 142, 'suffix' => '°C', 'label' => 'Estimated Tj Max', 'class' => 'c-thermal'],
                    ['target' => 5, 'suffix' => '', 'label' => 'Thermal Nodes', 'class' => 'h4 fw-bold']
                ]),
                'deliverables' => json_encode([
                    ['title' => 'Rth Chain Mapping', 'desc' => 'Full junction-to-ambient Rth chain per heat-generating component'],
                    ['title' => 'Risk Assessment', 'desc' => 'Hotspot risk assessment — placement, copper spreading, power density'],
                    ['title' => 'Simulation Data', 'desc' => 'Worst-case junction temperature estimates at full load and maximum ambient']
                ]),
                'display_order' => 2
            ],
            [
                'anchor_id' => 'lbf',
                'title_eb' => 'CB-LBF: Loss Budget Framework',
                'heading' => 'Loss <span>Budget Framework</span>',
                'quote' => '"Fight for the Fractions" — efficiency is won or lost in the decimals.',
                'description' => 'Full-spectrum loss analysis framework. Every watt of loss has an address — CB-LBF locates each one across conduction, switching, magnetics, gate drive, and PCB parasitics. Scanner Principle: no verdicts, pure visibility.',
                'theme_color' => '#FF6B35',
                'chart_label' => 'CB-LBF | Loss Mechanism Breakdown %',
                'chart_data' => json_encode([
                    'labels' => ['Conduction', 'Switching', 'Core', 'Winding', 'Gate', 'Dead-Time', 'Parasitic'],
                    'datasets' => [
                        ['label' => 'Loss Contribution (%)', 'data' => [28.4, 22.1, 17.6, 13.8, 8.2, 6.1, 3.8]]
                    ]
                ]),
                'deliverables' => json_encode([
                    'Full-spectrum loss scan — every mechanism identified and quantified',
                    'Itemised loss register per mechanism and per operating point',
                    'Scanner Principle report — verdict-free, engineered for the team to act on'
                ]),
                'display_order' => 3
            ],
            [
                'anchor_id' => 'gaf',
                'title_eb' => 'CB-GAF: Gap Analysis Framework',
                'heading' => 'Gap <span>Analysis Framework</span>',
                'quote' => '"Circuit Brilliance operates where the standards stop — and the engineering begins."',
                'description' => 'Maps the boundary between auditable standards and 18 years of engineering judgement. Identifies physical phenomena that standards often miss across all four domains.',
                'theme_color' => '#A855F7',
                'chart_label' => 'CB-GAF | Gap Type Intensity per Domain',
                'chart_data' => json_encode([
                    'labels' => ['EV', 'BMS', 'Renewable', 'Power'],
                    'datasets' => [
                        ['label' => 'Type 1', 'data' => [12, 8, 10, 14]],
                        ['label' => 'Type 2', 'data' => [14, 12, 9, 8]],
                        ['label' => 'Type 3', 'data' => [8, 10, 12, 6]]
                    ]
                ]),
                'extra_content' => json_encode([
                    'type' => 'gap_types',
                    'data' => [
                        ['type' => 'GAP TYPE 1 — Invisible Phenomena', 'desc' => 'Physical phenomena that cause real failures and are acknowledged by no standard.'],
                        ['type' => 'GAP TYPE 2 — Judgement Gaps', 'desc' => 'Standard thresholds that cannot determine safety for a specific design\'s operating conditions.'],
                        ['type' => 'GAP TYPE 3 — Interaction Gaps', 'desc' => 'Failure modes from combinations of individually compliant elements.']
                    ]
                ]),
                'display_order' => 4
            ],
            [
                'anchor_id' => 'fmea',
                'title_eb' => 'CB-FMEA: Failure Mode & Effects Analysis',
                'heading' => 'Failure Mode & <span>Effects Analysis</span>',
                'quote' => '"Generic FMEA finds generic failures. CB-FMEA finds the ones that take down your board."',
                'description' => 'Two-tier, power-electronics-specific FMEA framework. Tier 1 maps failure propagation paths across the full system. Tier 2 scores failure mode severity at component level.',
                'theme_color' => '#0077B6',
                'chart_label' => 'CB-FMEA | Risk Distribution RPN',
                'chart_data' => json_encode([
                    'labels' => ['Critical', 'High', 'Medium', 'Mitigated'],
                    'datasets' => [
                        ['label' => 'Risk', 'data' => [8, 14, 21, 11]]
                    ]
                ]),
                'deliverables' => json_encode([
                    'System-level failure propagation map (Tier 1)',
                    'Component-level risk register (Tier 2) — SOD scores and RPN rankings',
                    'Structured report for design reviews and audits'
                ]),
                'extra_content' => json_encode([
                    'type' => 'tiers',
                    'data' => [
                        ['tier' => 'TIER 1 — System-Level Failure Mapping', 'scope' => 'Maps failure propagation paths across topology, gate driver chain, isolation barriers, and protection logic.'],
                        ['tier' => 'TIER 2 — Component-Level Analysis', 'scope' => 'SOD scores and RPN rankings calibrated to switching frequency, voltage class, and thermal profile.']
                    ]
                ]),
                'display_order' => 5
            ],
            [
                'anchor_id' => 'craft',
                'title_eb' => 'CB-CRAFT: Design Execution Framework',
                'heading' => 'Comprehensive Review and <span>Assured Fabrication Technology</span>',
                'quote' => '"CB-CRAFT reflects the design as implemented. It does not pass or fail. It observes, records, and verifies."',
                'description' => 'CB-CRAFT is Circuit Brilliance\'s PCB Design Execution Framework — the stage where every upstream framework output (SCC, LBF, Thermal, GAF, FMEA) converges into a verified, manufacturable PCB deliverable.',
                'theme_color' => '#1B5E82',
                'deliverables' => json_encode([
                    ['title' => 'CB-CRAFT Review Record', 'desc' => 'every checkpoint reviewed across all nine stages, observations recorded'],
                    ['title' => 'Framework Summary Report', 'desc' => 'one-page confirmation the design underwent CB-CRAFT review'],
                    ['title' => 'Design Rationale Note', 'desc' => 'switching loop area, isolation strategy, copper weight rationale'],
                    ['title' => 'Gerber Package', 'desc' => 'fabrication-ready files verified under CB-CRAFT before release']
                ]),
                'extra_content' => json_encode([
                    'type' => 'craft_complex',
                    'stages' => [
                        ['id' => '01', 'title' => 'Layout Intelligence Extraction', 'desc' => 'Reading the schematic for layout-critical information.'],
                        ['id' => '02', 'title' => 'Layout-Specific Client Inputs', 'desc' => 'Mechanical constraints, surface finish, layer budget.'],
                        ['id' => '03', 'title' => 'Layer Stack & Design Rules', 'desc' => 'Isolation, copper weight, and design rule implementation.'],
                        ['id' => '04', 'title' => 'Component Placement', 'desc' => 'Switching loops, gate drive proximity, thermal zone compliance.'],
                        ['id' => '05', 'title' => 'Routing', 'desc' => 'Power trace sizing, Kelvin sense routing, ground zone discipline.'],
                        ['id' => '06', 'title' => 'DFM + DFA', 'desc' => 'Design for Manufacturability and Assembly verification.'],
                        ['id' => '07', 'title' => 'DFT — Design for Testability', 'desc' => 'Test points, programming access, serviceability.'],
                        ['id' => '08', 'title' => 'DFS — Design for Safety', 'desc' => 'Creepage, clearance, isolation, safety marking.'],
                        ['id' => '09', 'title' => 'Release for Prototyping', 'desc' => 'Final package generation, ODB++, and manufacturing release.']
                    ],
                    'ecosystem_note' => 'CB-CRAFT does not determine requirements — it verifies their implementation. CB-SCC determines compliance requirements — CB-CRAFT checks the PCB delivers them. CB-LBF determines current values — CB-CRAFT sizes the copper to carry them. CB-Thermal determines thermal zones — CB-CRAFT verifies placement honours them.',
                    'domain_focus' => [
                        ['domain' => 'EV Powertrain', 'focus' => 'HV isolation, SiC/GaN switching loops, HVIL, automotive DFx'],
                        ['domain' => 'Battery Management', 'focus' => 'AFE sense matching, stack voltage isolation, Kelvin routing'],
                        ['domain' => 'Renewable Energy', 'focus' => 'Common-mode loops, GFDI, outdoor creepage, LCL filter'],
                        ['domain' => 'Power Converters & SMPS', 'focus' => 'Primary switching loop, Y-cap placement, isolation slot']
                    ]
                ]),
                'display_order' => 6
            ]
        ];

        foreach ($frameworks as $f) {
            $f['created_at'] = date('Y-m-d H:i:s');
            $db->table('web_framework_details')->insert($f);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Seeding successful']);
    }
    // Call to Action
    public function pageCallToAction()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }
        $page['title'] = "Call to Action";
        $page['breadcrumb'] = '<div class="own-breadcrumb">General <i style="font-size:14px" class="fas fa-chevron-right"></i> <span>Call to Action</span></div>';
        
        // Predefined tags we want to manage
        $tags = ['home', 'about', 'domain-services', 'proprietary-frameworks', 'blog', 'blog-details', 'contact'];
        
        // Ensure they exist or fetch them
        $ctaData = [];
        foreach ($tags as $tag) {
            $row = $this->db->table('web_call_to_action')->where('tag', $tag)->get()->getRowArray();
            if (!$row) {
                // Optional: Insert default if not exists
                $insert = [
                    'tag' => $tag,
                    'title' => ucfirst(str_replace('-', ' ', $tag)) . ' CTA',
                    'content' => '',
                    'status' => 1,
                    'created_on' => date('Y-m-d H:i:s')
                ];
                $this->db->table('web_call_to_action')->insert($insert);
                $row = $insert;
            }
            $ctaData[] = $row;
        }
        
        $page['ctaData'] = $ctaData;
        return view('admin/pages/cta', $page);
    }

    public function getCallToActions()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $tags = ['home', 'about', 'domain-services', 'proprietary-frameworks', 'blog', 'blog-details', 'contact'];
        $res = [];
        foreach ($tags as $i => $tag) {
            $row = $this->db->table('web_call_to_action')->where('tag', $tag)->get()->getRowArray();
            if ($row) {
                $res[] = [
                    'serial_no' => $i + 1,
                    'tag' => strtoupper(str_replace('-', ' ', $row['tag'])),
                    'title' => $row['title'],
                    'content' => mb_strimwidth(strip_tags($row['content']), 0, 80, '...'),
                    'status' => $row['status'],
                    'raw_tag' => $row['tag'],
                    'raw_content' => $row['content']
                ];
            }
        }
        return $this->response->setJSON(['code' => 200, 'data' => $res]);
    }

    public function getCallToAction()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $tag = $this->request->getPost('tag');
        $data = $this->db->table('web_call_to_action')
            ->where('tag', $tag)
            ->get()->getResultArray();

        return $this->respond($data, 'successfully');
    }

    public function saveCallToAction()
    {
        if (!session()->get('user_login_id')) {
            return $this->respond([], 'Session Expired', 404);
        }
        $data = $this->request->getPost();
        $tag = $data['tag'];

        $saveData = [
            'tag' => $tag,
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'] ?? 1,
            'updated_on' => date('Y-m-d H:i:s')
        ];

        $existing = $this->db->table('web_call_to_action')->where('tag', $tag)->get()->getRowArray();

        if ($existing) {
            $this->db->table('web_call_to_action')->where('tag', $tag)->update($saveData);
        } else {
            $saveData['created_on'] = date('Y-m-d H:i:s');
            $this->db->table('web_call_to_action')->insert($saveData);
        }

        return $this->respond([], 'successfully');
    }

    // Home Blog Content
    public function pageHomeBlogContent()
    {
        if (!session()->get('user_login_id')) {
            return redirect()->to(base_url(ADMIN_NAME));
        }

        $page['data'] = $this->db->table('web_content')
            ->select('*, concat("' . CONTENT_IMG . '", web_image_1) as image, concat("' . CONTENT_IMG . '", web_image_2) as image2')
            ->where('web_content_id', 23)
            ->get()->getRowArray();

        // If no data exists, create a default record
        if (!$page['data']) {
            $this->db->table('web_content')->insert(['web_content_id' => 23, 'status' => 1, 'web_content_1' => 'From the Circuit Brilliance Blog']);
            $page['data'] = $this->db->table('web_content')->where('web_content_id', 23)->get()->getRowArray();
        }

        $page['title'] = "Blog Content";
        $page['breadcrumb'] = '<div class="own-breadcrumb">Home <i style="font-size:14px" class="fas fa-chevron-right"></i> <span> Blog Content </span></div>';
        return view('admin/pages/homeblogcontent', $page);
    }

}

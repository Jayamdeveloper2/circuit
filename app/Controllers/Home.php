<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;
    public $data = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->data['setting'] = $this->db->table('web_setting')
            ->select('*')
            ->where('web_setting_id', 1)
            ->get()
            ->getRowArray();

        $this->data['menus'] = $this->db->table('web_menu')
            ->select('*,web_menu_id, web_title, web_url')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('web_menu_id', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['service_nav'] = $this->db->table('web_approach')
            ->select('web_approach_id, web_title, web_url')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getCommonData()
    {
        return $this->response->setJSON([
            'setting' => $this->data['setting'],
            'menus' => $this->data['menus'],
            'services' => $this->data['service_nav']
        ]);
    }
    public function splash()
    {
        return view('frontent/indexfetech');
    }
    public function index()
    {
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,meta_title,meta_desc,meta_key')
            ->where('web_menu_id', 1)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()->getRowArray();

        if (!$this->data['meta']) {
            $this->data['meta'] = [
                'meta_title' => 'Circuit Brilliance | Power Electronics PCB Design',
                'meta_desc' => '',
                'meta_key' => ''
            ];
        }


        $banners = $this->db->table('web_banner')
            ->select('*, CONCAT("' . BANNER_IMG . '", web_image) AS web_image')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($banners as &$banner) {
            if (empty($banner['button_url']) || $banner['button_url'] === '0') {
                $banner['button_url'] = 'contact';
            }
        }
        $this->data['banner_data'] = $banners;

        $this->data['home_about_data'] = $this->db->table('web_content')
            ->select('*, concat("' . CONTENT_IMG . '", web_image_1) as image, concat("' . CONTENT_IMG . '", web_image_2) as image2,status')
            ->where('web_content_id', 1)
            ->get()->getRowArray();

        $this->data['people_trust_card_data'] = $this->db->table('web_business')
            ->select('web_business_id, web_title, web_content, CONCAT("' . BUSINESS_IMG . '", web_image) as web_image, display_order, created_on, is_active')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->get()->getResultArray();

        $this->data['people_trust_data'] = $this->db->table('web_content')
            ->select('*,status')
            ->where('web_content_id', 2)
            ->get()->getRowArray();

        $this->data['home_gallery_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 3)
            ->get()->getRowArray();
        $this->data['gallery_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 11)
            ->get()->getRowArray();
        $this->data['home_gallerycard_data'] = $this->db->table('web_brand')
            ->select('web_brand_id,web_title,
            concat("' . BRAND_IMG . '",web_image) as web_image,display_order,created_on,display_order,is_active')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['home_contact_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 4)
            ->get()->getRowArray();

        $this->data['service_cate_card_data'] = $this->db->table('web_service_cate')
            ->select('*')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        $this->data['achievement_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 10)
            ->get()->getRowArray();

        $this->data['framework_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 13)
            ->get()->getRowArray();

        $this->data['whychoose_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 12)
            ->get()->getRowArray();

        $this->data['whychoose_card_data'] = $this->db->table('web_why_choose')
            ->select('*')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        $this->data['mission_hub_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 22)
            ->get()->getRowArray();
             // CTA for Home
        $this->data['cta'] = $this->db->table('web_call_to_action')
            ->where('tag', 'home')
            ->where('status', 1)
            ->get()->getRowArray();

        // Blog Content for Home
        $this->data['home_blog_content'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 23)
            ->get()->getRowArray();

        // Fetch latest blogs for list and carousel
        $this->data['blogs'] = $this->db->table('web_blog')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('created_on', 'DESC')
            ->limit(6)
            ->get()->getResultArray();



        // Your file is in frontend subfolder, so use:
        return view('frontent/index', $this->data);
    }

    // 1 - completed
    /**
     * Fetch and display frontend services page.
     * This method fetches service data and all related rows for the frontend.
     */
    public function pageabout()
    {
        // META DATA
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,
            CONCAT("' . MENU_IMG . '", web_image) AS menu_image,
            meta_title,
            meta_desc,
            meta_key
        ')
            ->where('web_menu_id', 2)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()
            ->getRowArray();
        
        if (!$this->data['meta']) {
            $this->data['meta'] = [
                'menu_image' => '',
                'meta_title' => 'About Us | Circuit Brilliance',
                'meta_desc' => '',
                'meta_key' => ''
            ];
        }

        $this->data['about_content_data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', 7)
            ->get()->getRowArray();

        $this->data['about_vision_data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', 5)
            ->get()->getRowArray();

        $this->data['about_mission_data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', 6)
            ->get()->getRowArray();

        $this->data['about_beliefs_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 14)
            ->get()->getRowArray();

        $this->data['about_quote_data'] = $this->db->table('web_content')
            ->select('*,concat("' . CONTENT_IMG . '",web_image_1) as image')
            ->where('web_content_id', 15)
            ->get()->getRowArray();

        $this->data['corevaluecard_data'] = $this->db->table('web_industry')
            ->select('web_industry_id, web_title,web_content,CONCAT("' . INDUSTRY_IMG . '", web_image) as web_image, display_order, created_on, is_active')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->get()->getResultArray();

        $this->data['corevalue_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 8)
            ->get()->getRowArray();

        $this->data['how_we_work_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 9)
            ->get()->getRowArray();

        $this->data['cred_badges'] = $this->db->table('web_cred_badge')
            ->select('*')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        return view('frontent/about', $this->data);
    }
    public function pageservices($slug = null)
    {
        // META DATA
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,
            CONCAT("' . MENU_IMG . '", web_image) AS menu_image,
            meta_title,
            meta_desc,
            meta_key
        ')
            ->where('web_menu_id', 3)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()
            ->getRowArray();
        if (!$this->data['meta']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // FETCH ALL SERVICES (APPROACH) - for sidebar list
        $this->data['services_data'] = $this->db->table('web_approach')
            ->select('web_approach_id, web_title, web_url, display_order')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()
            ->getResultArray();

        // FETCH SPECIFIC SERVICE WITH ALL FIELDS + IMAGES
        $approachBase = base_url('images/approach/');
        $serviceQuery = $this->db->table('web_approach')
            ->select('*,
                CONCAT("' . $approachBase . '", web_image)   AS svc_image,
                CONCAT("' . $approachBase . '", web_image_1) AS svc_image_1,
                CONCAT("' . $approachBase . '", web_image_2) AS svc_image_2
            ')
            ->where('is_deleted', 0)
            ->where('is_active', 1);

        if ($slug) {
            $serviceQuery->where('web_url', $slug);
        } else {
            // Default to first service by display_order
            $serviceQuery->orderBy('display_order', 'ASC')->limit(1);
        }

        $this->data['service'] = $serviceQuery->get()->getRowArray();

        if (!$this->data['service']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontent/services', $this->data);
    }


    public function pagegallery()
    {
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,concat("' . MENU_IMG . '",web_image) as menu_image,meta_title,meta_desc,meta_key')
            ->where('web_menu_id', 4)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()->getRowArray();

        if (!$this->data['meta']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['gallery_data'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 11)
            ->get()->getRowArray();

        $this->data['gallerycard_data'] = $this->db->table('web_gallery')
            ->select('*,concat("' . GALLERY_IMG . '",web_image) as web_image')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()->getResultArray();

        return view('frontent/gallery', $this->data);
    }

    public function pageContact()
    {
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,concat("' . MENU_IMG . '",web_image) as menu_image,meta_title,meta_desc,meta_key')
            ->where('web_menu_id', 5)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()->getRowArray();

        if (!$this->data['meta']) {
            $this->data['meta'] = [
                'menu_image' => '',
                'meta_title' => 'Contact Us | Circuit Brilliance',
                'meta_desc' => 'Get in touch with our engineering team.',
                'meta_key' => ''
            ];
        }

        $this->data['setting'] = $this->db->table('web_setting')
            ->select('*')
            ->where('web_setting_id', 1)
            ->get()->getRowArray();

          // CTA for Contact
        $this->data['cta'] = $this->db->table('web_call_to_action')
            ->where('tag', 'contact')
            ->where('status', 1)
            ->get()->getRowArray();


        return view('frontent/contact', $this->data);
    }

    public function pageportfolio()
    {
        // META DATA
        $this->data['meta'] = $this->db->table('web_menu')
            ->select('*,
            CONCAT("' . MENU_IMG . '", web_image) AS menu_image,
            meta_title,
            meta_desc,
            meta_key
        ')
            ->where('web_menu_id', 6)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->get()
            ->getRowArray();

        if (!$this->data['meta']) {
            $this->data['meta'] = [
                'menu_image' => '',
                'meta_title' => 'Our Portfolio | Circuit Brilliance',
                'meta_desc' => 'Power Electronics Design — Done Right, Every Time',
                'meta_key' => ''
            ];
        }

        // Portfolio Intro
        $this->data['portfolio_intro'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 16)
            ->get()->getRowArray();

        // Portfolio Domains
        $this->data['portfolio_domains'] = $this->db->table('web_portfolio_domain')
            ->select('*, CONCAT("' . PORTFOLIO_IMG . '", web_image) as image')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        // Showcase Projects
        $showcases = $this->db->table('web_portfolio_showcase')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($showcases as &$sc) {
            $sc['execution_progress'] = json_decode($sc['execution_progress'], true) ?: [];
            $sc['key_specifications'] = json_decode($sc['key_specifications'], true) ?: [];
            $sc['design_highlights'] = json_decode($sc['design_highlights'], true) ?: [];
            $sc['pcb_challenges'] = json_decode($sc['pcb_challenges'], true) ?: [];
            $sc['frameworks_applied'] = json_decode($sc['frameworks_applied'], true) ?: [];
            $sc['design_deliverables'] = json_decode($sc['design_deliverables'], true) ?: [];
        }
        $this->data['showcase_projects'] = $showcases;
        
        // Planned Showcase Designs
        $planned = $this->db->table('web_planned_showcase')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();
        
        $this->data['planned_showcases'] = $planned;

        // Planned Showcase Intro
        $this->data['planned_intro'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 17)
            ->get()->getRowArray();

        //CTA
        // CTA for Portfolio
        $this->data['cta'] = $this->db->table('web_call_to_action')
            ->where('tag', 'contact')
            ->where('status', 1)
            ->get()->getRowArray();


        return view('frontent/portfolio', $this->data);
    }

    public function peri()
    {
        // META DATA
        $this->data['meta'] = [
            'meta_title' => 'PERI | Power Electronics Research Institute',
            'meta_desc' => 'Academic Wing of Circuit Brilliance',
            'meta_key' => 'Power Electronics, Research, Training'
        ];

        // PERI Intro
        $this->data['peri_intro'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 18)
            ->get()->getRowArray();

        // PERI Anchors
        $this->data['peri_anchors'] = $this->db->table('web_peri_anchors')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        // PERI Training
        $this->data['peri_training'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 19)
            ->get()->getRowArray();
        
        // PERI Research & Institutions
        $this->data['peri_research'] = $this->db->table('web_content')
            ->select('*')
            ->where('web_content_id', 20)
            ->get()->getRowArray();

        // PERI CTAs
        $this->data['peri_ctas'] = $this->db->table('web_peri_ctas')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        return view('frontent/PERI', $this->data);
    }

    public function pagedomainservice()
    {
        // Fetch Hero Content
        $this->data['hero'] = $this->db->table('web_content')
            ->where('for', 'domain_service_hero')
            ->where('status', 1)
            ->get()->getRowArray();

        if (!$this->data['hero']) {
            $this->data['hero'] = [
                'web_content_1' => 'Specialist Expertise Across Four High-Growth Domains',
                'web_content_2' => 'Circuit Brilliance delivers complete, end-to-end power electronics design — from schematic capture through simulation, PCB layout, and full documentation. Specialist depth that generalist design houses cannot match.',
                'web_image_1' => 'hero_tech_banner_clean_v1_1775825435158.png'
            ];
        }

        // Fetch Service Details
        $this->data['service_details'] = $this->db->table('web_service_details')
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        foreach ($this->data['service_details'] as &$sd) {
            $sd['what_we_design'] = json_decode($sd['what_we_design'], true) ?: [];
            $sd['deliverables'] = json_decode($sd['deliverables'], true) ?: [];
            $sd['technologies'] = json_decode($sd['technologies'], true) ?: [];
        }

        $this->data['meta'] = [
            'meta_title' => 'Domain Services | Circuit Brilliance',
            'meta_desc' => 'Specialist power electronics design services.',
            'meta_key' => ''
        ];
        return view('frontent/domain-service', $this->data);
    }

    public function pageframeworks()
    {
        $this->data['meta'] = [
            'meta_title' => 'Proprietary Frameworks | Circuit Brilliance',
            'meta_desc' => 'Advanced engineering frameworks for power electronics.',
            'meta_key' => ''
        ];
        
        $db = \Config\Database::connect();
        $this->data['hero'] = $db->table('web_content')->where('for', 'framework_hero')->get()->getRowArray();
        
        $contents = $db->table('web_framework_content')->get()->getResultArray();
        $frameworks_content = [];
        foreach($contents as $c) {
            $frameworks_content[$c['framework_slug']][$c['section_key']] = $c['content_value'];
        }
        $this->data['frameworks_content'] = $frameworks_content;

        return view('frontent/frameworks', $this->data);
    }
      public function pageBlog()
    {
        $this->data['meta'] = [
            'meta_title' => 'Insights & Engineering Blog | Circuit Brilliance',
            'meta_desc' => 'Deep dives into power electronics, PCB design, and technical frameworks.',
            'meta_key' => 'Power Electronics Blog, PCB Design Insights'
        ];

        $this->data['blogs'] = $this->db->table('web_blog')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('display_order', 'ASC')
            ->get()->getResultArray();

        // CTA for Blog
        $this->data['cta'] = $this->db->table('web_call_to_action')
            ->where('tag', 'blog')
            ->where('status', 1)
            ->get()->getRowArray();

        return view('frontent/blog', $this->data);
    }

    public function pageBlogDetail($slug = null)
    {
        if ($slug) {
            $blog = $this->db->table('web_blog')
                ->where('web_slug', $slug)
                ->where('is_active', 1)
                ->where('is_deleted', 0)
                ->get()->getRowArray();

            if ($blog) {
                $this->data['blog'] = $blog;
                $this->data['meta'] = [
                    'meta_title' => $blog['meta_title'] ?: $blog['web_title'],
                    'meta_desc' => $blog['meta_desc'] ?: substr(strip_tags($blog['web_content']), 0, 160),
                    'meta_key' => $blog['meta_key'] ?: $blog['web_tag'],
                    'meta_image' => !empty($blog['web_image']) ? base_url(BLOG_IMG . $blog['web_image']) : base_url(LOGO),
                    'meta_url' => current_url()
                ];

                $this->data['recent_blogs'] = $this->db->table('web_blog')
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->where('web_blog_id !=', $blog['web_blog_id'])
                    ->orderBy('created_on', 'DESC')
                    ->limit(4)
                    ->get()->getResultArray();

                // CTA for Bottom (ID 5)
                $this->data['cta_bottom'] = $this->db->table('web_call_to_action')
                    ->where('web_call_to_action_id', 5)
                    ->get()->getRowArray();

                // CTA for Sidebar (ID 6)
                $this->data['cta_sidebar'] = $this->db->table('web_call_to_action')
                    ->where('web_call_to_action_id', 6)
                    ->get()->getRowArray();

                return view('frontent/blog-details', $this->data);
            }
        }
        
        return redirect()->to(base_url('blog'));
    }

}


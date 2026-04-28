<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->get('/', 'Home::index', ['as' => 'index']);
$routes->get('home', 'Home::index', ['as' => 'index']);
$routes->get('about', 'Home::pageabout', ['as' => 'about']);
$routes->get('about.php', 'Home::pageabout');
$routes->get('portfolio', 'Home::pageportfolio');
$routes->get('portfolio.php', 'Home::pageportfolio');
$routes->get('peri', 'Home::peri');
$routes->get('PERI', 'Home::peri');
$routes->get('PERI.php', 'Home::peri');
$routes->get('api/common-data', 'Home::getCommonData');


// Dynamic route alias fallback assignments
try {
    $db = \Config\Database::connect();
    $menus = $db->table('web_menu')->where('is_deleted', 0)->get()->getResultArray();
    foreach ($menus as $menu) {
        $slug = !empty($menu['web_url']) && $menu['web_url'] !== '0' ? $menu['web_url'] : null;

        // Final fallback if slug is missing 
        if (!$slug) {
            if ($menu['web_menu_id'] == 2) $slug = 'about';
            elseif ($menu['web_menu_id'] == 3) $slug = 'services';
            elseif ($menu['web_menu_id'] == 4) $slug = 'gallery';
            elseif ($menu['web_menu_id'] == 5) $slug = 'contact';
            elseif ($menu['web_menu_id'] == 6) $slug = 'portfolio';
            elseif ($menu['web_menu_id'] == 7) $slug = 'blog';
        }

        if ($slug && $menu['web_menu_id'] != 1) {
            if ($menu['web_menu_id'] == 2) {
                $routes->get($slug, 'Home::pageabout', ['as' => $slug]);
            } elseif ($menu['web_menu_id'] == 3) {
                $routes->get($slug, 'Home::pageservices', ['as' => $slug]);
                // Add detail route for each service
                $routes->get($slug . '/(:segment)', 'Home::pageservices/$1');
            } elseif ($menu['web_menu_id'] == 4) {
                $routes->get($slug, 'Home::pagegallery', ['as' => $slug]);
            } elseif ($menu['web_menu_id'] == 5) {
                $routes->get($slug, 'Home::pagecontact', ['as' => $slug]);
            } elseif ($menu['web_menu_id'] == 6) {
                $routes->get($slug, 'Home::pageportfolio', ['as' => $slug]);
            } elseif ($menu['web_menu_id'] == 7) {
                $routes->get($slug, 'Home::pageBlog', ['as' => $slug]);
                // Add detail route for blog
                $routes->get($slug . '/(:segment)', 'Home::pageBlogDetail/$1', ['as' => $slug . '_detail']);
            }
        }
    }
} catch (\Exception $e) {
    // Missing DB gracefully suppressed
}

$routes->post('contact/submit', 'Contact::submitContact');

// $routes->get('podcast', 'Home::pagePodcast', ['as' => 'podcast']);
$routes->get('blog', 'Home::pageBlog', ['as' => 'blog']);
$routes->get('blog.php', 'Home::pageBlog');
$routes->get('blog-details.php', 'Home::pageBlogDetail');
$routes->get('blog/(:segment)', 'Home::pageBlogDetail/$1', ['as' => 'blog_detail']);

try {
    $db = \Config\Database::connect();
    $menus = $db->table('web_menu')->where('is_deleted', 0)->get()->getResultArray();
    foreach ($menus as $menu) {
        $slug = !empty($menu['web_url']) && $menu['web_url'] !== '0' ? $menu['web_url'] : null;
        if ($slug && $menu['web_menu_id'] != 1) {
            if ($menu['web_menu_id'] == 2) {
                $routes->get($slug, 'Home::pageabout');
            } elseif ($menu['web_menu_id'] == 3) {
                $routes->get($slug, 'Home::pageservices');
            } elseif ($menu['web_menu_id'] == 4) {
                $routes->get($slug, 'Home::pagegallery');
            } elseif ($menu['web_menu_id'] == 5) {
                $routes->get($slug, 'Home::pagecontact');
            } elseif ($menu['web_menu_id'] == 6) {
                $routes->get($slug, 'Home::pageportfolio');
            } elseif ($menu['web_menu_id'] == 7) {
                $routes->get($slug, 'Home::pageBlog');
            }

        }
    }
} catch (\Exception $e) {
    // Missing DB gracefully suppressed
}

$routes->group(ADMIN_NAME, function ($routes) {
    $routes->get('/', 'Admin\Auth::index');

    $routes->get('logout', 'Admin\Auth::logout');
    $routes->post('upload-blog-content-image', 'Admin\Blog::upload_image');
    $routes->post('delete-blog-content-image', 'Admin\Blog::delete_image');
    $routes->get('blog-manage', 'Admin\Blog::pageBlog', ['as' => 'blog-manage']);
    $routes->get('cta-manage', 'Admin\MainPage::pageCallToAction', ['as' => 'cta-manage']);
   


    //Menu
    $routes->get('menu-manage', 'Admin\MainPage::pageMenu', ['as' => 'menu-manage']);

    //Setting
    $routes->get('social-manage', 'Admin\MainPage::pageSetting', ['as' => 'social-manage']);
    //SMTP Setting
    $routes->get('smtp-manage', 'Admin\MainPage::pageSmtp', ['as' => 'smtp-manage']);

    //Banner
    $routes->get('banner-manage', 'Admin\MainPage::pageBanner', ['as' => 'banner-manage']);

    //Home Meta
    $routes->get('home-meta', 'Admin\MainPage::pageHomeMeta', ['as' => 'home-meta']);

    //Home About Content
    $routes->get('homeaboutcontent-manage', 'Admin\MainPage::pageHomeAbout', ['as' => 'homeaboutcontent-manage']);
    // our services
    $routes->get('what-we-design-manage', 'Admin\MainPage::pageAboutOurBusiness', ['as' => 'what-we-design-manage']);
    //our design
    $routes->get('ourdesign-manage', 'Admin\MainPage::pageServiceCate', ['as' => 'ourdesign-manage']);
    //home contact
    $routes->get('homecontact-manage', 'Admin\MainPage::pageHomeContact', ['as' => 'homecontact-manage']);

    //Why Choose Us
    $routes->get('whychoose-manage', 'Admin\MainPage::pageWhyChooseUs', ['as' => 'whychoose-manage']);

    //Clients
    $routes->get('homegallery-manage', 'Admin\MainPage::pageClients', ['as' => 'homegallery-manage']);
    //Page About
    $routes->get('aboutabout-manage', 'Admin\MainPage::pageAboutAbout', ['as' => 'aboutabout-manage']);
    //About Vision
    $routes->get('design-hub-manage', 'Admin\MainPage::pageAboutVision', ['as' => 'design-hub-manage']);
    //About Mission
    $routes->get('our-approach-manage', 'Admin\MainPage::pageAboutMission', ['as' => 'our-approach-manage']);
    //our industry
    $routes->get('ourcorevalues-manage', 'Admin\MainPage::pageAboutOurIndustry', ['as' => 'ourcorevalues-manage']);

    //Cred Badges
    $routes->get('cred-badges-manage', 'Admin\MainPage::pageCredBadges', ['as' => 'cred-badges-manage']);
    $routes->get('how-we-work-manage', 'Admin\MainPage::pageAboutHowWeWork', ['as' => 'how-we-work-manage']);
    $routes->match(['get', 'post'], 'aboutbeliefs', 'Admin\MainPage::pageAboutBeliefs');
    $routes->match(['get', 'post'], 'aboutquote', 'Admin\MainPage::pageAboutQuote');
    $routes->get('about-beliefs-manage', 'Admin\MainPage::pageAboutBeliefs', ['as' => 'about-beliefs-manage']);

    //Services
    $routes->get('services-manage', 'Admin\MainPage::pageApproach', ['as' => 'services-manage']);

    // Gallery
    $routes->get('gallery-manage', 'Admin\MainPage::pageGallery', ['as' => 'gallery-manage']);

    // Measured Impact (Counters)
    $routes->get('measured-manage', 'Admin\MainPage::pageMeasured', ['as' => 'measured-manage']);

    //Engineering Assurance Framework
    $routes->get('framework-manage', 'Admin\MainPage::pageFramework', ['as' => 'framework-manage']);

    //Home Blog Content
    $routes->get('homeblogcontent-manage', 'Admin\MainPage::pageHomeBlogContent', ['as' => 'homeblogcontent-manage']);

    // Portfolio
    $routes->get('portfolio-manage', 'Admin\MainPage::pagePortfolio', ['as' => 'portfolio-manage']);
    $routes->get('showcase-manage', 'Admin\MainPage::pageShowcase', ['as' => 'showcase-manage']);
    $routes->get('planned-showcase-manage', 'Admin\MainPage::pagePlannedShowcase', ['as' => 'planned-showcase-manage']);




    $routes->group('api', function ($routes) {
        //Auth  
        $routes->post('loginCheck', 'Admin\Auth::loginCheck');
        $routes->post('changeUserPassword', 'Admin\Auth::changeUserPassword');
        $routes->post('changeUserEmail', 'Admin\Auth::changeUserEmail');

        //Menu
        $routes->post('getMenu', 'Admin\MainPage::getMenu');
        $routes->post('saveMenu', 'Admin\MainPage::saveMenu');

        //Why Choose Us
        $routes->post('getWhyChooseUs', 'Admin\MainPage::getWhyChooseUs');
        $routes->post('saveWhyChooseUs', 'Admin\MainPage::saveWhyChooseUs');

        //Setting
        $routes->post('saveSetting', 'Admin\MainPage::saveSetting');
        //SMTP Setting
        $routes->post('saveSmtp', 'Admin\MainPage::saveSmtp');

        //Home Meta
        $routes->post('saveHomeMeta', 'Admin\MainPage::saveHomeMeta');

        //Banner
        $routes->post('getBanner', 'Admin\MainPage::getBanner');
        $routes->post('saveBanner', 'Admin\MainPage::saveBanner');
        $routes->post('pagefunctionmanage', 'Admin\MainPage::pagefunctionmanage');

        $routes->post('saveContent', 'Admin\MainPage::saveContent');


        //Clients
        $routes->post('getBrand', 'Admin\MainPage::getBrand');
        $routes->post('saveBrand', 'Admin\MainPage::saveBrand');


        $routes->post('getAboutOurBusiness', 'Admin\MainPage::getAboutOurBusiness');
        $routes->post('saveAboutOurBusiness', 'Admin\MainPage::saveAboutOurBusiness');

        $routes->post('getAboutOurIndustry', 'Admin\MainPage::getAboutOurIndustry');
        $routes->post('saveAboutOurIndustry', 'Admin\MainPage::saveAboutOurIndustry');

        $routes->post('getCredBadges', 'Admin\MainPage::getCredBadges');
        $routes->post('saveCredBadge', 'Admin\MainPage::saveCredBadge');

        $routes->post('getServiceCate', 'Admin\MainPage::getServiceCate');
        $routes->post('saveServiceCate', 'Admin\MainPage::saveServiceCate');
        $routes->post('getApproach', 'Admin\MainPage::getApproach');
        $routes->post('saveApproach', 'Admin\MainPage::saveApproach');

        $routes->post('getPortfolioDomain', 'Admin\MainPage::getPortfolioDomain');
        $routes->post('savePortfolioDomain', 'Admin\MainPage::savePortfolioDomain');

        $routes->post('getPortfolioShowcase', 'Admin\MainPage::getPortfolioShowcase');
        $routes->post('savePortfolioShowcase', 'Admin\MainPage::savePortfolioShowcase');

        $routes->post('getPlannedShowcase', 'Admin\MainPage::getPlannedShowcase');
        $routes->post('savePlannedShowcase', 'Admin\MainPage::savePlannedShowcase');




        $routes->post('getEvent', 'Admin\MainPage::getEvent');
        $routes->post('saveEvent', 'Admin\MainPage::saveEvent');


        $routes->post('getEventImages', 'Admin\MainPage::getEventImages');
        $routes->post('saveEventImage', 'Admin\MainPage::saveEventImage');

        $routes->post('getEventVideos', 'Admin\MainPage::getEventVideos');
        $routes->post('saveEventVideo', 'Admin\MainPage::saveEventVideo');

        //Gallery
        $routes->post('getGallery', 'Admin\MainPage::getGallery');
        $routes->post('saveGallery', 'Admin\MainPage::saveGallery');

        //Blog
        $routes->post('getBlog', 'Admin\Blog::getBlog');
        $routes->post('saveBlog', 'Admin\Blog::saveBlog');

        //Call to Action
        $routes->post('getCallToAction', 'Admin\MainPage::getCallToAction');
        $routes->post('getCallToActions', 'Admin\MainPage::getCallToActions');
        $routes->post('saveCallToAction', 'Admin\MainPage::saveCallToAction');


    });
});

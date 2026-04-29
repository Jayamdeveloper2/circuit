<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 99%; overflow-y: auto;">
                <ul class="sidebar-menu" data-widget="tree">

                    <!-- sidebar menu-->

                    <?php
                    $router = service('router');
                    $routeName = $router->getMatchedRouteOptions()['as'] ?? 'no name';
                    ?>
                    <li class="header fs-10 m-0 text-uppercase">Navbar </li>

                    <li class="  <?= ($routeName == "menu-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/menu-manage') ?>">
                            <i class="fas fa-home" style="font-size: 18px"></i>
                            <span>Menu</span>
                        </a>
                    </li>


                    <li class="header fs-10 m-0 text-uppercase">Home</li>

                    <li class="  <?= ($routeName == "home-meta") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/home-meta') ?>">
                            <i class="fas fa-tags" style="font-size: 18px"></i>
                            <span>Home Meta Tags</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "banner-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/banner-manage') ?>">

                            <i class="fas fa-image" style="font-size: 18px"></i>
                            <span>Banner</span>
                        </a>
                    </li>





                    <li class="  <?= ($routeName == "homeaboutcontent-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homeaboutcontent-manage') ?>">

                            <i class="fas fa-id-card" style="font-size: 18px"></i>
                            <span>Home About Content</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "what-we-design-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/what-we-design-manage') ?>">

                            <i class="fas fa-user-check" style="font-size: 18px"></i>
                            <span>What We Design</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "ourdesign-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/ourdesign-manage') ?>">

                            <i class="fas fa-user-edit" style="font-size: 18px"></i>
                            <span>Our Design</span>
                        </a>
                    </li>

                    <!--<li class="  <?= ($routeName == "ouroffer-manage") ? "active" : "" ?>">-->
                    <!--    <a href="<?= base_url(ADMIN_NAME . '/ouroffer-manage') ?>">-->

                    <!--        <i class="fas fa-award"  style="font-size: 18px"></i>-->
                    <!--        <span>What We Offer</span>-->
                    <!--    </a>-->
                    <!--</li> -->

                    <!--new -->

                    <!-- <li class="  <?= ($routeName == "homegallery-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homegallery-manage') ?>">

                            <i class="fas fa-image" style="font-size: 18px"></i>
                            <span>Home Gallery</span>
                        </a>
                    </li> -->


                    <!--off -->



                    <!-- <li class="  <?= ($routeName == "homecontact-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homecontact-manage') ?>">

                            <i class="fas fa-phone" style="font-size: 18px"></i>
                            <span>Home Contact</span>
                        </a>
                    </li> -->
                    <li class="  <?= ($routeName == "homemission-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homemission-manage') ?>">
                            <i class="fas fa-bullseye" style="font-size: 18px"></i>
                            <span>Mission Hub</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "measured-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/measured-manage') ?>">
                            <i class="fas fa-balance-scale" style="font-size: 18px"></i>
                            <span>Key Achievements</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "whychoose-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/whychoose-manage') ?>">
                            <i class="fas fa-question-circle" style="font-size: 18px"></i>
                            <span>Why Choose Us</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "framework-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/framework-manage') ?>">
                            <i class="fas fa-shield-alt" style="font-size: 18px"></i>
                            <span>Engineering Assurance</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "homeblogcontent-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homeblogcontent-manage') ?>">
                            <i class="fas fa-newspaper" style="font-size: 18px"></i>
                            <span>Blog Content</span>
                        </a>
                    </li>
                    <li class="header fs-10 m-0 text-uppercase">About</li>

                    <li class="treeview <?= (in_array($routeName, ['aboutabout-manage', 'design-hub-manage', 'our-approach-manage', 'cred-badges-manage', 'how-we-work-manage', 'aboutquote', 'about-beliefs-manage', 'ourcorevalues-manage'])) ? "active menu-open" : "" ?>">
                        <a href="#">
                            <i class="fas fa-info-circle" style="font-size: 18px"></i>
                            <span>About Page</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($routeName == "aboutabout-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/aboutabout-manage'); ?>"><i class="ti-more"></i>About Us</a></li>
                            <li class="<?= ($routeName == "design-hub-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/design-hub-manage'); ?>"><i class="ti-more"></i>Design Hub</a></li>
                            <li class="<?= ($routeName == "our-approach-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/our-approach-manage'); ?>"><i class="ti-more"></i>Our Approach</a></li>
                            
                            <li class="<?= ($routeName == "cred-badges-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/cred-badges-manage'); ?>"><i class="ti-more"></i>Cred Badges</a></li>
                            <li class="<?= ($routeName == "how-we-work-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/how-we-work-manage'); ?>"><i class="ti-more"></i>How We Work</a></li>
                            <li class="<?= ($routeName == "aboutquote") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/aboutquote'); ?>"><i class="ti-more"></i>About Pull Quote</a></li>
                            <li class="<?= ($routeName == "about-beliefs-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/about-beliefs-manage'); ?>"><i class="ti-more"></i>What We Believe</a></li>
                        </ul>
                    </li>

                    <li class="header fs-10 m-0 text-uppercase">Portfolio</li>
                    <li class="  <?= ($routeName == "portfolio-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/portfolio-manage') ?>">
                            <i class="fas fa-briefcase" style="font-size: 18px"></i>
                            <span>Domain Management</span>
                        </a>
                    </li>
                    <li class="treeview <?= (in_array($routeName, ['showcase-manage', 'planned-showcase-manage'])) ? "active menu-open" : "" ?>">
                        <a href="#">
                            <i class="fas fa-microchip" style="font-size: 18px"></i>
                            <span>Showcase Projects</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($routeName == "showcase-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/showcase-manage') ?>"><i class="ti-more"></i>Flagship Showcase</a></li>
                            <li class="<?= ($routeName == "planned-showcase-manage") ? "active" : "" ?>"><a href="<?= base_url(ADMIN_NAME . '/planned-showcase-manage') ?>"><i class="ti-more"></i>Planned Showcase</a></li>
                        </ul>
                    </li>

                    <li class="header fs-10 m-0 text-uppercase">PERI</li>

                    <li class="  <?= ($routeName == "peri-content-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-content-manage') ?>">
                            <i class="fas fa-file-alt" style="font-size: 18px"></i>
                            <span>Introduction</span>
                        </a>
                    </li>
                    
                    <li class="  <?= ($routeName == "peri-anchors-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-anchors-manage') ?>">
                            <i class="fas fa-th-large" style="font-size: 18px"></i>
                            <span>Anchor Cards</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "peri-training-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-training-manage') ?>">
                            <i class="fas fa-user-graduate" style="font-size: 18px"></i>
                            <span>Students & Graduates</span>
                        </a>
                    </li>
                    
                    <li class="  <?= ($routeName == "peri-research-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-research-manage') ?>">                             
                            <i class="fas fa-university" style="font-size: 18px"></i>
                            <span>Institutions & Research</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "peri-ctas-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-ctas-manage') ?>">                             
                            <i class="fas fa-mouse-pointer" style="font-size: 18px"></i>
                            <span>Action Cards</span>
                        </a>
                    </li>
<li class="header fs-10 m-0 text-uppercase">Services</li>
                    
                    <li class="  <?= ($routeName == "domain-services-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/domain-services-manage') ?>">
                            <i class="fas fa-microchip" style="font-size: 18px"></i>
                            <span>Domain Services</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "frameworks-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/frameworks-manage') ?>">
                            <i class="fas fa-microchip" style="font-size: 18px"></i>
                            <span>Frameworks</span>
                        </a>
                    </li>


                    <!-- <li class="header fs-10 m-0 text-uppercase">Products</li>
                    <li class="<?= ($routeName == "product-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/product-manage') ?>">
                            <i class="fas fa-image" style="font-size: 18px"></i>
                            <span>Products</span>
                        </a>
                    </li> -->



                    <!-- <li class="header fs-10 m-0 text-uppercase">Gallery</li>

                    <li class="  <?= ($routeName == "gallery-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/gallery-manage') ?>">
                            <i class="fas fa-image" style="font-size: 18px"></i>
                            <span>Gallery</span>
                        </a>
                    </li>

<li class="  <?= ($routeName == "ourcorevalues-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/ourcorevalues-manage') ?>">
                            <i class="fas fa-star" style="font-size: 18px"></i>
                            <span>Our Core Values</span>
                        </a>
                    </li> -->

                    <li class="header fs-10 m-0 text-uppercase">Blog</li>
                    
                    <li class="  <?= ($routeName == "blog-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/blog-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Blog List</span>
                        </a>
                    </li>

                    <li class="header fs-10 m-0 text-uppercase">Call to action</li>
                    
                    <li class="  <?= ($routeName == "cta-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/cta-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Call to action</span>
                        </a>
                    </li>


                    <!-- <li class="  <?= ($routeName == "teamfounder-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/teamfounder-manage') ?>">

                            <i class="fas fa-user-tie"  style="font-size: 18px"></i>
                            <span> Founder</span>
                        </a>
                    </li>
                    
                    <li class="  <?= ($routeName == "aboutcontact-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/aboutcontact-manage') ?>">
                            
                            <i class="fas fa-phone-alt"  style="font-size: 18px"></i>
                            <span>Call to action</span>
                        </a>
                    </li> -->

                    <!-- <li class="  <?= ($routeName == "aboutourmission-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/aboutourmission-manage') ?>">
                            
                            <i class="fas fa-handshake"  style="font-size: 18px"></i>
                            <span>About Mission</span>
                        </a>
                    </li> -->


<!-- <li class="  <?= ($routeName == "services-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/services-manage') ?>">
                            <i class="fas fa-layer-group" style="font-size: 18px"></i>
                            <span>Services</span>
                        </a>
                    </li> -->

                    <!-- <li class="header fs-10 m-0 text-uppercase">Accomplishments</li>
                    
                    
                    <li class="  <?= ($routeName == "our-impact") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/our-impact') ?>">
                            <i class="fas fa-book"  style="font-size: 18px"></i>
                            <span> Our Impact</span>
                        </a>
                    </li> -->



                    <!-- <li class="  <?= ($routeName == "products-ceiling") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/products-ceiling') ?>">
                            <i class="fas fa-house-user"  style="font-size: 18px"></i>
                            <span>Ceiling</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "products-wooden") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/products-wooden') ?>">
                            <i class="fas fa-warehouse"  style="font-size: 18px"></i>
                            <span>Wooden</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "products-architectural") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/products-architectural') ?>">
                            <i class="fas fa-archway"  style="font-size: 18px"></i>
                            <span>Architectural</span>
                        </a>
                    </li> -->
                    <!-- <li class="header fs-10 m-0 text-uppercase">Pro Bono Services</li>
                    
                    
                    <li class="  <?= ($routeName == "Bonoservice-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/Bonoservice-manage') ?>">                             
                            <i class="fas fa-hand-holding-heart" style="font-size: 18px"></i>
                            <span>Pro Bono Services</span>
                        </a>
                    </li> -->

                    <!-- <li class="  <?= ($routeName == "brand-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/brand-manage') ?>">                             
                            <i class="fas fa-flag" style="font-size: 18px"></i>
                            <span>Consultant Expect</span>
                        </a>
                    </li>

                     <li class="  <?= ($routeName == "Achivements-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/Achivements-manage') ?>">

                            <i class="fas fa-trophy"  style="font-size: 18px"></i>
                            <span>Achievements</span>
                        </a>
                    </li> 
                    
                    <li class="  <?= ($routeName == "homecontact-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/homecontact-manage') ?>">
                            <i class="fas fa-phone"  style="font-size: 18px"></i>
                            <span>Call to action </span>
                        </a>

                        </li>
                    
                    
                    <li class="  <?= ($routeName == "service-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/service-manage') ?>">
                            
                            <i class="fas fa-tools"  style="font-size: 18px"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    <li class="  <?= ($routeName == "resources-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/resources-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Cost</span>
                        </a>
                    </li>
                     -->
                    <!--<li class="header fs-10 m-0 text-uppercase">Gallery</li>-->

                    <!--<li class="  <?= ($routeName == "gallery-manage") ? "active" : "" ?>">-->
                    <!--    <a href="<?= base_url(ADMIN_NAME . '/gallery-manage') ?>">-->

                    <!--        <i class="fas fa-image"  style="font-size: 18px"></i>-->
                    <!--        <span>Gallery</span>-->
                    <!--    </a>-->
                    <!--</li>-->



                    <!-- <li class="header fs-10 m-0 text-uppercase">Podcast</li>

                    <li class="  <?= ($routeName == "podcast-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/podcast-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Content</span>
                        </a>
                    </li>
                    
                    <li class="  <?= ($routeName == "podcastlist-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/podcastlist-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Podcast List</span>
                        </a>
                    </li>

                    <li class="header fs-10 m-0 text-uppercase">PERI (Academic Wing)</li>
                    
                    <li class="  <?= ($routeName == "peri-anchors-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-anchors-manage') ?>">                             
                            <i class="fas fa-link" style="font-size: 18px"></i>
                            <span>Anchor Cards</span>
                        </a>
                    </li>
                    
                    <li class="  <?= ($routeName == "peri-training-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/peri-training-manage') ?>">                             
                            <i class="fas fa-user-graduate" style="font-size: 18px"></i>
                            <span>Students & Graduates</span>
                        </a>
                    </li>


                    <li class="header fs-10 m-0 text-uppercase">Blog</li>
                    <li class="  <?= ($routeName == "blog-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/blog-manage') ?>">                             
                            <i class="fas fa-address-card" style="font-size: 18px"></i>
                            <span>Blog List</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "involvedlist-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/involvedlist-manage') ?>">
                            <i class="fas fa-sitemap" style="font-size: 18px"></i>
                            <span>Involved List</span>
                        </a>
                    </li>
                    <li class="<?= ($routeName == "donation-form-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/donation-form-manage') ?>">
                            <i class="fas fa-donate" style="font-size: 18px"></i>
                            <span>Donation Form</span>
                        </a>
                    </li>


                    <li class="header fs-10 m-0 text-uppercase">Work with Us</li>

                    
                    <li class="<?= ($routeName == "work-content-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/work-content-manage') ?>">
                            <i class="fas fa-newspaper" style="font-size: 18px"></i>
                            <span>Content</span>
                        </a>
                    </li>
                    
                    <li class="<?= ($routeName == "whatwedo-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/whatwedo-manage') ?>">
                            <i class="fas fa-lightbulb" style="font-size: 18px"></i>
                            <span>What We Do</span>
                        </a>
                    </li>
                    <li class="<?= ($routeName == "looks-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/looks-manage') ?>">
                            <i class="fas fa-photo-video" style="font-size: 18px"></i>
                            <span>Looks Like in Action</span>
                        </a>
                    </li>
                    <li class="<?= ($routeName == "measured-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/measured-manage') ?>">
                            <i class="fas fa-balance-scale" style="font-size: 18px"></i>
                            <span>Our Measured Impact</span>
                        </a>
                    </li>
                      <li class="<?= ($routeName == "pilot-partner-manage") ? "active" : "" ?>">
                          <a href="<?= base_url(ADMIN_NAME . '/pilot-partner-manage') ?>">
                              <i class="fas fa-handshake" style="font-size: 18px"></i>
                              <span>Become a Pilot Partner</span>
                            </a>
                        </li>

                        <li class="<?= ($routeName == "sponsor-manage") ? "active" : "" ?>">
                            <a href="<?= base_url(ADMIN_NAME . '/sponsor-manage') ?>">
                            <i class="fas fa-handshake" style="font-size: 18px"></i>
                            <span>Sponsor</span>
                        </a>
                    </li> -->



                    <li class="header fs-10 m-0 text-uppercase">Contact</li>

                    <li class="  <?= ($routeName == "social-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/social-manage') ?>">
                            <i class="fas fa-envelope-open-text" style="font-size: 18px"></i>
                            <span>Contact Us</span>
                        </a>
                    </li>

                    <li class="  <?= ($routeName == "smtp-manage") ? "active" : "" ?>">
                        <a href="<?= base_url(ADMIN_NAME . '/smtp-manage') ?>">
                            <i class="fas fa-server" style="font-size: 18px"></i>
                            <span>SMTP Setting</span>
                        </a>
                    </li>




                </ul>


            </div>
        </div>
    </section>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const container = document.querySelector('.multinav-scroll');

        // Restore
        const saved = localStorage.getItem("adminSidebarScroll");
        if (saved) {
            container.scrollTop = saved;
        }

        // Save
        container.addEventListener("scroll", function() {
            localStorage.setItem("adminSidebarScroll", container.scrollTop);
        });

    });
</script>
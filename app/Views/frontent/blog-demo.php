<?php include('common/header.php'); ?>

<main class="inner-page">
    <!-- ════════════════ INNER BANNER ════════════════ -->
    <section class="inner-banner">
        <div class="ib-content container">
            <h1 class="ib-title" data-aos="fade-up">Insights & Engineering Blog</h1>
            <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">Deep dives into power electronics, PCB design, and technical frameworks.</p>
        </div>
    </section>

    <!-- ════════════════ BLOG LIST SECTION ════════════════ -->
    <section class="sec-padding bg-light-gray">
        <div class="container">
            <div class="blog-main-grid">
                <!-- Blog 1: The First Card with Details Link -->
                <div class="blog-card-v2" data-aos="fade-up">
                    <div class="bc-img-w">
                        <img src="assets/img/blog_ev.png" alt="Circuit Brilliance — High-Voltage SiC MOSFET Design" loading="lazy">
                        <span class="bc-tag">Technical Design</span>
                    </div>
                    <div class="bc-content">
                        <div class="bc-meta">
                            <span><i class="fa-solid fa-calendar-days"></i> April 15, 2026</span>
                          
                        </div>
                        <h3>Optimizing Gate Drive Design for SiC MOSFETs in High-Power Converters</h3>
                        <p>Silicon Carbide (SiC) MOSFETs offer significant performance advantages over traditional Si IGBTs, but they present unique challenges in gate drive design.</p>
                        <a href="blog-details.php" class="bc-link">Read Full Insight <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Blog 2 -->
                <div class="blog-card-v2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bc-img-w">
                        <img src="assets/img/blog_smps.png" alt="Circuit Brilliance — EMI Mitigation Strategies" loading="lazy">
                        <span class="bc-tag">Frameworks</span>
                    </div>
                    <div class="bc-content">
                        <div class="bc-meta">
                            <span><i class="fa-solid fa-calendar-days"></i> March 28, 2026</span>
                        </div>
                        <h3>The EMI-First Methodology: Integrating Compliance into the Early Schematic Phase</h3>
                        <p>Waiting for the laboratory phase to test for EMI is a costly mistake. Our proprietary framework focuses on pre-emptive noise isolation at the board level.</p>
                        <a href="#" class="bc-link">Read Full Insight <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Blog 3 -->
                <div class="blog-card-v2" data-aos="fade-up">
                    <div class="bc-img-w">
                        <img src="assets/img/blog_bms.png" alt="Circuit Brilliance — EV Battery Management Systems" loading="lazy">
                        <span class="bc-tag">EV Solutions</span>
                    </div>
                    <div class="bc-content">
                        <div class="bc-meta">
                            <span><i class="fa-solid fa-calendar-days"></i> March 12, 2026</span>
                        </div>
                        <h3>Managing Thermal Runaway through Advanced PCB Thermal Stackups</h3>
                        <p>In high-density EV Battery Management Systems, thermal management is not just about heat sinks. It starts with the copper weight and thermal via patterns.</p>
                        <a href="#" class="bc-link">Read Full Insight <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Blog 4 -->
                <div class="blog-card-v2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bc-img-w">
                        <img src="assets/img/blog_inverter.png" alt="Circuit Brilliance — Power Grid Resilience" loading="lazy">
                        <span class="bc-tag">Renewable Energy</span>
                    </div>
                    <div class="bc-content">
                        <div class="bc-meta">
                            <span><i class="fa-solid fa-calendar-days"></i> February 24, 2026</span>
                        </div>
                        <h3>The Role of Multi-Level Inverters in Modern Grid Resilience</h3>
                        <p>As renewable energy penetration increases, the demand for high-efficiency grid-tied inverters grows. We analyze the trade-offs of 3-level NPC topologies.</p>
                        <a href="#" class="bc-link">Read Full Insight <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════ LET'S WORK TOGETHER (CTA) ════════════════ -->
    <section class="cta-sec" id="contact-cta">
        <div class="container">
            <div class="cta-inner wow zoomIn">
                <h2 class="cta-h">Let's Work <span>Together</span></h2>
                <p class="cta-sub">Whether you are an EV startup, a renewable energy company, or an industrial electronics
                    team — Circuit Brilliance is ready to help. No obligation — just a straightforward conversation about
                    your project.</p>

                <a href="contact.php" class="btn-cta">Contact Us</a>

                <div class="cta-channels">
                    <!-- Form -->
                    <a href="contact.php" class="cta-chan">
                        <div class="cc-icon"><i class="fa-solid fa-file-signature"></i></div>
                        <div class="cc-text">
                            <span>Contact Form</span>
                            <strong>Fill in our project inquiry form</strong>
                        </div>
                    </a>

                    <!-- Email -->
                    <a href="mailto:contact@circuitbrilliance.com" class="cta-chan">
                        <div class="cc-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="cc-text">
                            <span>Email</span>
                            <strong>contact@circuitbrilliance.com</strong>
                        </div>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/918870174864" target="_blank" rel="noopener noreferrer" class="cta-chan">
                        <div class="cc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="cc-text">
                            <span>WhatsApp</span>
                            <strong>Message us on WhatsApp</strong>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('common/footer.php'); ?>
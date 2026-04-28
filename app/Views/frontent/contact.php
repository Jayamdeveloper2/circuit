<?php include 'common/header.php'; ?>

<!-- ════════════════ UNIFIED INNER BANNER ════════════════ -->
<section class="inner-banner">
    <div class="ib-content container">
        <h1 class="ib-title">Let's Talk <span>Power Electronics</span></h1>
        <p class="page-subtitle">Tell us about your project — we will take it from there</p>
    </div>
</section>

<!-- ============================================================
     SECTION 2 — OPENING STATEMENT
============================================================ -->
<section class="sec-padding" style="background-color: var(--bg-light);">
    <div class="container text-center">
        <p class="cb-opening-text" data-aos="fade-up">
            Whether you have a fully defined design brief or just a half-formed idea that needs an expert sounding board — this is the right place to start. Share what you have and we will take it from there — we respond within 8 business hours.
        </p>
    </div>
</section>

<!-- ============================================================
     SECTION 3 — CONTACT CHANNEL CARDS
============================================================ -->
<section class="sec-padding" style="background:#fff;">
    <div class="container">
        <div class="cb-cards-grid">

            <!-- Email Card -->
            <?php if (!empty($setting['user_email'])): ?>
            <a href="mailto:<?= esc($setting['user_email']) ?>" class="cb-channel-card cb-card-email" data-aos="fade-up" data-aos-delay="100">
                <div class="cb-cc-icon"><i class="fa-solid fa-envelope"></i></div>
                <h3 class="cb-cc-title">✉ Email</h3>
                <p class="cb-cc-detail"><?= esc($setting['user_email']) ?></p>
                <p class="cb-cc-sub">For detailed project briefs</p>
                <div class="cb-cc-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <?php endif; ?>

            <!-- WhatsApp Card -->
            <?php if (!empty($setting['user_phone_1'])): ?>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $setting['user_phone_1']) ?>" target="_blank" rel="noopener noreferrer" class="cb-channel-card cb-card-wa" data-aos="fade-up" data-aos-delay="200">
                <div class="cb-cc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                <h3 class="cb-cc-title">💬 WhatsApp</h3>
                <p class="cb-cc-detail">Message us directly</p>
                <p class="cb-cc-sub">For quick questions and fast responses</p>
                <div class="cb-cc-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <?php endif; ?>

            <!-- LinkedIn Card -->
            <?php if (!empty($setting['linkedin_url'])): ?>
            <a href="<?= esc($setting['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer" class="cb-channel-card cb-card-in" data-aos="fade-up" data-aos-delay="300">
                <div class="cb-cc-icon"><i class="fa-brands fa-linkedin-in"></i></div>
                <h3 class="cb-cc-title">in LinkedIn</h3>
                <p class="cb-cc-detail">Connect with us</p>
                <p class="cb-cc-sub">Circuit Brilliance — Power Electronics Design Hub</p>
                <div class="cb-cc-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            </a>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- ============================================================
     SECTION 4 + 5 — TWO COLUMN LAYOUT: DETAILS + FORM
============================================================ -->
<section class="sec-padding pt-0 pb-0" style="background:#fff;">
    <div class="container">
        <div class="cb-contact-main-grid">

            <!-- LEFT COLUMN — Contact Details Strip -->
            <div class="contact-details-box" data-aos="fade-right">
                <?php if (!empty($setting['user_email'])): ?>
                <div class="cd-item">
                    <div class="cd-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="cd-info">
                        <span class="cd-label">Email Us</span>
                        <div class="cd-detail">
                            <a href="mailto:<?= esc($setting['user_email']) ?>"><?= esc($setting['user_email']) ?></a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($setting['user_phone_1'])): ?>
                <div class="cd-item">
                    <div class="cd-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="cd-info">
                        <span class="cd-label">WhatsApp</span>
                        <div class="cd-detail">
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $setting['user_phone_1']) ?>" target="_blank" rel="noopener noreferrer">Message us on WhatsApp</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($setting['linkedin_url'])): ?>
                <div class="cd-item">
                    <div class="cd-icon"><i class="fa-brands fa-linkedin-in"></i></div>
                    <div class="cd-info">
                        <span class="cd-label">LinkedIn</span>
                        <div class="cd-detail">
                            <a href="<?= esc($setting['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer">Circuit Brilliance</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="cd-item">
                    <div class="cd-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="cd-info">
                        <span class="cd-label">Response Time</span>
                        <div class="cd-detail">
                            <span>We respond within 8 business hours</span>
                        </div>
                    </div>
                </div>

                <div class="response-promise-box">
                    <p>Your project will not wait and neither will we. <span class="promise-bold">We respond within 8 business hours.</span></p>
                </div>
            </div>

            <!-- RIGHT COLUMN — Inquiry Form -->
            <div class="inquiry-form-panel" data-aos="fade-left">
                <!-- Post-Submission Message -->
                <div id="cbSuccessMessage" class="success-msg-container" hidden>
                    <div class="success-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <h3>Message received — thank you!</h3>
                    <p>We have your project brief and we will get back to you within 8 business hours. In the meantime — if you have not already, take a look at our blog for technical insights and our services page for what we can do together.</p>
                    <div class="success-btns">
                        <a href="domain-service.php" class="btn-cta-hdr" style="padding: 12px 25px;">Explore Our Services →</a>
                        <a href="blog.php" class="btn-cta-hdr" style="padding: 12px 25px; background: var(--navy);">Read the Blog →</a>
                    </div>
                </div>

                <form id="cbContactForm">
                    <div class="form-sub-header">
                        <h2>Tell Us About <span>Your Project</span></h2>
                        <p class="form-sub">The more detail you share, the more useful our first response will be.</p>
                    </div>

                    <!-- Honeypot -->
                    <div style="position:absolute; left:-5000px;">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" />
                    </div>

                    <div class="form-field">
                        <label>Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="cbEmail" class="form-control-custom" placeholder="your@email.com" required>
                        <div class="cb-error" id="cbEmailError"></div>
                    </div>

                    <div class="form-group-wrapper">
                        <div class="form-field">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" id="cbCompany" class="form-control-custom" placeholder="Your company or organisation" required>
                            <div class="cb-error" id="cbCompanyError"></div>
                        </div>
                        <div class="form-field">
                            <label>Country <span class="text-danger">*</span></label>
                            <input type="text" id="cbCountry" class="form-control-custom" placeholder="Your country" required>
                            <div class="cb-error" id="cbCountryError"></div>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Design Domain <span class="text-danger">*</span></label>
                        <select id="cbDomain" class="form-control-custom" required>
                            <option value="" disabled selected>Select your domain</option>
                            <option value="ev">EV Power Electronics</option>
                            <option value="renewables">Renewable Energy Electronics</option>
                            <option value="bms">Battery Management Systems (BMS)</option>
                            <option value="power-converters">Power Converters & SMPS</option>
                            <option value="full-product">Full Product Development — End to End</option>
                            <option value="multiple">Multiple Domains</option>
                            <option value="not-sure">Not Sure Yet — Please Advise</option>
                        </select>
                        <div class="cb-error" id="cbDomainError"></div>
                    </div>

                    <div class="form-field">
                        <label>Project Description <span class="text-danger">*</span></label>
                        <textarea id="cbDescription" class="form-control-custom" rows="5" placeholder="Describe your project — power levels, topology if known, key challenges, and what you need from Circuit Brilliance" required></textarea>
                        <div class="cb-error" id="cbDescriptionError"></div>
                    </div>

                    <div class="form-group-wrapper">
                        <div class="form-field">
                            <label>Approximate Budget (Optional)</label>
                            <select id="cbBudget" class="form-control-custom">
                                <option value="" disabled selected>Select budget range</option>
                                <option value="prefer-not">Prefer not to say</option>
                                <option value="under-2k">Under €2,000</option>
                                <option value="2k-5k">€2,000 — €5,000</option>
                                <option value="5k-10k">€5,000 — €10,000</option>
                                <option value="10k-25k">€10,000 — €25,000</option>
                                <option value="over-25k">Over €25,000</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label>Timeline / Urgency (Optional)</label>
                            <select id="cbTimeline" class="form-control-custom">
                                <option value="" disabled selected>Select your timeline</option>
                                <option value="urgent">Urgent — Need help within 1–2 weeks</option>
                                <option value="1-month">Within 1 month</option>
                                <option value="1-3-months">Within 1–3 months</option>
                                <option value="flexible">Flexible — no fixed deadline</option>
                                <option value="exploring">Just exploring options for now</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="cbSubmitBtn" class="btn-form-submit">
                        <span id="cbSubmitLabel">Send My Project Brief</span>
                        <span id="cbSubmitSpinner" hidden><i class="fa-solid fa-spinner fa-spin"></i> Sending...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map section removed per user request -->

<script src="assets/js/contact-action.js"></script>
<?php include 'common/footer.php'; ?>

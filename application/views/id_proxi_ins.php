<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --msh-primary: #2563eb;
        --msh-primary-dark: #1d4ed8;
        --msh-primary-light: #eff6ff;
        --msh-slate-900: #0f172a;
        --msh-slate-800: #1e293b;
        --msh-slate-700: #334155;
        --msh-slate-600: #475569;
        --msh-slate-500: #64748b;
        --msh-slate-400: #94a3b8;
        --msh-slate-200: #e2e8f0;
        --msh-slate-100: #f1f5f9;
        --msh-slate-50: #f8fafc;
        --msh-card-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.04);
    }

    .support-wrapper {
        width: 100%;
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 66px 28px 30px 28px;
        box-sizing: border-box;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: var(--msh-slate-800);
    }

    .support-container {
        width: 100%;
        max-width: 1060px;
        margin: auto;
        margin-top: 15px;
    }

    .support-card {
        background: #ffffff;
        border-radius: 22px;
        box-shadow: var(--msh-card-shadow);
        border: 1px solid rgba(226, 232, 240, 0.95);
        overflow: hidden;
        position: relative;
    }

    .support-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2563eb 0%, #06b6d4 50%, #3b82f6 100%);
    }

    .support-card-inner {
        position: relative;
        z-index: 1;
        padding: 30px 40px;
    }

    /* Header Section */
    .support-header {
        text-align: center;
        margin-bottom: 22px;
    }

    .header-top-row {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }

    .support-logo-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid var(--msh-slate-200);
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
    }

    .support-logo-badge img {
        height: 38px;
        width: auto;
        object-fit: contain;
        display: block;
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--msh-primary-light);
        color: var(--msh-primary);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 9999px;
        border: 1px solid #bfdbfe;
    }

    .badge-pill .pulse-dot {
        width: 6px;
        height: 6px;
        background-color: var(--msh-primary);
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25);
    }

    .support-title {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: var(--msh-slate-900);
        line-height: 1.25;
        margin: 0 0 4px 0;
        background: linear-gradient(135deg, #0f172a 0%, #1e40af 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .support-subtitle {
        font-size: 14px;
        font-weight: 500;
        color: var(--msh-slate-500);
        margin: 0;
    }

    .support-subtitle strong {
        color: var(--msh-slate-700);
        font-weight: 600;
    }

    /* Divider */
    .support-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, var(--msh-slate-200) 25%, var(--msh-slate-200) 75%, transparent 100%);
        margin: 18px 0 24px;
    }

    /* Information Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .info-card {
        background: var(--msh-slate-50);
        border: 1px solid var(--msh-slate-200);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        background: #ffffffff;
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.06);
    }

    .icon-box {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border: 1px solid var(--msh-slate-200);
        color: var(--msh-primary);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        transition: all 0.2s ease;
    }

    .info-card:hover .icon-box {
        background: var(--msh-primary);
        color: #ffffff;
        border-color: var(--msh-primary);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .icon-box svg {
        width: 22px;
        height: 22px;
    }

    .info-content {
        flex: 1;
        min-width: 0;
    }

    .info-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--msh-slate-400);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-label .badge-tag {
        font-size: 9px;
        background: #e2e8f0;
        color: var(--msh-slate-700);
        padding: 2px 6px;
        border-radius: 4px;
        letter-spacing: 0;
        font-weight: 600;
    }

    .info-value {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--msh-slate-700);
        line-height: 1.5;
    }

    .contact-links {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .contact-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: #ffffff;
        border: 1px solid var(--msh-slate-200);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--msh-slate-700);
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .contact-chip:hover {
        color: var(--msh-primary);
        border-color: #93c5fd;
        background: var(--msh-primary-light);
    }

    .contact-chip .chip-label {
        color: var(--msh-slate-400);
        font-size: 11px;
        font-weight: 500;
    }

    /* Action Footer */
    .support-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding-top: 18px;
        border-top: 1px solid var(--msh-slate-100);
    }

    .footer-left {
        font-size: 12px;
        color: var(--msh-slate-400);
        line-height: 1.45;
    }

    .footer-left a {
        color: var(--msh-slate-600);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s;
    }

    .footer-left a:hover {
        color: var(--msh-primary);
    }

    .btn-website {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none !important;
        border-radius: 11px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-website:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
        color: #ffffff !important;
    }

    .btn-website svg {
        width: 15px;
        height: 15px;
        transition: transform 0.2s ease;
    }

    .btn-website:hover svg {
        transform: translateX(3px);
    }

    @media (max-width: 900px) {
        .support-wrapper {
            padding: 16px;
        }

        .support-card-inner {
            padding: 24px 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .support-footer {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="support-wrapper">
    <div class="support-container">
        <div class="support-card">
            <div class="support-card-inner">
                <!-- Header Section -->
                <div class="support-header">
                    <div class="header-top-row">
                        <div class="support-logo-badge">
                            <img src="<?php echo base_url(); ?>awedget/assets/img/mysoft-logo.png" alt="Mysoftheaven (BD) Ltd." onerror="this.onerror=null; this.src='<?php echo base_url(); ?>uploads/company_photo/logo.png';" />
                        </div>
                        <div class="badge-pill">
                            <span class="pulse-dot"></span>
                            Payroll &amp; HR Management
                        </div>
                    </div>

                    <h1 class="support-title">Islam Oxygen Limited (IOL) ERP SYSTEMS</h1>
                    <p class="support-subtitle">Developed by <strong>Mysoftheaven (BD) Ltd.</strong></p>
                </div>

                <div class="support-divider"></div>

                <!-- Information Grid -->
                <div class="info-grid">
                    <!-- Head Office Card -->
                    <div class="info-card">
                        <div class="icon-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">
                                Head Office
                                <span class="badge-tag">Bangladesh</span>
                            </div>
                            <div class="info-value">
                                P.R.Tower, 924/1, Level 8, Begum Rokeya Sarani, Shewrapara Mirpur, Dhaka-1216.
                            </div>
                        </div>
                    </div>

                    <!-- Corporate Office Card -->
                    <div class="info-card">
                        <div class="icon-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">
                                Corporate Office
                                <span class="badge-tag">USA</span>
                            </div>
                            <div class="info-value">
                                8813 NW 23 Street, Miami, FL 33172, USA.
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Helpline Card -->
                    <div class="info-card">
                        <div class="icon-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Support &amp; Helpline</div>
                            <div class="contact-links">
                                <a href="tel:+880258054029" class="contact-chip">
                                    <span class="chip-label">Phone:</span>
                                    +88 02 58054029
                                </a>
                                <a href="tel:+8801970776609" class="contact-chip">
                                    <span class="chip-label">Cell:</span>
                                    +8801970776609
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Official Web Portal Card -->
                    <div class="info-card">
                        <div class="icon-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Official Website</div>
                            <div class="contact-links">
                                <a href="https://www.mysoftheaven.com" target="_blank" rel="noopener noreferrer" class="contact-chip">
                                    www.mysoftheaven.com
                                    <svg style="width: 12px; height: 12px; margin-left: 2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Company Branding & Quick Action -->
                <div class="support-footer">
                    <div class="footer-left text-center">
                        <div>&copy; <?php echo date('Y'); ?> <a href="https://www.mysoftheaven.com" target="_blank">Mysoftheaven (BD) Ltd. All rights reserved.</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

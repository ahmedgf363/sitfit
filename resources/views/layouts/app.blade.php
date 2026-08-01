<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- Font Awesome Icons Library -->
    <link rel="stylesheet"
       href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Page CSS -->
    @yield('css')

    <!-- css connection navbar -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <!-- css connection footer -->
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <title>@yield('title')</title>
</head>

<body>

<header class="navbar-space">
    @include('layouts.navbar')
</header>

<main class="content">
    @yield('content')
</main>

@include('layouts.footer')

<!-- Privacy Policy Modal -->
<div id="privacy-modal" class="sitfit-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="privacy-modal-title">
    <div class="sitfit-modal-container">

        <div class="sitfit-modal-header">
            <h3 id="privacy-modal-title" class="sitfit-modal-title">Privacy Policy</h3>
            <button type="button" class="sitfit-modal-close" data-modal-close aria-label="Close modal">&times;</button>
        </div>

        <div class="sitfit-modal-body">
            <p>
                At SitFit, we respect your privacy and are committed to protecting your personal data.
                This Privacy Policy explains how we collect, use, store, and protect your information whenever you use our website or purchase our products.
            </p>

            <h4>1. Information We Collect</h4>
            <p>
                We collect information you provide when creating an account, placing an order,
                contacting customer support, or subscribing to updates. This may include your
                name, email address, phone number, shipping address, and payment details.
            </p>

            <h4>2. How We Use Your Data</h4>
            <p>
                Your information is used to process orders, improve our services, personalize your
                shopping experience, communicate order updates, and provide customer support.
            </p>

            <h4>3. Cookies</h4>
            <p>
                We use cookies to remember your preferences, improve website performance,
                and analyze visitor activity.
            </p>

            <h4>4. Data Security</h4>
            <p>
                We implement appropriate security measures to protect your personal information
                from unauthorized access, alteration, disclosure, or misuse.
            </p>

            <h4>5. Third-Party Services</h4>
            <p>
                We may work with trusted payment providers, shipping companies, and analytics
                services to improve your shopping experience.
            </p>

            <h4>6. Your Rights</h4>
            <p>
                You may request access to, correction of, or deletion of your personal information
                whenever applicable.
            </p>

            <h4>7. Policy Updates</h4>
            <p>
                SitFit may update this Privacy Policy from time to time. Any updates will be published on this page.
            </p>
        </div>

        <div class="sitfit-modal-footer">
            <button type="button" class="sitfit-btn-close" data-modal-close>
                I Understand
            </button>
        </div>

    </div>
</div>


<!-- Terms & Conditions Modal -->
<div id="terms-modal" class="sitfit-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="terms-modal-title">
    <div class="sitfit-modal-container">
        <div class="sitfit-modal-header">
            <h3 id="terms-modal-title" class="sitfit-modal-title">Terms & Conditions</h3>
            <button type="button" class="sitfit-modal-close" data-modal-close aria-label="Close modal">&times;</button>
        </div>
        <div class="sitfit-modal-body">
    <p>
        Welcome to SitFit. By accessing or using our website, you agree to comply with
        these Terms & Conditions. Please read them carefully before creating an account
        or placing an order.
    </p>

    <h4>1. Use of Service</h4>
    <p>
        SitFit provides ergonomic office furniture and related services for personal and
        business use. You agree to use our website only for lawful purposes and in a way
        that does not interfere with the experience of other users.
    </p>

    <h4>2. User Accounts</h4>
    <p>
        You are responsible for maintaining the confidentiality of your account
        information and password. Any activity performed using your account is your
        responsibility.
    </p>

    <h4>3. Orders & Payments</h4>
    <p>
        All prices displayed on the website are subject to change without prior notice.
        Orders are confirmed only after successful payment authorization and availability
        of the selected products.
    </p>

    <h4>4. Shipping & Delivery</h4>
    <p>
        Delivery times may vary depending on your location and product availability.
        SitFit is committed to processing and shipping orders as efficiently as possible.
    </p>

    <h4>5. Returns & Refunds</h4>
    <p>
        Returns and refunds are handled according to our return policy. Products must be
        returned in acceptable condition and within the specified return period whenever
        applicable.
    </p>

    <h4>6. Limitation of Liability</h4>
    <p>
        SitFit is not responsible for indirect or incidental damages resulting from the
        misuse of our products or interruptions in website availability.
    </p>

    <h4>7. Changes to These Terms</h4>
    <p>
        We reserve the right to update these Terms & Conditions at any time. Continued
        use of the website after changes are published constitutes acceptance of the
        revised terms.
    </p>
  </div>
        <div class="sitfit-modal-footer">
            <button type="button" class="sitfit-btn-close" data-modal-close>I Agree</button>
        </div>
    </div>
</div>

{{-- Chat Widget --}}

<button class="chat-btn">
    <i class="fa-solid fa-comments"></i>
</button>

<div class="chat-box">

    <div class="chat-header">
        Support
    </div>

    {{-- أضفنا ID للـ body --}}
    <div class="chat-body" id="chat-body">
        <div class="message bot-message">
            <p>Hi! How can we help you?</p>
        </div>
    </div>

    {{-- أضفنا ID للـ Form والـ Input --}}
    <form id="chat-form">
        @csrf
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Type your message..." required autocomplete="off">

            <button class="send-btn" type="submit" id="send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>

<script src="{{ asset('js/chat-widget.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Select open triggers and close triggers
    const privacyTriggers = document.querySelectorAll('[data-open-privacy]');
    const termsTriggers = document.querySelectorAll('[data-open-terms]');
    const closeButtons = document.querySelectorAll('[data-modal-close]');

    const privacyModal = document.getElementById('privacy-modal');
    const termsModal = document.getElementById('terms-modal');

    function openModal(modal) {
    if (!modal) return;

    modal.classList.add('is-active');
    modal.setAttribute('aria-hidden', 'false');

    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
}

    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.sitfit-modal-overlay.is-active')) {
            document.body.style.overflow = '';
        }
    }

    function closeAllModals() {
        document.querySelectorAll('.sitfit-modal-overlay.is-active').forEach(modal => {
            closeModal(modal);
        });
    }

    // Open Privacy Modal
    privacyTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(privacyModal);
        });
    });

    // Open Terms Modal
    termsTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(termsModal);
        });
    });

    // Close buttons
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.sitfit-modal-overlay');
            closeModal(modal);
        });
    });

    // Close when clicking outside
    document.querySelectorAll('.sitfit-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeModal(overlay);
            }
        });
    });

    // Close with ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllModals();
        }
    });
});
</script>

<script src="{{ asset('js/chat-widget.js') }}"></script>
</body>

</html>
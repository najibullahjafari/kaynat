document.addEventListener('DOMContentLoaded', function () {
    // Preloader
    const preloader = document.querySelector('.preloader');

    window.addEventListener('load', function () {
        preloader.classList.add('fade-out');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    });

    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuIcon = document.querySelector('.menu-icon');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    mobileMenuToggle.addEventListener('click', function () {
        mobileMenuIcon.classList.toggle('active');
        navbarCollapse.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
    });

    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (navbarCollapse.classList.contains('active')) {
                mobileMenuIcon.classList.remove('active');
                navbarCollapse.classList.remove('active');
                document.body.classList.remove('no-scroll');
            }
        });
    });

    // Sticky Navigation
    const header = document.querySelector('.nav-fixed-top');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerHeight = document.querySelector('.nav-fixed-top').offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Back to Top Button
    const backToTopButton = document.getElementById('back-to-top');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('active');
        } else {
            backToTopButton.classList.remove('active');
        }
    });

    // Tab System
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked button and corresponding pane
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Testimonial Slider
    const testimonialSlides = document.querySelectorAll('.testimonial-slide');
    const testimonialDots = document.querySelectorAll('.dot');
    const prevButton = document.querySelector('.testimonial-prev');
    const nextButton = document.querySelector('.testimonial-next');
    let currentSlide = 0;

    function showSlide(index) {
        testimonialSlides.forEach(slide => slide.classList.remove('active'));
        testimonialDots.forEach(dot => dot.classList.remove('active'));

        testimonialSlides[index].classList.add('active');
        testimonialDots[index].classList.add('active');
        currentSlide = index;
    }

    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });

    prevButton.addEventListener('click', function () {
        let newIndex = (currentSlide - 1 + testimonialSlides.length) % testimonialSlides.length;
        showSlide(newIndex);
    });

    nextButton.addEventListener('click', function () {
        let newIndex = (currentSlide + 1) % testimonialSlides.length;
        showSlide(newIndex);
    });

    // Auto-rotate testimonials
    setInterval(() => {
        let newIndex = (currentSlide + 1) % testimonialSlides.length;
        showSlide(newIndex);
    }, 5000);

    // Animate stats counters
    const statNumbers = document.querySelectorAll('.stat-number');

    function animateStats() {
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-count'));
            const suffix = stat.textContent.includes('%') ? '%' : '';
            let count = 0;
            const duration = 2000;
            const increment = target / (duration / 16);

            const updateCount = () => {
                count += increment;
                if (count < target) {
                    stat.textContent = Math.floor(count) + suffix;
                    requestAnimationFrame(updateCount);
                } else {
                    stat.textContent = target + suffix;
                }
            };

            updateCount();
        });
    }

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');

                if (entry.target.classList.contains('stats-section')) {
                    animateStats();
                }

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-aos]').forEach(section => {
        observer.observe(section);
    });

    // Form floating labels
    const formGroups = document.querySelectorAll('.form-group');

    formGroups.forEach(group => {
        const input = group.querySelector('input, textarea, select');
        const label = group.querySelector('label');

        if (input.value) {
            label.classList.add('active');
        }

        input.addEventListener('focus', () => {
            label.classList.add('active');
        });

        input.addEventListener('blur', () => {
            if (!input.value) {
                label.classList.remove('active');
            }
        });
    });

    // Contact form submission

    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let form = this;
        let data = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: data
        })
            .then(res => res.json())
            .then(res => {
                // Remove any previous alerts
                let oldAlert = form.parentElement.querySelector('.alert');
                if (oldAlert) oldAlert.remove();

                if (res.success) {
                    // Show success message above the form
                    let successDiv = document.createElement('div');
                    successDiv.className = 'alert alert-success';
                    successDiv.innerText = res.message;
                    form.parentElement.insertBefore(successDiv, form);
                    form.reset();
                } else if (res.errors) {
                    // Show error messages above the form
                    let errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger';
                    errorDiv.innerHTML = '<ul class="mb-0">' +
                        Object.values(res.errors).map(msgArr => `<li>${msgArr[0]}</li>`).join('') +
                        '</ul>';
                    form.parentElement.insertBefore(errorDiv, form);
                }
            });
    });
});
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ $settings['site_name'] ?? 'Kaynat | Precision in Motion - Advanced GPS Tracking Solutions' }}</title>
    <meta name="description"
        content="{{ $settings['meta_description'] ?? 'Kaynat provides cutting-edge GPS tracking solutions for fleet management, personal tracking, and asset monitoring with precision and reliability.' }}">
    <meta name="keywords"
        content="{{ $settings['meta_keywords'] ?? 'GPS tracking, fleet management, vehicle tracking, asset tracking, real-time monitoring, GPS technology, Kaynat, Precision in Motion' }}">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Kaynat Team' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Favicon --}}
    <link rel="icon" type="image/png"
        href="{{ $settings['site_favicon'] ? asset('storage/' . $settings['site_favicon']) : asset('img/favicon.png') }}">
    {{-- Logo --}}
    <link rel="stylesheet" href="css/new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Orbitron:wght@500;600;700&display=swap"
        rel="stylesheet">

</head>

<body id="body">
    <!-- Preloader -->
    <div class="preloader">
        <div class="satellite-loader">
            <div class="satellite"></div>
            <div class="orbit"></div>
        </div>
    </div>

    <!-- Fixed Navigation -->
    <header id="nav-fixed-top" class="nav-fixed-top navbar">
        <div class="container">
            <div class="navbar-header">
                {{-- Logo --}}
                <a class="navbar-brand" href="#home">
                    <button type="button" class="navbar-toggle" id="mobile-menu-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <div class="menu-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                    <div class="logo-container">
                        <img class="logo-img" alt="{{ $settings['site_name'] ?? 'Kaynat' }}"
                            src="{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('images/kaynat-log.png') }}">
                        <div class="logo-text">
                            <span class="logo-main">{{ $settings['site_name'] ?? 'KAYNAT' }}</span>
                            <span class="logo-sub">{{ $settings['site_tagline'] ?? 'PRECISION IN MOTION' }}</span>
                        </div>
                    </div>
                </a>


            </div>
            <nav class="navbar-collapse" id="main-nav">
                <ul id="nav" class="nav navbar-nav">
                    <li><a href="#home" class="nav-link"><span>Home</span></a></li>
                    <li><a href="#solutions" class="nav-link"><span>Solutions</span></a></li>
                    <li><a href="#features" class="nav-link"><span>Features</span></a></li>
                    <li><a href="#technology" class="nav-link"><span>Technology</span></a></li>
                    <li><a href="#industries" class="nav-link"><span>Industries</span></a></li>
                    <li><a href="#team" class="nav-link"><span>Team</span></a></li>
                    <li><a href="#about" class="nav-link"><span>About</span></a></li>
                    <li><a href="#contact" class="nav-link"><span>Contact</span></a></li>
                    {{-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" id="lang-dropdown">
                            <i class="fas fa-globe"></i> EN <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">English</a></li>
                            <li><a href="#">فارسی</a></li>
                            <li><a href="#">پښتو</a></li>
                        </ul>
                    </li> --}}
                </ul>
                <div class="nav-cta">
                    <a href="#contact" class="btn btn-primary">Get a Demo</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                    {{$settings['site_tagline'] ?? 'Precision in Motion'}}
                </h1>

                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">{{ $settings['site_description'] ??
                    'Advanced
                    GPS solutions for fleet
                    management, asset tracking, and personal safety'
                    }}</p>
                <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
                    <a href="#solutions" class="btn btn-primary">Explore Solutions</a>
                    <a href="#contact" class="btn btn-secondary">Contact Sales</a>
                </div>
            </div>
        </div>
        <div class="hero-map">
            <div class="map-point" style="top: 20%; left: 30%;"></div>
            <div class="map-point" style="top: 40%; left: 60%;"></div>
            <div class="map-point" style="top: 70%; left: 45%;"></div>
            <div class="map-point" style="top: 50%; left: 20%;"></div>
            <div class="map-point" style="top: 30%; left: 70%;"></div>
        </div>
        <div class="scroll-down">
            <a href="#solutions">
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
                <div class="arrows">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="solutions-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Our Tracking Solutions</h2>
                <p>Tailored GPS tracking solutions for every need</p>
            </div>
            <div class="solutions-grid">
                @foreach($solutions as $solution)
                <div class="solution-card" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
                    <div class="card-icon" style="margin-bottom: 0;">
                        @if($solution->icon && Str::startsWith($solution->icon, 'fa'))
                        <i class="{{ $solution->icon }}"></i>
                        @elseif($solution->icon)
                        <img src="{{ Storage::url($solution->icon) }}" alt="{{ $solution->title }}">
                        @else
                        <i class="fas fa-cube"></i>
                        @endif
                    </div>

                    <h3 style="margin-top: 10px;">{{ $solution->title }}</h3>
                    <p>{{ $solution->description }}</p>
                    {{-- <a href="{{ route('solution.details', $solution->slug ?? '#') }}" class="btn-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a> --}}
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Powerful Features</h2>
                <p>Everything you need for complete visibility and control</p>
            </div>
            <div class="features-content">
                <div class="features-image" data-aos="fade-right">
                    <div class="dashboard-mockup">
                        <div class="screen">
                            <div class="map-view"
                                style="background: url('{{ $settings['site_feature_image'] ? asset('storage/' . $settings['site_feature_image']) : asset('images/gps.jpg') }}') center center/cover no-repeat;">
                                <div class="vehicle-marker"></div>
                                <div class="route-line"></div>
                            </div>
                            <div class="stats-panel">
                                <div class="stat-item">
                                    <div class="stat-value">14</div>
                                    <div class="stat-label">Active Vehicles</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">87%</div>
                                    <div class="stat-label">On Time</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">2.4</div>
                                    <div class="stat-label">Avg. Stops/Hr</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="features-list" data-aos="fade-left">
                    @foreach($features as $feature)
                    <div class="feature-item">
                        <div class="feature-icon">
                            @if($feature->icon && \Illuminate\Support\Str::startsWith($feature->icon, 'fa'))
                            <i class="{{ $feature->icon }}"></i>
                            @elseif($feature->icon)
                            <img src="{{ asset('storage/features/' . basename($feature->icon)) }}"
                                alt="{{ $feature->title }}">
                            @else
                            <i class="fas fa-cog"></i>
                            @endif
                        </div>
                        <div class="feature-text">
                            <h4>{{ $feature->title }}</h4>
                            <p>{{ $feature->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section id="technology" class="technology-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Our Technology</h2>
                <p>Innovative solutions built on cutting-edge technology</p>
            </div>
            <div class="tech-tabs" data-aos="fade-up">
                <div class="tab-buttons">
                    @php
                    $types = $technologies->pluck('type')->unique()->values();
                    @endphp
                    @foreach($types as $i => $type)
                    <button class="tab-btn {{ $i === 0 ? ' active' : '' }}" data-tab="{{ strtolower($type) }}">
                        {{ ucfirst($type) }}
                    </button>
                    @endforeach
                </div>
                <div class="tab-content">
                    @foreach($types as $i => $type)
                    <div class="tab-pane{{ $i === 0 ? ' active' : '' }}" id="{{ strtolower($type) }}">
                        @foreach($technologies->where('type', $type) as $tech)
                        <div class="tech-content">
                            <div class="tech-image">
                                <img src="{{ $tech->image ? asset('storage/' . $tech->image) : 'img/device-mockup.png' }}"
                                    alt="{{ $tech->name }}" class="device-mockup">
                                @if(strtolower($type) === 'hardware')
                                <div class="signal-animation"></div>
                                @elseif(strtolower($type) === 'connectivity')
                                <div class="network-animation"></div>
                                @endif
                            </div>
                            <div class="tech-text">
                                <h3>{{ $tech->name }}</h3>
                                <p>{{ $tech->description }}</p>
                                @if(is_array($tech->specifications) && count($tech->specifications))
                                <ul class="tech-features">
                                    @foreach($tech->specifications as $spec)
                                    <li><i class="fas fa-check-circle"></i> {{ $spec }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Industries Section -->
    <section id="industries" class="industries-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Industries We Serve</h2>
                <p>Custom solutions for your specific industry needs</p>
            </div>
            <div class="industries-grid">
                @foreach($industries as $i => $industry)
                <div class="industry-card" data-aos="fade-up" data-aos-delay="{{ 100 + $i * 50 }}">
                    <div class="industry-icon">
                        @if($industry->icon && \Illuminate\Support\Str::startsWith($industry->icon, 'fa'))
                        <i class="{{ $industry->icon }}"></i>
                        @elseif($industry->icon)
                        <img src="{{ asset('storage/' . $industry->image) }}" alt="{{ $industry->name }}">
                        @else
                        <i class="fas fa-industry"></i>
                        @endif
                    </div>
                    <h3>{{ $industry->name }}</h3>
                    <p>{{ $industry->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section bg-gray-light py-20">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Meet Our Team</h2>
                <p>Passionate professionals driving innovation and excellence</p>
            </div>
            <div class="team-grid">
                @foreach($teamMembers as $member)
                <div class="team-card" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 80 }}">
                    <div class="team-avatar">
                        @if($member->avatar)
                        <img src="{{ Storage::url($member->avatar) }}" alt="{{ $member->name }}">
                        @else
                        <div class="team-avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                    </div>
                    <h3 class="team-name">{{ $member->name }}</h3>
                    <div class="team-position">{{ $member->position }}</div>
                    <p class="team-bio">{{ Str::limit($member->bio, 90) }}</p>
                    @if($member->social_links && is_array($member->social_links) && count($member->social_links))
                    <div class="team-social">
                        @foreach($member->social_links as $link)
                        <a href="{{ $link }}" target="_blank" class="team-social-link">
                            @if(Str::contains($link, 'twitter'))
                            <i class="fab fa-twitter"></i>
                            @elseif(Str::contains($link, 'linkedin'))
                            <i class="fab fa-linkedin"></i>
                            @elseif(Str::contains($link, 'facebook'))
                            <i class="fab fa-facebook"></i>
                            @elseif(Str::contains($link, 'github'))
                            <i class="fab fa-github"></i>
                            @else
                            <i class="fas fa-link"></i>
                            @endif
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number" data-count="12500">0</div>
                    <div class="stat-label">Devices Deployed</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number" data-count="98.7">0</div>
                    <div class="stat-label">Uptime Percentage</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number" data-count="42">0</div>
                    <div class="stat-label">Countries Covered</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-number" data-count="24">0</div>
                    <div class="stat-label">24/7 Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>What Our Clients Say</h2>
                <p>Trusted by industry leaders worldwide</p>
            </div>
            <div class="testimonials-slider" data-aos="fade-up">
                @foreach($testimonials as $i => $testimonial)
                <div class="testimonial-slide{{ $i === 0 ? ' active' : '' }}">
                    <div class="testimonial-content">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>{{ $testimonial->content }}</p>
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="{{ $testimonial->avatar ? asset('storage/' . $testimonial->avatar) : asset('img/avatar-default.png') }}"
                                    alt="{{ $testimonial->author_name }}">
                            </div>
                            <div class="author-info">
                                <h4>{{ $testimonial->author_name }}</h4>
                                <p>
                                    {{ $testimonial->author_position }}
                                    @if($testimonial->author_company)
                                    , {{ $testimonial->author_company }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="testimonial-nav">
                    <button class="testimonial-prev"><i class="fas fa-chevron-left"></i></button>
                    <div class="testimonial-dots">
                        @foreach($testimonials as $i => $testimonial)
                        <span class="dot{{ $i === 0 ? ' active' : '' }}"></span>
                        @endforeach
                    </div>
                    <button class="testimonial-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text" data-aos="fade-right">
                    <div class="section-header">
                        <h2>About Kaynat</h2>
                        <p>Precision in Motion</p>
                    </div>
                    <p>{{ $settings['site_about_kaynat'] ?? "Founded in 2015, Kaynat has grown to become a leading
                        provider of GPS tracking solutions in the region. Our mission is to deliver precise, reliable
                        tracking technology that helps businesses optimize their operations and individuals stay
                        connected. With our headquarters in Kabul and regional offices across Afghanistan, we combine
                        global technology standards with local market understanding to provide solutions tailored to our
                        clients' needs." }}</p>
                    <div class="about-features">
                        <div class="feature-item">
                            <i class="fas fa-bullseye"></i>
                            <h4>Our Vision</h4>
                            <p>{{ $settings['site_kaynat_vision'] ?? 'To be the most trusted provider of location
                                intelligence solutions in our region.' }}</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-hand-holding-heart"></i>
                            <h4>Our Values</h4>
                            <p>{{ $settings['site_kaynat_values'] ?? 'Innovation, Reliability, Customer Focus, and
                                Integrity guide everything we do.' }}</p>
                        </div>
                    </div>
                </div>
                <div class="about-image" data-aos="fade-left">
                    <div class="image-container">
                        <img src="{{ !empty($settings['site_about_kaynat_image']) ? asset('storage/' . $settings['site_about_kaynat_image']) : asset('images/logo/kaynat-log.png') }}"
                            alt="Kaynat Team">
                        <div class="experience-badge">
                            <div class="years">{{ $settings['site_year_experience'] ?? '8+' }}</div>
                            <div class="label">Years Experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Ready to Transform Your Operations?</h2>
                <p>Get started with Kaynat's GPS tracking solutions today and experience the difference precision
                    tracking can make.</p>
                <div class="cta-buttons">
                    <a href="#contact" class="btn btn-primary">Request a Demo</a>
                    <a href="tel:+93700000000" class="btn btn-secondary"><i class="fas fa-phone"></i> Call Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Contact Us</h2>
                <p>Get in touch with our team</p>

            </div>
            <div class="contact-content">
                <div class="contact-info" data-aos="fade-right">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-text">
                            <h4>Headquarters</h4>
                            <p>{{ $settings['company_address'] ?? 'Kabul, Afghanistan' }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-text">
                            <h4>Phone</h4>
                            <p>{{ $settings['contact_phone'] ?? '+93 700 000 000' }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <h4>Email</h4>
                            <p>{{ $settings['contact_email'] ?? 'info@kaynatgps.af' }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-text">
                            <h4>Working Hours</h4>
                            <p>{{ $settings['business_hours'] ?? 'Saturday - Thursday: 8:00 - 17:00' }}</p>
                        </div>
                    </div>
                    <div class="social-links">
                        @if(!empty($settings['facebook_url']))<a href="{{ $settings['facebook_url'] }}"><i
                                class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($settings['twitter_url']))<a href="{{ $settings['twitter_url'] }}"><i
                                class="fab fa-twitter"></i></a>@endif
                        @if(!empty($settings['linkedin_url']))<a href="{{ $settings['linkedin_url'] }}"><i
                                class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($settings['instagram_url']))<a href="{{ $settings['instagram_url'] }}"><i
                                class="fab fa-instagram"></i></a>@endif
                        @if(!empty($settings['youtube_url']))<a href="{{ $settings['youtube_url'] }}"><i
                                class="fab fa-youtube"></i></a>@endif
                    </div>
                </div>
                <div class="contact-form" data-aos="fade-left">
                    @if(session('success'))
                    <div class=" alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                    <div class=" alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="name" name="name" required>
                            <label for="name">Your Name</label>
                            @error('records.name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone">
                            <label for="phone">Phone Number</label>
                        </div>
                        <div class="form-group">
                            <select id="interest" name="interest" required>
                                <option value="" disabled selected></option>
                                <option value="fleet">Fleet Management</option>
                                <option value="asset">Asset Tracking</option>
                                <option value="personal">Personal Safety</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="interest">I'm interested in</label>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" rows="4" required></textarea>
                            <label for="message">Your Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col footer-about">
                    <div class="footer-logo">
                        <img class="logo-img-big" alt="{{ $settings['site_name'] ?? 'Kaynat' }}"
                            src="{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('images/kaynat-log.png') }}">
                        <div class="logo-text">
                            <span class="logo-main">{{ $settings['site_name'] ?? 'KAYNAT' }}</span>
                            <span class="logo-sub">{{ $settings['site_tagline'] ?? 'PRECISION IN MOTION' }}</span>
                        </div>
                    </div>
                    <p>{{ $settings['site_description'] ??
                        'Advanced
                        GPS solutions for fleet
                        management, asset tracking, and personal safety'
                        }}</p>
                    <div class="footer-social">
                        @if(!empty($settings['facebook_url']))<a href="{{ $settings['facebook_url'] }}"><i
                                class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($settings['twitter_url']))<a href="{{ $settings['twitter_url'] }}"><i
                                class="fab fa-twitter"></i></a>@endif
                        @if(!empty($settings['linkedin_url']))<a href="{{ $settings['linkedin_url'] }}"><i
                                class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($settings['instagram_url']))<a href="{{ $settings['instagram_url'] }}"><i
                                class="fab fa-instagram"></i></a>@endif
                        @if(!empty($settings['youtube_url']))<a href="{{ $settings['youtube_url'] }}"><i
                                class="fab fa-youtube"></i></a>@endif
                    </div>
                </div>
                <div class="footer-col footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#solutions">Solutions</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#technology">Technology</a></li>
                        <li><a href="#industries">Industries</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col footer-solutions">
                    <h3>Solutions</h3>
                    <ul>
                        @foreach($solutions as $solution)
                        <li>
                            <a href="#solutions">{{ $solution->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-col footer-contact">
                    <h3>Contact Info</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> {{ $settings['company_address'] ?? 'Kabul,
                            Afghanistan' }}</li>
                        <li><i class="fas fa-phone-alt"></i> {{ $settings['contact_phone'] ?? '+93 700 000 000' }}</li>
                        <li><i class="fas fa-envelope"></i> {{ $settings['contact_email'] ?? 'info@kaynat.com' }}</li>
                    </ul>
                    {{-- <div class="footer-newsletter">
                        <h4>Subscribe to Newsletter</h4>
                        <form method="POST" action="{{ route('newsletter.subscribe') }}">
                            @csrf
                            <input type="email" name="email" placeholder="Your Email" required>
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div> --}}
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Kaynat' }}. All Rights Reserved.
                </div>

                <div class="footer-legal">
                    Powered by <a href="https://www.kic.af" target="_blank">Kabul Innovation Center</a>
                    {{-- <a href="#">{{ $settings['privacy_policy_label'] ?? 'Privacy Policy' }}</a>
                    <a href="#">{{ $settings['terms_label'] ?? 'Terms of Service' }}</a> --}}
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#home" id="back-to-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>

</html>
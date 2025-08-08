@props(['banners' => []])

@once
    @push('styles')
        <style>
            .banner {
                position: relative;
                height: 600px;
                overflow: hidden;
            }

            .banner-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                clip-path: polygon(0 0, 100% 0, 100% calc(100% - 60px), 50% 100%, 0 calc(100% - 60px));
            }

            .banner-content {
                position: absolute;
                top: 35%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 80%;
                max-width: 800px;
                z-index: 10;
            }

            .banner-title {
                color: #4c4c4c;
            }

            .banner-button {
                background-color: #369694;
                border-bottom: 4px solid #297371;
                box-shadow: 0 4px 8px rgba(54, 150, 148, 0.3);
                transition: all 0.3s ease;
            }

            .banner-button:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 12px rgba(54, 150, 148, 0.4);
            }

            .banner-button:active {
                transform: translateY(-1px);
            }

            /* Icon circle styles */
            .icon-circle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                background-color: rgba(255, 255, 255, 0.25);
                border-radius: 50%;
                margin-left: 10px;
                transition: all 0.3s ease;
            }

            .banner-button:hover .icon-circle {
                background-color: rgba(26, 26, 26, 0.4);
                transform: translateX(3px);
            }
            
            /* Hide carousel controls but keep functionality */
            .carousel-control-prev,
            .carousel-control-next,
            .carousel-indicators {
                display: none;
            }
            
            /* Ensure smooth transition */
            .carousel-inner {
                height: 100%;
            }
            
            .carousel-item {
                height: 100%;
            }

            /* Responsive styles */
            @media (max-width: 1200px) {
                .banner {
                    height: 500px;
                }
            }

            @media (max-width: 992px) {
                .banner {
                    height: 450px;
                }

                .icon-circle {
                    width: 22px;
                    height: 22px;
                }
            }

            @media (max-width: 768px) {
                .banner {
                    height: 400px;
                }
                
                .banner-image {
                    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 40px), 50% 100%, 0 calc(100% - 40px));
                }

                .banner-content {
                    top: 45%;
                }

                .icon-circle {
                    width: 20px;
                    height: 20px;
                    margin-left: 8px;
                }
            }

            @media (max-width: 576px) {
                .banner {
                    height: 350px;
                }
                
                .banner-image {
                    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 30px), 50% 100%, 0 calc(100% - 30px));
                }

                .banner-content {
                    top: 50%;
                }

                .icon-circle {
                    width: 18px;
                    height: 18px;
                    margin-left: 6px;
                }
            }

            @media (max-width: 480px) {
                .banner {
                    height: 300px;
                }

                .icon-circle {
                    width: 16px;
                    height: 16px;
                    margin-left: 5px;
                }
            }
        </style>
    @endpush
@endonce

<section id="banner">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @if(count($banners) > 0)
                @foreach($banners as $index => $banner)
                    @if($banner->status)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="banner text-center text-white">
                                <img src="{{ Storage::url($banner->image) }}" alt="Banner Image" class="banner-image">
                                <div class="banner-content">
                                    <h2 class="banner-title display-4 fw-bold mb-2">{{ __('EASY PEASY HOME LOANS') }}</h2>
                                    <p class="banner-description fs-4 text-dark mt-4">{{ __('Whether you\'re buying a home or refinancing a loan, we\'re excited to guide you every step of the way!') }}</p>
                                    <div class="mt-5 d-flex justify-content-evenly">
                                        <a href="https://fociloans.my1003app.com/1856201/inquiry" target="_blank"
                                            class="text-decoration-none banner-button rounded-pill fw-semibold py-2 px-3 fs-6 text-white">Get a quote <span
                                                class="icon-circle"><i class="fas fa-arrow-right fs-6"></i></span></a>
                                        <a href="https://fociloans.my1003app.com/1856201/register" target="_blank" 
                                            class="text-decoration-none banner-button rounded-pill fw-semibold py-2 px-3 fs-6 text-white">Apply Here <span
                                                class="icon-circle"><i class="fas fa-arrow-right fs-6"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="carousel-item active">
                    <div class="banner text-center text-white">
                        <img src="{{ asset('assets/images/banner/banner-image.webp') }}" alt="Banner Image" class="banner-image">
                        <div class="banner-content">
                            <h2 class="banner-title display-4 fw-bold mb-2">{{ __('EASY PEASY HOME LOANS') }}</h2>
                            <p class="banner-description fs-4 text-dark mt-4">{{ __('Whether you\'re buying a home or refinancing a loan, we\'re excited to guide you every step of the way!') }}</p>
                            <div class="mt-5 d-flex justify-content-evenly">
                                <a href="https://fociloans.my1003app.com/1856201/inquiry" target="_blank"
                                    class="text-decoration-none banner-button rounded-pill fw-semibold py-2 px-3 fs-6 text-white">Get a quote <span
                                        class="icon-circle"><i class="fas fa-arrow-right fs-6"></i></span></a>
                                <a href="https://fociloans.my1003app.com/1856201/register" target="_blank" 
                                    class="text-decoration-none banner-button rounded-pill fw-semibold py-2 px-3 fs-6 text-white">Apply Here <span
                                        class="icon-circle"><i class="fas fa-arrow-right fs-6"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Controls are hidden via CSS but still functional -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the banner carousel with custom options
            const bannerCarousel = new bootstrap.Carousel(document.getElementById('bannerCarousel'), {
                interval: 5000,  // Change slides every 5 seconds
                wrap: true,      // Loop back to the first slide
                keyboard: false, // Disable keyboard controls
                pause: false,    // Don't pause on hover
                touch: false     // Disable swiping on touch devices
            });
        });
    </script>
    @endpush
@endonce
@php
    // Exclude internal dashboards (Admin, Doctor, Hospital, Pharma)
    $isDashboardRoute = request()->is('admin*') || request()->is('doctor*') || request()->is('hospital*') || request()->is('pharma*');
@endphp

@if(!$isDashboardRoute && isset($popupAds) && $popupAds->count() > 0)
<!-- Multi-Ad Popup Carousel Modal Overlay -->
<div id="singleAdPopup" class="adware-overlay" style="display: flex; opacity: 0; transition: opacity 0.35s ease-in-out;">
    <div class="adware-dialog position-relative rounded-4 shadow-lg overflow-hidden bg-white" 
         style="max-width: 560px; width: 92vw; margin: auto; transform: scale(0.9); transition: transform 0.35s ease-in-out;">
        
        <!-- Floating Close Button (Only visible on last ad) -->
        <button type="button" id="topAdCloseBtn" class="adware-close-btn" onclick="closePopupAd()" title="Close Advertisement" 
                style="{{ $popupAds->count() == 1 ? 'display: flex;' : 'display: none;' }}">&times;</button>

        <!-- Floating Counter Badge (Shown when > 1 ads) -->
        @if($popupAds->count() > 1)
            <span class="position-absolute top-0 start-0 m-3 badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-1.5 small fw-semibold" 
                  style="z-index: 12; backdrop-filter: blur(4px);" id="adCounterBadge">
                1 of {{ $popupAds->count() }}
            </span>
        @endif

        <!-- Carousel Content Area -->
        <div class="position-relative bg-light overflow-hidden">
            <!-- Next & Prev Navigation Arrows (Shown when > 1 ads) -->
            @if($popupAds->count() > 1)
                <button type="button" class="ad-nav-btn ad-nav-prev" onclick="prevAdSlide()" title="Previous Ad">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="ad-nav-btn ad-nav-next" onclick="nextAdSlide()" title="Next Ad">
                    <i class="fas fa-chevron-right"></i>
                </button>
            @endif

            <!-- Slides List -->
            <div id="adSlidesContainer">
                @foreach($popupAds as $index => $ad)
                    <div class="ad-slide-item {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}" style="{{ $index === 0 ? 'display: block;' : 'display: none;' }}">
                        
                        <!-- Horizontal Scrolling Title Marquee -->
                        @if($ad->title)
                            <div class="ad-marquee-container border-bottom">
                                <div class="ad-marquee-track">
                                    <span class="me-4"><i class="fas fa-bullhorn text-warning me-1.5"></i> {{ $ad->title }}</span>
                                    <span class="me-4"><i class="fas fa-sparkles text-success me-1.5"></i> {{ $ad->title }}</span>
                                    <span class="me-4"><i class="fas fa-star text-warning me-1.5"></i> {{ $ad->title }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="text-center bg-white p-2">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" class="d-block text-decoration-none">
                                    <img src="{{ asset('storage/' . $ad->image_path) }}" 
                                         class="img-fluid w-100 rounded-3" 
                                         alt="{{ $ad->title ?? 'Advertisement' }}"
                                         style="max-height: 58vh; object-fit: contain;">
                                </a>
                            @else
                                <img src="{{ asset('storage/' . $ad->image_path) }}" 
                                     class="img-fluid w-100 rounded-3" 
                                     alt="{{ $ad->title ?? 'Advertisement' }}"
                                     style="max-height: 58vh; object-fit: contain;">
                            @endif
                        </div>

                        <!-- Slide Action Footer -->
                        <div class="p-3 bg-white border-top d-flex align-items-center justify-content-between px-4">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i> Visit Offer
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if($index < $popupAds->count() - 1)
                                <button type="button" class="btn btn-outline-success rounded-pill px-3 py-1 fw-bold btn-sm ms-auto" onclick="nextAdSlide()">
                                    Next Ad <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-danger rounded-pill px-4 py-1.5 fw-bold btn-sm ms-auto shadow-sm" onclick="closePopupAd()">
                                    <i class="fas fa-times me-1"></i> Close Advertisement
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dot Indicators Footer -->
        @if($popupAds->count() > 1)
            <div class="p-2 bg-light text-center border-top d-flex justify-content-center gap-1.5 align-items-center" id="adDotsContainer">
                @foreach($popupAds as $index => $ad)
                    <span class="ad-dot-indicator {{ $index === 0 ? 'active' : '' }}" onclick="goToAdSlide({{ $index }})" data-dot-index="{{ $index }}"></span>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
.adware-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.78);
    z-index: 999999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.adware-close-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.65);
    border: 2px solid #ffffff;
    color: #ffffff;
    font-size: 22px;
    line-height: 1;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1000001;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.adware-close-btn:hover {
    background: #dc3545;
    color: #ffffff;
    transform: scale(1.1);
}

.ad-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    background: rgba(12, 59, 46, 0.88);
    border: 2px solid #ffffff;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: all 0.2s ease;
}

.ad-nav-btn:hover {
    background: #ffba08;
    color: #0c3b2e;
    transform: translateY(-50%) scale(1.1);
}

.ad-nav-prev {
    left: 12px;
}

.ad-nav-next {
    right: 12px;
}

.ad-dot-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #cbd5e1;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-block;
}

.ad-dot-indicator.active {
    background-color: #15803d;
    width: 24px;
    border-radius: 12px;
}

/* Horizontal Ticker Marquee for Advertisement Title */
.ad-marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    background: #f8fafc;
    padding: 8px 0;
}

.ad-marquee-track {
    display: inline-block;
    white-space: nowrap;
    animation: marquee-scroll 12s linear infinite;
    font-weight: 700;
    font-size: 0.95rem;
    color: #0c3b2e;
}

.ad-marquee-container:hover .ad-marquee-track {
    animation-play-state: paused;
}

@keyframes marquee-scroll {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
</style>

<script>
let currentAdIndex = 0;
const totalAdCount = {{ $popupAds->count() }};

function showAdSlide(index) {
    if (totalAdCount <= 0) return;
    
    if (index >= totalAdCount) {
        currentAdIndex = totalAdCount - 1;
    } else if (index < 0) {
        currentAdIndex = 0;
    } else {
        currentAdIndex = index;
    }

    const slides = document.querySelectorAll('.ad-slide-item');
    slides.forEach((slide, i) => {
        if (i === currentAdIndex) {
            slide.style.display = 'block';
            slide.classList.add('active');
        } else {
            slide.style.display = 'none';
            slide.classList.remove('active');
        }
    });

    const dots = document.querySelectorAll('.ad-dot-indicator');
    dots.forEach((dot, i) => {
        if (i === currentAdIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });

    const counterBadge = document.getElementById('adCounterBadge');
    if (counterBadge) {
        counterBadge.innerText = (currentAdIndex + 1) + ' of ' + totalAdCount;
    }

    // Close button visibility: ONLY present on the LAST advertisement slide!
    const closeBtn = document.getElementById('topAdCloseBtn');
    if (closeBtn) {
        if (currentAdIndex === totalAdCount - 1) {
            closeBtn.style.display = 'flex';
        } else {
            closeBtn.style.display = 'none';
        }
    }
}

function nextAdSlide() {
    showAdSlide(currentAdIndex + 1);
}

function prevAdSlide() {
    showAdSlide(currentAdIndex - 1);
}

function goToAdSlide(index) {
    showAdSlide(index);
}

function closePopupAd() {
    // Only close if on last ad or if only 1 ad exists
    if (totalAdCount <= 1 || currentAdIndex === totalAdCount - 1) {
        const popup = document.getElementById('singleAdPopup');
        if (popup) {
            popup.style.opacity = '0';
            const dialog = popup.querySelector('.adware-dialog');
            if (dialog) dialog.style.transform = 'scale(0.9)';
            setTimeout(function() {
                popup.style.display = 'none';
            }, 350);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('singleAdPopup');
    if (popup) {
        // Trigger smooth fade-in after small delay
        setTimeout(function() {
            popup.style.opacity = '1';
            const dialog = popup.querySelector('.adware-dialog');
            if (dialog) dialog.style.transform = 'scale(1)';
        }, 150);

        // Close when clicking outside content box (only on last slide)
        popup.addEventListener('click', function(e) {
            if (e.target === popup && (totalAdCount <= 1 || currentAdIndex === totalAdCount - 1)) {
                closePopupAd();
            }
        });

        // Keyboard navigation (Left, Right, Escape)
        document.addEventListener('keydown', function(e) {
            if (!popup || popup.style.display === 'none') return;
            
            if (e.key === 'ArrowRight') {
                nextAdSlide();
            } else if (e.key === 'ArrowLeft') {
                prevAdSlide();
            } else if (e.key === 'Escape' && (totalAdCount <= 1 || currentAdIndex === totalAdCount - 1)) {
                closePopupAd();
            }
        });
    }
});
</script>
@endif

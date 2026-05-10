{{-- 4 Popup quảng cáo thông minh dựa trên demographics --}}
{{-- Hiển thị popup phù hợp dựa trên thông tin user đã đăng nhập hoặc random cho khách vãng lai --}}

@php
    $popups = [
        [
            'id' => 'popup-desk-beginner',
            'title' => '🌱 Mới bắt đầu trồng cây?',
            'subtitle' => 'Dành cho bạn mới chơi cây',
            'description' => 'Bộ sưu tập cây để bàn dễ chăm sóc - không cần kinh nghiệm, chỉ cần yêu thương!',
            'cta' => 'Khám phá cây để bàn →',
            'link' => '/category?cat=desk',
            'bg_gradient' => 'linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%)',
            'accent' => '#2e7d32',
            'icon' => 'potted_plant',
            'target_age' => ['18-24', '25-34'],
            'target_gender' => null,
        ],
        [
            'id' => 'popup-air-purifier',
            'title' => '💨 Không khí sạch, cuộc sống khỏe',
            'subtitle' => 'Cây lọc không khí hàng đầu',
            'description' => 'Sansevieria & Spathiphyllum - Hai chiến binh lọc khí tốt nhất theo NASA, lý tưởng cho văn phòng & phòng ngủ.',
            'cta' => 'Xem cây lọc không khí →',
            'link' => '/category?tag=Lọc+khí',
            'bg_gradient' => 'linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)',
            'accent' => '#1565c0',
            'icon' => 'air',
            'target_age' => ['25-34', '35-44'],
            'target_gender' => 'female',
        ],
        [
            'id' => 'popup-statement-plants',
            'title' => '🏡 Tạo điểm nhấn cho không gian',
            'subtitle' => 'Cây lớn - Phong cách cao cấp',
            'description' => 'Monstera Deliciosa & Ficus Lyrata - Những gương mặt đại diện của xu hướng Urban Jungle trong thiết kế nội thất.',
            'cta' => 'Xem cây trồng sàn →',
            'link' => '/category?cat=large',
            'bg_gradient' => 'linear-gradient(135deg, #f1f8e9 0%, #dcedc8 100%)',
            'accent' => '#33691e',
            'icon' => 'forest',
            'target_age' => ['25-34', '35-44', '45-54'],
            'target_gender' => 'male',
        ],
        [
            'id' => 'popup-hanging-decor',
            'title' => '✨ Phủ xanh từ trên cao',
            'subtitle' => 'Cây treo - Xu hướng 2026',
            'description' => 'String of Pearls & Pothos Golden - Tạo hiệu ứng thác xanh độc đáo, biến mọi góc nhà thành tác phẩm nghệ thuật.',
            'cta' => 'Xem cây treo →',
            'link' => '/category?cat=hanging',
            'bg_gradient' => 'linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%)',
            'accent' => '#c2185b',
            'icon' => 'yard',
            'target_age' => ['18-24', '25-34'],
            'target_gender' => 'female',
        ],
    ];

    // Determine which popup to show
    $selectedPopup = null;
    $user = auth()->user();

    if ($user && $user->gender && $user->birthdate) {
        // Logged in user with demographics - find best matching popup
        $userAge = $user->age_group;
        $userGender = $user->gender;

        // Score each popup
        $bestScore = -1;
        foreach ($popups as $popup) {
            $score = 0;
            if ($popup['target_gender'] === null || $popup['target_gender'] === $userGender) {
                $score += ($popup['target_gender'] === $userGender) ? 2 : 0;
            } else {
                continue; // Skip gender mismatch
            }
            if ($popup['target_age'] === null || in_array($userAge, $popup['target_age'])) {
                $score += in_array($userAge, $popup['target_age'] ?? []) ? 3 : 0;
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $selectedPopup = $popup;
            }
        }
    }

    if (!$selectedPopup) {
        // Guest or no match - show random popup
        $selectedPopup = $popups[array_rand($popups)];
    }
@endphp

{{-- Popup Overlay --}}
<div id="promo-popup-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);backdrop-filter:blur(4px);z-index:9998;opacity:0;transition:opacity 0.4s ease;" onclick="closePromoPopup()"></div>

{{-- Popup Card --}}
<div id="promo-popup" style="display:none;position:fixed;bottom:24px;right:24px;z-index:9999;width:380px;max-width:calc(100vw - 32px);border-radius:20px;overflow:hidden;box-shadow:0 25px 60px rgba(0,0,0,0.15),0 0 0 1px rgba(0,0,0,0.05);transform:translateY(30px) scale(0.95);opacity:0;transition:all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);">
    {{-- Header --}}
    <div style="background:{{ $selectedPopup['bg_gradient'] }};padding:28px 24px 20px;position:relative;">
        <button onclick="closePromoPopup()" style="position:absolute;top:12px;right:12px;width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,0.7);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.95)'" onmouseout="this.style.background='rgba(255,255,255,0.7)'">
            <span class="material-symbols-outlined" style="font-size:18px;color:#333;">close</span>
        </button>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;">
                <span class="material-symbols-outlined" style="font-size:26px;color:{{ $selectedPopup['accent'] }};">{{ $selectedPopup['icon'] }}</span>
            </div>
            <div>
                <p style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:{{ $selectedPopup['accent'] }};font-weight:700;margin-bottom:2px;">{{ $selectedPopup['subtitle'] }}</p>
                <h3 style="font-size:18px;font-weight:800;color:#1a1a1a;line-height:1.3;font-family:'Noto Serif',serif;">{{ $selectedPopup['title'] }}</h3>
            </div>
        </div>
    </div>
    {{-- Body --}}
    <div style="background:#fff;padding:20px 24px 24px;">
        <p style="font-size:14px;color:#555;line-height:1.6;margin-bottom:20px;">{{ $selectedPopup['description'] }}</p>
        <a href="{{ $selectedPopup['link'] }}" onclick="closePromoPopup()" style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px;border-radius:12px;background:{{ $selectedPopup['accent'] }};color:#fff;font-weight:700;font-size:14px;text-decoration:none;transition:all 0.3s;box-shadow:0 4px 12px {{ $selectedPopup['accent'] }}33;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px {{ $selectedPopup['accent'] }}44'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px {{ $selectedPopup['accent'] }}33'">
            {{ $selectedPopup['cta'] }}
        </a>
        <p style="text-align:center;margin-top:12px;">
            <button onclick="closePromoPopup()" style="background:none;border:none;color:#999;font-size:12px;cursor:pointer;text-decoration:underline;">Không, cảm ơn</button>
        </p>
    </div>
</div>

<script>
    // Show popup after 3 seconds, but only once per session
    (function() {
        const popupId = '{{ $selectedPopup['id'] }}';
        const lastShown = sessionStorage.getItem('verdant_popup_shown');

        if (lastShown === popupId) return; // Already shown this session

        setTimeout(() => {
            const overlay = document.getElementById('promo-popup-overlay');
            const popup = document.getElementById('promo-popup');
            if (!overlay || !popup) return;

            overlay.style.display = 'block';
            popup.style.display = 'block';

            // Trigger animation
            requestAnimationFrame(() => {
                overlay.style.opacity = '1';
                popup.style.transform = 'translateY(0) scale(1)';
                popup.style.opacity = '1';
            });

            sessionStorage.setItem('verdant_popup_shown', popupId);
        }, 3000);
    })();

    function closePromoPopup() {
        const overlay = document.getElementById('promo-popup-overlay');
        const popup = document.getElementById('promo-popup');
        if (overlay) { overlay.style.opacity = '0'; setTimeout(() => overlay.style.display = 'none', 400); }
        if (popup) { popup.style.transform = 'translateY(30px) scale(0.95)'; popup.style.opacity = '0'; setTimeout(() => popup.style.display = 'none', 500); }
    }
</script>

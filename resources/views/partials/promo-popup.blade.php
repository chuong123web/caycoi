{{-- Banner quảng cáo trên cùng (Top Banner) --}}
@php
    $popups = [
        [
            'id' => 'popup-desk-beginner',
            'title' => '🌱 Mới bắt đầu trồng cây?',
            'subtitle' => 'Dành cho bạn mới chơi cây',
            'description' => 'Bộ sưu tập cây để bàn dễ chăm sóc - không cần kinh nghiệm, chỉ cần yêu thương!',
            'cta' => 'Khám phá ngay →',
            'link' => '/category?cat=desk',
            'bg_gradient' => 'linear-gradient(90deg, #1b5e20 0%, #2e7d32 100%)',
            'text_color' => '#ffffff',
            'accent' => '#c8e6c9',
            'icon' => 'potted_plant',
            'target_age' => ['18-24', '25-34'],
            'target_gender' => null,
        ],
        [
            'id' => 'popup-air-purifier',
            'title' => '💨 Không khí sạch, cuộc sống khỏe',
            'subtitle' => 'Cây lọc không khí hàng đầu',
            'description' => 'Sansevieria & Spathiphyllum - Lý tưởng cho văn phòng & phòng ngủ.',
            'cta' => 'Xem ngay →',
            'link' => '/category?tag=Lọc+khí',
            'bg_gradient' => 'linear-gradient(90deg, #0d47a1 0%, #1565c0 100%)',
            'text_color' => '#ffffff',
            'accent' => '#bbdefb',
            'icon' => 'air',
            'target_age' => ['25-34', '35-44'],
            'target_gender' => 'female',
        ],
        [
            'id' => 'popup-statement-plants',
            'title' => '🏡 Tạo điểm nhấn cho không gian',
            'subtitle' => 'Cây lớn cao cấp',
            'description' => 'Monstera & Ficus - Xu hướng Urban Jungle trong thiết kế nội thất.',
            'cta' => 'Mua ngay →',
            'link' => '/category?cat=large',
            'bg_gradient' => 'linear-gradient(90deg, #33691e 0%, #558b2f 100%)',
            'text_color' => '#ffffff',
            'accent' => '#dcedc8',
            'icon' => 'forest',
            'target_age' => ['25-34', '35-44', '45-54'],
            'target_gender' => 'male',
        ],
        [
            'id' => 'popup-hanging-decor',
            'title' => '✨ Phủ xanh từ trên cao',
            'subtitle' => 'Xu hướng 2026',
            'description' => 'Tạo hiệu ứng thác xanh độc đáo, biến mọi góc nhà thành tác phẩm.',
            'cta' => 'Khám phá →',
            'link' => '/category?cat=hanging',
            'bg_gradient' => 'linear-gradient(90deg, #880e4f 0%, #ad1457 100%)',
            'text_color' => '#ffffff',
            'accent' => '#f8bbd0',
            'icon' => 'yard',
            'target_age' => ['18-24', '25-34'],
            'target_gender' => 'female',
        ],
    ];

    $selectedPopup = null;
    $user = auth()->user();

    if ($user && $user->gender && $user->birthdate) {
        $userAge = $user->age_group;
        $userGender = $user->gender;
        $bestScore = -1;
        foreach ($popups as $popup) {
            $score = 0;
            if ($popup['target_gender'] === null || $popup['target_gender'] === $userGender) {
                $score += ($popup['target_gender'] === $userGender) ? 2 : 0;
            } else continue;
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
        $selectedPopup = $popups[array_rand($popups)];
    }
@endphp

<style>
.marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    padding: 8px 0;
}
.marquee-content {
    display: inline-block;
    animation: marquee 30s linear infinite;
}
.marquee-content:hover {
    animation-play-state: paused;
}
@keyframes marquee {
    0%   { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
</style>

<div id="promo-banner" style="background: {{ $selectedPopup['bg_gradient'] }}; color: {{ $selectedPopup['text_color'] }}; position: relative; z-index: 50; display: flex; align-items: center;">
    <div class="marquee-container">
        <div class="marquee-content" style="font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 24px;">
            <span style="color: {{ $selectedPopup['accent'] }}; font-weight: 700;">{{ $selectedPopup['subtitle'] }}</span>
            <span>-</span>
            <span class="material-symbols-outlined" style="font-size: 18px; margin-right: -16px;">{{ $selectedPopup['icon'] }}</span>
            <span style="font-weight: 800; font-family: 'Noto Serif', serif;">{{ $selectedPopup['title'] }}</span>
            <span>{{ $selectedPopup['description'] }}</span>
            <a href="{{ $selectedPopup['link'] }}" style="background: {{ $selectedPopup['accent'] }}; color: #333; padding: 4px 16px; border-radius: 20px; font-weight: 700; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                {{ $selectedPopup['cta'] }}
            </a>
        </div>
    </div>
    <button onclick="document.getElementById('promo-banner').style.display='none'" style="position: absolute; right: 16px; background: rgba(0,0,0,0.2); border: none; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
    </button>
</div>

<x-filament-panels::page>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e8f5e9;">
                    <x-heroicon-o-users class="w-5 h-5" style="color:#2e7d32;" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tổng Khách Hàng</p>
                    <p class="text-2xl font-bold" style="color:#1b5e20;">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e3f2fd;">
                    <x-heroicon-o-shopping-bag class="w-5 h-5" style="color:#1565c0;" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tổng Đơn Hàng</p>
                    <p class="text-2xl font-bold" style="color:#0d47a1;">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#fff3e0;">
                    <x-heroicon-o-currency-dollar class="w-5 h-5" style="color:#e65100;" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tổng Doanh Thu</p>
                    <p class="text-2xl font-bold" style="color:#bf360c;">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#f3e5f5;">
                    <x-heroicon-o-calculator class="w-5 h-5" style="color:#7b1fa2;" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">Giá Trị Đơn TB</p>
                    <p class="text-2xl font-bold" style="color:#4a148c;">{{ number_format($avgOrderValue, 0, ',', '.') }} ₫</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Demographics Charts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Gender Distribution --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold mb-4" style="color:#1b5e20;">
                <x-heroicon-o-user-group class="w-5 h-5 inline mr-1" /> Phân Bố Giới Tính
            </h3>
            @if($genderStats->count() > 0)
                @php
                    $total = $genderStats->sum();
                    $genderLabels = ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'];
                    $genderColors = ['male' => '#1565c0', 'female' => '#e91e63', 'other' => '#ff9800'];
                @endphp
                <div class="space-y-3">
                    @foreach($genderStats as $gender => $count)
                        @php $pct = round($count / $total * 100, 1); @endphp
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="font-semibold text-sm">{{ $genderLabels[$gender] ?? $gender }}</span>
                                <span class="text-sm text-gray-500">{{ $count }} ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full h-4 rounded-full" style="background:#f0f0f0;">
                                <div class="h-4 rounded-full transition-all duration-700" style="width:{{ $pct }}%;background:{{ $genderColors[$gender] ?? '#ccc' }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm italic">Chưa có dữ liệu giới tính. Cần có khách hàng đăng ký với thông tin giới tính.</p>
            @endif
        </div>

        {{-- Age Distribution --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold mb-4" style="color:#1b5e20;">
                <x-heroicon-o-calendar-days class="w-5 h-5 inline mr-1" /> Phân Bố Độ Tuổi
            </h3>
            @if(count($ageGroups) > 0)
                @php $maxAge = $ageGroups->max(); @endphp
                <div class="flex items-end gap-3 h-40">
                    @foreach($ageGroups as $group => $count)
                        @php $heightPct = $maxAge > 0 ? round($count / $maxAge * 100) : 0; @endphp
                        <div class="flex flex-col items-center flex-1">
                            <span class="text-xs font-bold mb-1" style="color:#2e7d32;">{{ $count }}</span>
                            <div class="w-full rounded-t-lg transition-all duration-700" style="height:{{ max($heightPct, 5) }}%;background:linear-gradient(to top,#1b5e20,#4caf50);"></div>
                            <span class="text-xs mt-1 text-gray-500 font-medium">{{ $group }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm italic">Chưa có dữ liệu độ tuổi. Cần có khách hàng đăng ký với ngày sinh.</p>
            @endif
        </div>
    </div>

    {{-- Top Products by Gender --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <h3 class="text-lg font-bold mb-4" style="color:#1b5e20;">
            <x-heroicon-o-sparkles class="w-5 h-5 inline mr-1" /> Sản Phẩm Yêu Thích Theo Giới Tính
        </h3>
        @if(count($topByGender) > 0)
            <div class="grid grid-cols-1 md:grid-cols-{{ count($topByGender) }} gap-6">
                @foreach($topByGender as $gender => $items)
                    @php $genderLabel = ['male' => '👨 Nam', 'female' => '👩 Nữ', 'other' => '🧑 Khác'][$gender] ?? $gender; @endphp
                    <div>
                        <h4 class="font-bold text-base mb-3 pb-2 border-b">{{ $genderLabel }}</h4>
                        <div class="space-y-2">
                            @foreach($items->take(5) as $i => $item)
                                <div class="flex justify-between items-center p-2 rounded-lg {{ $i === 0 ? 'bg-green-50' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold {{ $i === 0 ? 'text-green-700' : 'text-gray-400' }}">{{ $i + 1 }}.</span>
                                        <span class="text-sm font-medium">{{ $item->plant_name }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs px-2 py-1 rounded-full font-bold" style="background:#e8f5e9;color:#2e7d32;">{{ $item->total_qty }} sp</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-sm italic">Chưa có dữ liệu đơn hàng liên kết với tài khoản khách hàng.</p>
        @endif
    </div>

    {{-- Top Products by Age --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <h3 class="text-lg font-bold mb-4" style="color:#1b5e20;">
            <x-heroicon-o-academic-cap class="w-5 h-5 inline mr-1" /> Sản Phẩm Yêu Thích Theo Độ Tuổi
        </h3>
        @if(count($topByAge) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2 px-3 font-bold" style="color:#1b5e20;">Nhóm Tuổi</th>
                            <th class="text-left py-2 px-3">Top 1</th>
                            <th class="text-left py-2 px-3">Top 2</th>
                            <th class="text-left py-2 px-3">Top 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topByAge as $ageGroup => $items)
                            <tr class="border-b hover:bg-green-50 transition-colors">
                                <td class="py-3 px-3 font-bold" style="color:#2e7d32;">{{ $ageGroup }}</td>
                                @for($i = 0; $i < 3; $i++)
                                    <td class="py-3 px-3">
                                        @if(isset($items[$i]))
                                            <span class="font-medium">{{ $items[$i]['plant_name'] }}</span>
                                            <span class="text-xs text-gray-400 block">{{ $items[$i]['total_qty'] }} sp</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-400 text-sm italic">Chưa có dữ liệu đơn hàng liên kết với tài khoản có ngày sinh.</p>
        @endif
    </div>

    {{-- Python Analysis Button --}}
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-bold mb-3" style="color:#1b5e20;">
            <x-heroicon-o-command-line class="w-5 h-5 inline mr-1" /> Phân Tích Nâng Cao (Python)
        </h3>
        <p class="text-sm text-gray-500 mb-4">Chạy script Python để phân tích dữ liệu chuyên sâu và đưa ra gợi ý popup quảng cáo.</p>
        <a href="{{ route('api.analytics.python') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white font-semibold text-sm transition-all hover:scale-105" style="background:#1b5e20;">
            <x-heroicon-o-play class="w-4 h-4" /> Chạy Phân Tích Python
        </a>
    </div>
</x-filament-panels::page>

<x-filament-panels::page>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-success-50 dark:bg-success-900/30 flex items-center justify-center text-xl">👥</div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tổng Khách Hàng</p>
                    <p class="text-2xl font-bold text-success-600 dark:text-success-400">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-xl">🛒</div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tổng Đơn Hàng</p>
                    <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-warning-50 dark:bg-warning-900/30 flex items-center justify-center text-xl">💰</div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tổng Doanh Thu</p>
                    <p class="text-xl font-bold text-warning-600 dark:text-warning-400">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
                </div>
            </div>
        </x-filament::section>
        <x-filament::section>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-danger-50 dark:bg-danger-900/30 flex items-center justify-center text-xl">📊</div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Giá Trị Đơn TB</p>
                    <p class="text-xl font-bold text-danger-600 dark:text-danger-400">{{ number_format($avgOrderValue, 0, ',', '.') }}₫</p>
                </div>
            </div>
        </x-filament::section>
    </div>

    {{-- Demographics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Gender --}}
        <x-filament::section heading="👤 Phân Bố Giới Tính">
            @if($genderStats->count() > 0)
                @php
                    $total = $genderStats->sum();
                    $genderLabels = ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'];
                    $genderColors = ['male' => 'bg-primary-500', 'female' => 'bg-danger-500', 'other' => 'bg-warning-500'];
                @endphp
                <div class="flex flex-col gap-4">
                    @foreach($genderStats as $gender => $count)
                        @php $pct = round($count / $total * 100, 1); @endphp
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium dark:text-gray-300">{{ $genderLabels[$gender] ?? $gender }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $count }} ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="h-2 rounded-full {{ $genderColors[$gender] ?? 'bg-gray-400' }}" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm italic text-gray-500 dark:text-gray-400">Chưa có dữ liệu. Cần khách hàng đăng ký.</p>
            @endif
        </x-filament::section>

        {{-- Age --}}
        <x-filament::section heading="📅 Phân Bố Độ Tuổi">
            @if(count($ageGroups) > 0)
                @php $maxAge = $ageGroups->max(); @endphp
                <div class="flex items-end gap-3 h-32">
                    @foreach($ageGroups as $group => $count)
                        @php $heightPct = $maxAge > 0 ? round($count / $maxAge * 100) : 0; @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <span class="text-xs font-bold text-success-600 dark:text-success-400 mb-1">{{ $count }}</span>
                            <div class="w-full rounded-t-md bg-gradient-to-t from-success-600 to-success-400" style="height:{{ max($heightPct, 5) }}%;min-height:4px;"></div>
                            <span class="text-[10px] mt-1 text-gray-500 dark:text-gray-400 font-medium">{{ $group }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm italic text-gray-500 dark:text-gray-400">Chưa có dữ liệu. Cần khách hàng đăng ký với ngày sinh.</p>
            @endif
        </x-filament::section>
    </div>

    {{-- Top Products by Gender --}}
    <x-filament::section heading="⭐ Sản Phẩm Yêu Thích Theo Giới Tính" class="mb-6">
        @if(count($topByGender) > 0)
            <div class="grid grid-cols-1 md:grid-cols-{{ count($topByGender) }} gap-6">
                @foreach($topByGender as $gender => $items)
                    @php $genderLabel = ['male' => '👨 Nam', 'female' => '👩 Nữ', 'other' => '🧑 Khác'][$gender] ?? $gender; @endphp
                    <div>
                        <h4 class="text-sm font-bold mb-3 pb-2 border-b border-gray-200 dark:border-gray-700 dark:text-gray-300">{{ $genderLabel }}</h4>
                        <div class="space-y-1">
                            @foreach($items->take(5) as $i => $item)
                                <div class="flex justify-between items-center p-2 rounded-md {{ $i === 0 ? 'bg-success-50 dark:bg-success-900/30' : '' }}">
                                    <span class="text-sm dark:text-gray-300"><span class="font-bold {{ $i === 0 ? 'text-success-600 dark:text-success-400' : 'text-gray-400' }}">{{ $i + 1 }}.</span> {{ $item->plant_name }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-success-100 text-success-700 dark:bg-success-900/50 dark:text-success-400">{{ $item->total_qty }} sp</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm italic text-gray-500 dark:text-gray-400">Chưa có dữ liệu đơn hàng liên kết với tài khoản.</p>
        @endif
    </x-filament::section>

    {{-- Top Products by Age --}}
    <x-filament::section heading="🎓 Sản Phẩm Yêu Thích Theo Độ Tuổi" class="mb-6">
        @if(count($topByAge) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800/50 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3 font-bold text-success-700 dark:text-success-400">Nhóm Tuổi</th>
                            <th class="px-4 py-3">Top 1</th>
                            <th class="px-4 py-3">Top 2</th>
                            <th class="px-4 py-3">Top 3</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($topByAge as $ageGroup => $items)
                            <tr class="dark:text-gray-300">
                                <td class="px-4 py-3 font-bold text-success-600 dark:text-success-400">{{ $ageGroup }}</td>
                                @for($i = 0; $i < 3; $i++)
                                    <td class="px-4 py-3">
                                        @if(isset($items[$i]))
                                            <span class="font-medium">{{ $items[$i]['plant_name'] }}</span>
                                            <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $items[$i]['total_qty'] }} sp</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm italic text-gray-500 dark:text-gray-400">Chưa có dữ liệu đơn hàng liên kết với tài khoản có ngày sinh.</p>
        @endif
    </x-filament::section>

    {{-- Python Analysis --}}
    <x-filament::section heading="🐍 Phân Tích Nâng Cao (Python)">
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Chạy script Python để phân tích dữ liệu chuyên sâu và đưa ra gợi ý popup.</p>
        <x-filament::button href="{{ route('api.analytics.python') }}" tag="a" target="_blank" color="success">
            ▶ Chạy Phân Tích Python
        </x-filament::button>
    </x-filament::section>
</x-filament-panels::page>

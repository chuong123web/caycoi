<x-filament-panels::page>
    {{-- Summary Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:20px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;font-size:20px;">👥</div>
                <div>
                    <p style="font-size:12px;color:#6b7280;margin:0;">Tổng Khách Hàng</p>
                    <p style="font-size:24px;font-weight:800;color:#1b5e20;margin:0;">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:20px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#e3f2fd;display:flex;align-items:center;justify-content:center;font-size:20px;">🛒</div>
                <div>
                    <p style="font-size:12px;color:#6b7280;margin:0;">Tổng Đơn Hàng</p>
                    <p style="font-size:24px;font-weight:800;color:#0d47a1;margin:0;">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:20px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#fff3e0;display:flex;align-items:center;justify-content:center;font-size:20px;">💰</div>
                <div>
                    <p style="font-size:12px;color:#6b7280;margin:0;">Tổng Doanh Thu</p>
                    <p style="font-size:20px;font-weight:800;color:#bf360c;margin:0;">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
                </div>
            </div>
        </div>
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:20px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#f3e5f5;display:flex;align-items:center;justify-content:center;font-size:20px;">📊</div>
                <div>
                    <p style="font-size:12px;color:#6b7280;margin:0;">Giá Trị Đơn TB</p>
                    <p style="font-size:20px;font-weight:800;color:#4a148c;margin:0;">{{ number_format($avgOrderValue, 0, ',', '.') }}₫</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Demographics --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
        {{-- Gender --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:#1b5e20;margin:0 0 16px 0;">👤 Phân Bố Giới Tính</h3>
            @if($genderStats->count() > 0)
                @php
                    $total = $genderStats->sum();
                    $genderLabels = ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'];
                    $genderColors = ['male' => '#1565c0', 'female' => '#e91e63', 'other' => '#ff9800'];
                @endphp
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($genderStats as $gender => $count)
                        @php $pct = round($count / $total * 100, 1); @endphp
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span style="font-size:13px;font-weight:600;">{{ $genderLabels[$gender] ?? $gender }}</span>
                                <span style="font-size:12px;color:#6b7280;">{{ $count }} ({{ $pct }}%)</span>
                            </div>
                            <div style="width:100%;height:8px;border-radius:4px;background:#f0f0f0;">
                                <div style="height:8px;border-radius:4px;width:{{ $pct }}%;background:{{ $genderColors[$gender] ?? '#ccc' }};transition:width 0.7s;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color:#9ca3af;font-size:13px;font-style:italic;">Chưa có dữ liệu. Cần khách hàng đăng ký.</p>
            @endif
        </div>

        {{-- Age --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;">
            <h3 style="font-size:16px;font-weight:700;color:#1b5e20;margin:0 0 16px 0;">📅 Phân Bố Độ Tuổi</h3>
            @if(count($ageGroups) > 0)
                @php $maxAge = $ageGroups->max(); @endphp
                <div style="display:flex;align-items:flex-end;gap:12px;height:120px;">
                    @foreach($ageGroups as $group => $count)
                        @php $heightPct = $maxAge > 0 ? round($count / $maxAge * 100) : 0; @endphp
                        <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                            <span style="font-size:11px;font-weight:700;color:#2e7d32;margin-bottom:4px;">{{ $count }}</span>
                            <div style="width:100%;border-radius:4px 4px 0 0;background:linear-gradient(to top,#1b5e20,#4caf50);height:{{ max($heightPct, 5) }}%;min-height:4px;"></div>
                            <span style="font-size:10px;margin-top:4px;color:#6b7280;font-weight:500;">{{ $group }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color:#9ca3af;font-size:13px;font-style:italic;">Chưa có dữ liệu. Cần khách hàng đăng ký với ngày sinh.</p>
            @endif
        </div>
    </div>

    {{-- Top Products by Gender --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;margin-bottom:24px;">
        <h3 style="font-size:16px;font-weight:700;color:#1b5e20;margin:0 0 16px 0;">⭐ Sản Phẩm Yêu Thích Theo Giới Tính</h3>
        @if(count($topByGender) > 0)
            <div style="display:grid;grid-template-columns:repeat({{ count($topByGender) }},1fr);gap:24px;">
                @foreach($topByGender as $gender => $items)
                    @php $genderLabel = ['male' => '👨 Nam', 'female' => '👩 Nữ', 'other' => '🧑 Khác'][$gender] ?? $gender; @endphp
                    <div>
                        <h4 style="font-size:14px;font-weight:700;margin:0 0 12px 0;padding-bottom:8px;border-bottom:2px solid #e5e7eb;">{{ $genderLabel }}</h4>
                        @foreach($items->take(5) as $i => $item)
                            <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 8px;border-radius:6px;margin-bottom:4px;{{ $i === 0 ? 'background:#f0fdf4;' : '' }}">
                                <span style="font-size:13px;"><span style="font-weight:700;{{ $i === 0 ? 'color:#16a34a;' : 'color:#9ca3af;' }}">{{ $i + 1 }}.</span> {{ $item->plant_name }}</span>
                                <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:700;background:#e8f5e9;color:#2e7d32;">{{ $item->total_qty }} sp</span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:#9ca3af;font-size:13px;font-style:italic;">Chưa có dữ liệu đơn hàng liên kết với tài khoản.</p>
        @endif
    </div>

    {{-- Top Products by Age --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;margin-bottom:24px;">
        <h3 style="font-size:16px;font-weight:700;color:#1b5e20;margin:0 0 16px 0;">🎓 Sản Phẩm Yêu Thích Theo Độ Tuổi</h3>
        @if(count($topByAge) > 0)
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="border-bottom:2px solid #e5e7eb;">
                        <th style="text-align:left;padding:8px;font-weight:700;color:#1b5e20;">Nhóm Tuổi</th>
                        <th style="text-align:left;padding:8px;">Top 1</th>
                        <th style="text-align:left;padding:8px;">Top 2</th>
                        <th style="text-align:left;padding:8px;">Top 3</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topByAge as $ageGroup => $items)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px 8px;font-weight:700;color:#2e7d32;">{{ $ageGroup }}</td>
                            @for($i = 0; $i < 3; $i++)
                                <td style="padding:10px 8px;">
                                    @if(isset($items[$i]))
                                        <span style="font-weight:500;">{{ $items[$i]['plant_name'] }}</span>
                                        <span style="display:block;font-size:11px;color:#9ca3af;">{{ $items[$i]['total_qty'] }} sp</span>
                                    @else
                                        <span style="color:#d1d5db;">-</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#9ca3af;font-size:13px;font-style:italic;">Chưa có dữ liệu đơn hàng liên kết với tài khoản có ngày sinh.</p>
        @endif
    </div>

    {{-- Python Analysis --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h3 style="font-size:16px;font-weight:700;color:#1b5e20;margin:0 0 8px 0;">🐍 Phân Tích Nâng Cao (Python)</h3>
                <p style="font-size:13px;color:#6b7280;margin:0;">Chạy script Python để phân tích dữ liệu và vẽ biểu đồ tự động.</p>
            </div>
            <button id="run-python-btn" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:8px;background:#1b5e20;color:#fff;font-weight:600;font-size:13px;cursor:pointer;border:none;transition:all 0.2s;">
                ▶ Chạy Phân Tích Python
            </button>
        </div>

        <div id="python-loading" style="display:none; text-align:center; padding: 20px; color: #6b7280; font-size: 13px;">
            ⏳ Đang phân tích dữ liệu bằng Python và vẽ biểu đồ...
        </div>

        <div id="python-results" style="display:none; margin-top:20px;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="border:1px solid #e5e7eb; border-radius:12px; padding:16px;">
                    <canvas id="pythonGenderChart"></canvas>
                </div>
                <div style="border:1px solid #e5e7eb; border-radius:12px; padding:16px;">
                    <canvas id="pythonAgeChart"></canvas>
                </div>
            </div>
            <div style="margin-top:20px; border:1px solid #e5e7eb; border-radius:12px; padding:16px;">
                <h4 style="font-size:14px; font-weight:700; color:#1b5e20; margin:0 0 12px 0;">💡 Gợi Ý Marketing Từ Python</h4>
                <ul id="python-recommendations" style="font-size:13px; color:#4b5563; padding-left:20px; margin:0; line-height:1.6;"></ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('run-python-btn').addEventListener('click', function() {
            const btn = this;
            const loading = document.getElementById('python-loading');
            const results = document.getElementById('python-results');
            
            btn.disabled = true;
            btn.style.opacity = '0.5';
            loading.style.display = 'block';
            results.style.display = 'none';

            fetch('{{ route('api.analytics.python') }}')
                .then(res => res.json())
                .then(data => {
                    loading.style.display = 'none';
                    results.style.display = 'block';
                    btn.disabled = false;
                    btn.style.opacity = '1';

                    if (data.error) {
                        alert('Lỗi Python: ' + data.error);
                        return;
                    }

                    // Biểu đồ giới tính (Doughnut)
                    const genderCtx = document.getElementById('pythonGenderChart');
                    if (window.genderChartInstance) window.genderChartInstance.destroy();
                    const genderLabels = Object.keys(data.gender_distribution || {}).map(k => k === 'male' ? 'Nam' : (k === 'female' ? 'Nữ' : k));
                    const genderValues = Object.values(data.gender_distribution || {});
                    
                    window.genderChartInstance = new Chart(genderCtx, {
                        type: 'doughnut',
                        data: {
                            labels: genderLabels,
                            datasets: [{
                                data: genderValues,
                                backgroundColor: ['#1565c0', '#e91e63', '#ff9800']
                            }]
                        },
                        options: { plugins: { title: { display: true, text: 'Phân Bố Giới Tính' } } }
                    });

                    // Biểu đồ độ tuổi (Bar)
                    const ageCtx = document.getElementById('pythonAgeChart');
                    if (window.ageChartInstance) window.ageChartInstance.destroy();
                    const ageLabels = Object.keys(data.age_distribution || {});
                    const ageValues = Object.values(data.age_distribution || {});
                    
                    window.ageChartInstance = new Chart(ageCtx, {
                        type: 'bar',
                        data: {
                            labels: ageLabels,
                            datasets: [{
                                label: 'Khách hàng',
                                data: ageValues,
                                backgroundColor: '#4caf50'
                            }]
                        },
                        options: { plugins: { title: { display: true, text: 'Phân Bố Độ Tuổi' } } }
                    });

                    // Gợi ý Popup
                    const recList = document.getElementById('python-recommendations');
                    recList.innerHTML = '';
                    (data.popup_recommendations || []).forEach(rec => {
                        const li = document.createElement('li');
                        li.style.marginBottom = '8px';
                        li.innerHTML = `<strong>Gợi ý Popup:</strong> Bán <em>${rec.plant_name}</em> cho ${rec.target_gender ? (rec.target_gender==='male'?'Nam giới':'Nữ giới') : ('nhóm tuổi ' + rec.target_age)}. <br/><span style="color:#9ca3af;font-size:12px;">(Lý do: ${rec.reason})</span>`;
                        recList.appendChild(li);
                    });
                })
                .catch(err => {
                    loading.style.display = 'none';
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    alert('Lỗi kết nối hoặc không thể xử lý dữ liệu.');
                });
        });
    </script>
</x-filament-panels::page>

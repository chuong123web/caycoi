<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class Analytics extends Page
{
    protected static string|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Phân Tích Dữ Liệu';
    protected static ?string $title = 'Phân Tích Khách Hàng & Sản Phẩm';
    protected static string|\UnitEnum|null $navigationGroup = 'Thống Kê';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.analytics';

    public function getViewData(): array
    {
        // Gender stats
        $genderStats = User::whereNotNull('gender')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(fn($item) => [$item->gender => $item->total]);

        // Age group stats
        $users = User::whereNotNull('birthdate')->get();
        $ageGroups = $users->groupBy(fn($u) => $u->age_group)->map->count()->sortKeys();

        // Top products by gender
        $topByGender = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereNotNull('users.gender')
            ->select('users.gender', 'order_items.plant_name', 'order_items.plant_slug',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->groupBy('users.gender', 'order_items.plant_name', 'order_items.plant_slug')
            ->orderByDesc('total_qty')
            ->get()
            ->groupBy('gender');

        // Top products by age group
        $topByAge = [];
        $ordersWithUsers = Order::with(['items', 'user'])->whereNotNull('user_id')->get();
        foreach ($ordersWithUsers as $order) {
            $user = $order->user;
            if (!$user || !$user->age_group) continue;
            $ageGroup = $user->age_group;
            foreach ($order->items as $item) {
                $key = $item->plant_slug;
                if (!isset($topByAge[$ageGroup][$key])) {
                    $topByAge[$ageGroup][$key] = [
                        'plant_name' => $item->plant_name,
                        'total_qty' => 0,
                        'total_revenue' => 0,
                    ];
                }
                $topByAge[$ageGroup][$key]['total_qty'] += $item->quantity;
                $topByAge[$ageGroup][$key]['total_revenue'] += $item->price * $item->quantity;
            }
        }
        foreach ($topByAge as &$group) {
            usort($group, fn($a, $b) => $b['total_qty'] - $a['total_qty']);
            $group = array_slice($group, 0, 5);
        }

        // Summary
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        return [
            'genderStats' => $genderStats,
            'ageGroups' => $ageGroups,
            'topByGender' => $topByGender,
            'topByAge' => $topByAge,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'avgOrderValue' => $avgOrderValue,
        ];
    }
}

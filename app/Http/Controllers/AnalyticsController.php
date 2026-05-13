<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Return analytics data for the admin dashboard.
     */
    public function index()
    {
        // 1. Gender distribution
        $genderStats = User::whereNotNull('gender')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        // 2. Age group distribution
        $users = User::whereNotNull('birthdate')->get();
        $ageGroups = $users->groupBy(fn($u) => $u->age_group)->map->count();

        // 3. Top products by gender
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

        // 4. Top products by age group
        $topByAge = [];
        $ordersWithUsers = Order::with('items')
            ->whereNotNull('user_id')
            ->get();

        foreach ($ordersWithUsers as $order) {
            $user = $order->user;
            if (!$user || !$user->age_group) continue;
            $ageGroup = $user->age_group;

            foreach ($order->items as $item) {
                if (!isset($topByAge[$ageGroup])) $topByAge[$ageGroup] = [];
                if (!isset($topByAge[$ageGroup][$item->plant_slug])) {
                    $topByAge[$ageGroup][$item->plant_slug] = [
                        'plant_name' => $item->plant_name,
                        'plant_slug' => $item->plant_slug,
                        'total_qty' => 0,
                        'total_revenue' => 0,
                    ];
                }
                $topByAge[$ageGroup][$item->plant_slug]['total_qty'] += $item->quantity;
                $topByAge[$ageGroup][$item->plant_slug]['total_revenue'] += $item->price * $item->quantity;
            }
        }

        // Sort each age group by qty
        foreach ($topByAge as &$group) {
            usort($group, fn($a, $b) => $b['total_qty'] - $a['total_qty']);
            $group = array_slice($group, 0, 5);
        }

        // 5. Overall stats
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        return response()->json([
            'gender_stats' => $genderStats,
            'age_groups' => $ageGroups,
            'top_by_gender' => $topByGender,
            'top_by_age' => $topByAge,
            'summary' => [
                'total_users' => $totalUsers,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'avg_order_value' => $avgOrderValue,
            ],
        ]);
    }

    /**
     * Run Python analysis script and return results.
     */
    public function runPythonAnalysis()
    {
        $scriptPath = base_path('scripts/analyze.py');
        $dbPath = database_path('database.sqlite');

        if (!file_exists($scriptPath)) {
            return response()->json(['error' => 'Python script not found'], 404);
        }

        $pythonCmd = env('PYTHON_CMD', DIRECTORY_SEPARATOR === '\\' ? 'py' : 'python3');
        $command = "{$pythonCmd} \"{$scriptPath}\" \"{$dbPath}\" 2>&1";
        $output = shell_exec($command);

        $result = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Python script error', 'raw_output' => $output], 500);
        }

        return response()->json($result);
    }
}

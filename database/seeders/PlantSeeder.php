<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plants = [
            [
                'name' => 'Monstera Deliciosa',
                'name_vi' => 'Trầu Bà Nam Mỹ',
                'slug' => 'monstera-deliciosa',
                'description' => 'Monstera Deliciosa, còn gọi là Trầu Bà Nam Mỹ, là loài cây cảnh nội thất được yêu thích với lá xẻ thùy đặc trưng. Cây có khả năng thích nghi tốt với điều kiện trong nhà.',
                'price' => 1250000,
                'category' => 'large',
                'light' => 'medium',
                'tag' => 'Bán chạy',
                'care_instructions' => 'Tưới nước 1-2 lần/tuần. Đặt nơi có ánh sáng gián tiếp. Nhiệt độ lý tưởng: 18-30°C.',
                'is_active' => true,
            ],
            [
                'name' => 'Pothos Golden',
                'name_vi' => 'Trầu Bà Vàng',
                'slug' => 'pothos-golden',
                'description' => 'Cây trầu bà vàng với lá hình trái tim có sọc vàng tuyệt đẹp. Là lựa chọn hoàn hảo cho cây treo hoặc để bàn.',
                'price' => 180000,
                'category' => 'hanging',
                'light' => 'low',
                'tag' => 'Dễ chăm sóc',
                'care_instructions' => 'Tưới khi đất khô. Có thể sống trong ánh sáng yếu. Rất dễ nhân giống.',
                'is_active' => true,
            ],
            [
                'name' => 'ZZ Plant',
                'name_vi' => 'Kim Tiền',
                'slug' => 'zz-plant',
                'description' => 'Cây Kim Tiền (Zamioculcas zamiifolia) với lá bóng mượt xanh đậm. Loài cây mang lại may mắn và phong thủy tốt.',
                'price' => 550000,
                'category' => 'desk',
                'light' => 'low',
                'tag' => 'Dễ chăm sóc',
                'care_instructions' => 'Tưới rất ít nước, 1-2 tuần/lần. Chịu được ánh sáng yếu rất tốt.',
                'is_active' => true,
            ],
            [
                'name' => 'Ficus Lyrata',
                'name_vi' => 'Bàng Singapore',
                'slug' => 'ficus-lyrata',
                'description' => 'Cây Bàng Singapore (Fiddle Leaf Fig) nổi bật với lá to hình đàn violin. Là điểm nhấn hoàn hảo cho không gian sống hiện đại.',
                'price' => 1850000,
                'category' => 'large',
                'light' => 'high',
                'tag' => 'Cây lớn',
                'care_instructions' => 'Cần nhiều ánh sáng. Tưới khi 2-3cm đất mặt khô. Lau lá thường xuyên.',
                'is_active' => true,
            ],
            [
                'name' => 'Sansevieria',
                'name_vi' => 'Lưỡi Hổ',
                'slug' => 'sansevieria',
                'description' => 'Cây Lưỡi Hổ nổi tiếng với khả năng lọc không khí vượt trội, được NASA xác nhận hiệu quả. Cực kỳ dễ chăm sóc.',
                'price' => 450000,
                'category' => 'desk',
                'light' => 'low',
                'tag' => 'Lọc khí',
                'care_instructions' => 'Tưới ít nước, 2-3 tuần/lần. Chịu hạn tốt. Không cần nhiều ánh sáng.',
                'is_active' => true,
            ],
            [
                'name' => 'Calathea Orbifolia',
                'name_vi' => 'Đuôi Công Lá Tròn',
                'slug' => 'calathea-orbifolia',
                'description' => 'Calathea Orbifolia với lá tròn lớn có sọc bạc tuyệt đẹp. Lá sẽ cuộn lại ban đêm và mở ra ban ngày.',
                'price' => 750000,
                'category' => 'desk',
                'light' => 'medium',
                'tag' => 'Bán chạy',
                'care_instructions' => 'Tưới khi đất hơi ẩm. Cần độ ẩm cao. Tránh ánh nắng trực tiếp.',
                'is_active' => true,
            ],
            [
                'name' => 'Philodendron Pink Princess',
                'name_vi' => 'Trầu Bà Công Chúa Hồng',
                'slug' => 'philodendron-pink-princess',
                'description' => 'Philodendron Pink Princess là giống cây hiếm với lá có vệt hồng độc đáo. Một trong những giống cây cảnh giá trị nhất.',
                'price' => 2500000,
                'category' => 'desk',
                'light' => 'medium',
                'tag' => 'Bán chạy',
                'care_instructions' => 'Ánh sáng gián tiếp mạnh để giữ màu hồng. Tưới khi đất mặt khô.',
                'is_active' => true,
            ],
            [
                'name' => 'Spathiphyllum',
                'name_vi' => 'Lan Ý',
                'slug' => 'spathiphyllum',
                'description' => 'Lan Ý với hoa trắng thanh lịch và khả năng lọc không khí tuyệt vời. Phù hợp cho văn phòng và phòng ngủ.',
                'price' => 550000,
                'category' => 'desk',
                'light' => 'low',
                'tag' => 'Lọc khí',
                'care_instructions' => 'Tưới khi lá hơi rũ. Đặt nơi ánh sáng gián tiếp. Phun sương thường xuyên.',
                'is_active' => true,
            ],
            [
                'name' => 'String of Pearls',
                'name_vi' => 'Chuỗi Ngọc Trai',
                'slug' => 'string-of-pearls',
                'description' => 'Cây Chuỗi Ngọc Trai với thân mảnh rủ xuống đẹp mắt, mỗi lá hình tròn như viên ngọc trai nhỏ xinh.',
                'price' => 320000,
                'category' => 'hanging',
                'light' => 'high',
                'tag' => 'Dễ chăm sóc',
                'care_instructions' => 'Tưới ít nước, để đất khô giữa các lần tưới. Cần nhiều ánh sáng.',
                'is_active' => true,
            ],
            [
                'name' => 'Alocasia Polly',
                'name_vi' => 'Ráy Sừng Hươu',
                'slug' => 'alocasia-polly',
                'description' => 'Alocasia Polly nổi bật với lá hình mũi tên, màu xanh đậm với gân lá trắng nổi bật tạo nên vẻ đẹp ấn tượng.',
                'price' => 680000,
                'category' => 'desk',
                'light' => 'medium',
                'tag' => 'Bán chạy',
                'care_instructions' => 'Cần độ ẩm cao. Tưới khi đất mặt khô. Ánh sáng gián tiếp.',
                'is_active' => true,
            ],
        ];

        foreach ($plants as $plantData) {
            Plant::firstOrCreate(
                ['slug' => $plantData['slug']],
                $plantData
            );
        }

        $this->command->info('Plants seeded successfully! (' . count($plants) . ' plants)');
    }
}

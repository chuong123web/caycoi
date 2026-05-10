<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

#[Signature('db:sync-railway')]
#[Description('Chuyển toàn bộ dữ liệu từ SQLite (Local) lên MySQL (Railway)')]
class SyncDatabaseCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Đang kết nối tới Database Railway...');

        // Cấu hình Database Railway tạm thời dựa trên thông tin của bạn
        Config::set('database.connections.railway', [
            'driver' => 'mysql',
            'host' => 'tramway.proxy.rlwy.net',
            'port' => '10558',
            'database' => 'railway',
            'username' => 'root',
            'password' => 'YacizdkgTjzkuDuzFdXjjxJpNGqwCXvd',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        try {
            DB::connection('railway')->getPdo();
            $this->info('✅ Kết nối thành công!');
        } catch (\Exception $e) {
            $this->error('❌ Không thể kết nối tới Railway: ' . $e->getMessage());
            return;
        }

        $this->info('Đang chạy Migration để tạo bảng trên Railway...');
        $this->call('migrate:fresh', [
            '--database' => 'railway',
            '--force' => true
        ]);

        // Danh sách các bảng cần copy (loại bỏ bảng rác/migrations)
        $tables = [
            'users',
            'roles',
            'permissions',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'plants',
            'gift_codes',
            'orders',
            'media',
        ];

        DB::connection('railway')->statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->withProgressBar($tables, function ($table) {
            if (Schema::connection('sqlite')->hasTable($table)) {
                $data = DB::connection('sqlite')->table($table)->get()->map(function ($item) {
                    return (array) $item;
                })->toArray();

                if (!empty($data)) {
                    // Cắt nhỏ dữ liệu để insert không bị quá tải
                    $chunks = array_chunk($data, 100);
                    foreach ($chunks as $chunk) {
                        DB::connection('railway')->table($table)->insert($chunk);
                    }
                }
            }
        });

        DB::connection('railway')->statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->newLine(2);
        $this->info('🎉 HOÀN TẤT! Toàn bộ dữ liệu đã được đẩy thành công lên Railway!');
    }
}

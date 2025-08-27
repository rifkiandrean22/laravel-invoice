<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // Assets
            ['code' => '1000', 'name' => 'Kas', 'type' => 'asset'],
            ['code' => '1010', 'name' => 'Bank', 'type' => 'asset'],
            ['code' => '1100', 'name' => 'Piutang Usaha', 'type' => 'asset'],
            ['code' => '1200', 'name' => 'Persediaan', 'type' => 'asset'],

            // Liabilities
            ['code' => '2000', 'name' => 'Hutang Usaha', 'type' => 'liability'],
            ['code' => '2100', 'name' => 'Hutang Bank', 'type' => 'liability'],

            // Equity
            ['code' => '3000', 'name' => 'Modal Pemilik', 'type' => 'equity'],
            ['code' => '3100', 'name' => 'Laba Ditahan', 'type' => 'equity'],

            // Income
            ['code' => '4000', 'name' => 'Pendapatan Penjualan', 'type' => 'income'],
            ['code' => '4100', 'name' => 'Pendapatan Jasa', 'type' => 'income'],

            // Expenses
            ['code' => '5000', 'name' => 'Beban Gaji', 'type' => 'expense'],
            ['code' => '5100', 'name' => 'Beban Listrik', 'type' => 'expense'],
            ['code' => '5200', 'name' => 'Beban Sewa', 'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::firstOrCreate(
                ['code' => $account['code']],
                $account
            );
        }
    }
}

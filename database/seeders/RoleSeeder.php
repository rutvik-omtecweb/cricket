<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\PaymentCollect;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = Role::create(['id' => \Ramsey\Uuid\Uuid::uuid4()->toString(), 'name' => 'super admin']);
        $admin = Role::create(['id' => \Ramsey\Uuid\Uuid::uuid4()->toString(), 'name' => 'admin']);
        $member = Role::create(['id' => \Ramsey\Uuid\Uuid::uuid4()->toString(), 'name' => 'member']);

        $user1 = User::first();
        $user1->assignRole('super admin');

        $payment_config = Payment::where('title', 'Member Registration Fees')->first();

        $member1 = User::create([
            'user_name' => 'willianm',
            'first_name' => 'willianm',
            'last_name' => 'test',
            'email' => 'willianm@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '1234567891',
            'is_active' => true,
            'is_verify' => true,
            'is_approve' => true,
            'verification_id_1' => 'id1.jpg',
            'verification_id_2' => 'id2.jpg',
            'verification_id_3' => 'id3.png',
        ]);

        $member2 = User::create([
            'user_name' => 'john',
            'first_name' => 'john',
            'last_name' => 'test',
            'email' => 'john@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '12345678931',
            'is_active' => true,
            'is_verify' => true,
            'verification_id_1' => 'id11.jpg',
            'verification_id_2' => 'id22.jpg',
            'verification_id_3' => 'id33.png',
        ]);

        $member1->assignRole('member');
        $member2->assignRole('member');

        $expired_date = Carbon::now()->addDays($payment_config->days);

        PaymentCollect::create([
            'user_id' => $member1->id,
            'payment_type' => 'stripe',
            'amount' => '9',
            "status" => 'success',
            'expired_date' => isset($expired_date) ? $expired_date : null
        ]);

        PaymentCollect::create([
            'user_id' => $member2->id,
            'payment_type' => 'stripe',
            'amount' => '9',
            "status" => 'success',
            'expired_date' => isset($expired_date) ? $expired_date : null
        ]);
    }
}

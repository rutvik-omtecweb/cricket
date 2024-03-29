<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\PaymentCollect;
use App\Models\Player;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class MemberPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_config = Payment::where('title', 'Member Registration Fees')->first();
        $player_config = Payment::where('title', 'Player Fees')->first();

        $userDetails = [
            ['user_name' => 'user1', 'first_name' => 'Johny', 'last_name' => 'Doe', 'email' => 'user1@example.com', 'phone' => '1235567890', 'gender' => 'Male'],
            ['user_name' => 'user2', 'first_name' => 'Janedem', 'last_name' => 'Smith', 'email' => 'user12@example.com', 'phone' => '9879543210', 'gender' => 'Male'],
            ['user_name' => 'user3', 'first_name' => 'Alice', 'last_name' => 'Johnson', 'email' => 'user3@example.com', 'phone' => '5555555555', 'gender' => 'Male'],
            ['user_name' => 'user5', 'first_name' => 'Bob1', 'last_name' => 'Brown', 'email' => 'user41@example.com', 'phone' => '4444444444', 'gender' => 'Male'],
            ['user_name' => 'user6', 'first_name' => 'Bob2', 'last_name' => 'Brown', 'email' => 'user42@example.com', 'phone' => '4445544444', 'gender' => 'Male'],
            ['user_name' => 'user7', 'first_name' => 'Bob3', 'last_name' => 'Brown', 'email' => 'user43@example.com', 'phone' => '4446644444', 'gender' => 'Female'],
            ['user_name' => 'user8', 'first_name' => 'Bob4', 'last_name' => 'Brown', 'email' => 'user44@example.com', 'phone' => '4447744444', 'gender' => 'Male'],
            ['user_name' => 'user9', 'first_name' => 'Bob5', 'last_name' => 'Brown', 'email' => 'user45@example.com', 'phone' => '4444488444', 'gender' => 'Male'],
            ['user_name' => 'user10', 'first_name' => 'Bob6', 'last_name' => 'Brown', 'email' => 'user64@example.com', 'phone' => '4444994444', 'gender' => 'Male'],
            ['user_name' => 'user11', 'first_name' => 'Bob7', 'last_name' => 'Brown', 'email' => 'user74@example.com', 'phone' => '4440044444', 'gender' => 'Female'],
            ['user_name' => 'user12', 'first_name' => 'Bob8', 'last_name' => 'Brown', 'email' => 'user48@example.com', 'phone' => '4444124444', 'gender' => 'Male'],
            ['user_name' => 'user13', 'first_name' => 'Bob9', 'last_name' => 'Brown', 'email' => 'user84@example.com', 'phone' => '4444423244', 'gender' => 'Male'],
            ['user_name' => 'user14', 'first_name' => 'Bob10', 'last_name' => 'Brown', 'email' => 'user85@example.com', 'phone' => '4444423424', 'gender' => 'Male'],
            ['user_name' => 'user15', 'first_name' => 'Bob11', 'last_name' => 'Brown', 'email' => 'user86@example.com', 'phone' => '4444423464', 'gender' => 'Male'],
            ['user_name' => 'user16', 'first_name' => 'Bob12', 'last_name' => 'Brown', 'email' => 'user87@example.com', 'phone' => '4444423445', 'gender' => 'Female'],
            ['user_name' => 'user17', 'first_name' => 'Bob13', 'last_name' => 'Brown', 'email' => 'user88@example.com', 'phone' => '4444423454', 'gender' => 'Male'],
            ['user_name' => 'user18', 'first_name' => 'Bob14', 'last_name' => 'Brown', 'email' => 'user89@example.com', 'phone' => '4444423454', 'gender' => 'Female'],
            ['user_name' => 'user19', 'first_name' => 'Bob15', 'last_name' => 'Brown', 'email' => 'user90@example.com', 'phone' => '4444423484', 'gender' => 'Male'],
            ['user_name' => 'user20', 'first_name' => 'Bob16', 'last_name' => 'Brown', 'email' => 'user91@example.com', 'phone' => '4444423464', 'gender' => 'Male'],
            ['user_name' => 'user21', 'first_name' => 'Bob17', 'last_name' => 'Brown', 'email' => 'user92@example.com', 'phone' => '4144423444', 'gender' => 'Female'],
            ['user_name' => 'user22', 'first_name' => 'Bob18', 'last_name' => 'Brown', 'email' => 'user93@example.com', 'phone' => '4244423444', 'gender' => 'Male'],
            ['user_name' => 'user23', 'first_name' => 'Bob19', 'last_name' => 'Brown', 'email' => 'user94@example.com', 'phone' => '4344423444', 'gender' => 'Female'],
            ['user_name' => 'user24', 'first_name' => 'Bo20', 'last_name' => 'Brown', 'email' => 'user95@example.com', 'phone' => '4744423444', 'gender' => 'Male'],
            ['user_name' => 'user25', 'first_name' => 'Bob21', 'last_name' => 'Brown', 'email' => 'user96@example.com', 'phone' => '4844423444', 'gender' => 'Male'],

            
        ];
        foreach ($userDetails as $details) {
            $member = User::create([
                'user_name' => $details['user_name'],
                'first_name' => $details['first_name'],
                'last_name' => $details['last_name'],
                'email' => $details['email'],
                'password' => Hash::make('123456789'),
                'phone' => $details['phone'],
                'gender' => $details['gender'],
                'is_active' => true,
                'is_verify' => true,
                'is_approve' => true,
                'verification_id_1' => 'id1.jpg',
                'verification_id_2' => 'id2.jpg',
                'verification_id_3' => 'id3.png',
            ]);
            $member->assignRole('member');
            $expired_date = Carbon::now()->addDays($payment_config->days);

            PaymentCollect::create([
                'user_id' => $member->id,
                'payment_type' => 'stripe',
                'amount' => '9',
                "status" => 'success',
                'expired_date' => isset($expired_date) ? $expired_date : null
            ]);

            Player::create([
                'user_id' => $member->id,
                'payment_type' => 'stripe',
                'amount' => '25',
                'status' => "success"
            ]);
        }
    }
}

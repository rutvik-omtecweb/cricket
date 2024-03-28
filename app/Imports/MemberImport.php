<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentCollect;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MemberImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data['user_name'] = $row['user_name'];
            $data['first_name'] = $row['first_name'];
            $data['last_name'] = $row['last_name'];
            $data['email'] = trim($row['email']);
            $data['phone'] = $row['phone'];
            $data['password'] = Hash::make($row['password']);
            $data['gender'] = $row['gender'];
            $data['dob'] = $row['dob'];
            $data['address'] = $row['address'];
            $data['city'] = !empty($row['city']) ? $row['city'] : 'Fort McMurray';
            $data['state'] = !empty($row['state']) ? $row['state'] : 'Alberta';
            $data['postal_code'] = $row['postal_code'];
            $data['terms_and_conditions'] = '1';
            $data['living_rmwb_for_3_month'] = '1';
            $data['not_member_of_cricket'] = '1';
            // $data['verification_id_1'] = $row['verification_id_1'];
            // $data['verification_id_2'] = $row['verification_id_2'];
            // $data['verification_id_3'] = $row['verification_id_3'];
            $data['is_active'] = True;
            $data['is_verify'] = True;
            $data['is_approve'] = True;

            $payment_config = Payment::where('title', 'Member Registration Fees')->first();
            $expired_date = Carbon::now()->addDays($payment_config->days);

            $member = User::create($data);

            $member->assignRole('member');

            PaymentCollect::create([
                'user_id' => $member->id,
                'payment_type' => $row['payment_type'],
                'amount' =>  $row['payment_amount'],
                "status" => 'success',
                'expired_date' => isset($expired_date) ? $expired_date : null
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'user_name' => ['required', 'unique:users,user_name'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'phone' => ['required'],
            'password' => ['required', 'min:8'],
            'gender' => ['required', Rule::in(['Female', 'Male'])],
            'dob' => ['required'],
            'address' => ['required'],
            'postal_code' => ['required'],
            'payment_type' => ['required'],
            'payment_amount' => ['required'],
        ];
    }
}

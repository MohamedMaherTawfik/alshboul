<?php

namespace Database\Seeders;

use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // بيانات المحامين (5 محامين)
        $lawyersData = [
            [
                'name' => 'أحمد محمد',
                'license_number' => 'L-001',
                'dob' => '1985-05-15',
                'bar_association' => 'Cairo Bar Association',
                'specialization' => 'Civil Law',
                'license_issue_date' => '2010-03-01',
                'address' => 'Cairo, Egypt',
                'phone' => '+201000000001',
                'id_number' => '123456789',
                'nationality' => 'Egyptian',
                'cv_file' => 'cv1.pdf',
            ],
            [
                'name' => 'سارة علي',
                'license_number' => 'L-002',
                'dob' => '1990-08-22',
                'bar_association' => 'Alexandria Bar Association',
                'specialization' => 'Criminal Law',
                'license_issue_date' => '2015-07-10',
                'address' => 'Alexandria, Egypt',
                'phone' => '+201000000002',
                'id_number' => '987654321',
                'nationality' => 'Egyptian',
                'cv_file' => 'cv2.pdf',
            ],
            [
                'name' => 'وليد عبد الرحمن',
                'license_number' => 'L-003',
                'dob' => '1982-11-03',
                'bar_association' => 'Giza Bar Association',
                'specialization' => 'Corporate Law',
                'license_issue_date' => '2008-05-15',
                'address' => 'Giza, Egypt',
                'phone' => '+201000000003',
                'id_number' => '112233445',
                'nationality' => 'Egyptian',
                'cv_file' => 'cv3.pdf',
            ],
            [
                'name' => 'نورهان مصطفى',
                'license_number' => 'L-004',
                'dob' => '1993-03-18',
                'bar_association' => 'Aswan Bar Association',
                'specialization' => 'Family Law',
                'license_issue_date' => '2018-01-20',
                'address' => 'Aswan, Egypt',
                'phone' => '+201000000004',
                'id_number' => '556677889',
                'nationality' => 'Egyptian',
                'cv_file' => 'cv4.pdf',
            ],
            [
                'name' => 'محمود خالد',
                'license_number' => 'L-005',
                'dob' => '1987-07-09',
                'bar_association' => 'Port Said Bar Association',
                'specialization' => 'Commercial Law',
                'license_issue_date' => '2012-09-05',
                'address' => 'Port Said, Egypt',
                'phone' => '+201000000005',
                'id_number' => '998877665',
                'nationality' => 'Egyptian',
                'cv_file' => 'cv5.pdf',
            ],
        ];

        foreach ($lawyersData as $index => $data) {
            $user = User::create([
                'id' => $index + 11,
                'name' => $data['name'],
                'email' => strtolower(str_replace(' ', '.', $data['name'])) . '@lawyer.com',
                'username' => strtolower(str_replace(' ', '', $data['name'])),
                'phone' => $data['phone'],
                'address' => $data['address'],
                'password' => Hash::make('password'),
                'role' => 'lawyer',
            ]);

            // إنشاء السجل في جدول Lawyers
            Lawyer::create([
                'id' => $user->id,
                'user_id' => $user->id,
                'name' => $data['name'],
                'license_number' => $data['license_number'],
                'dob' => $data['dob'],
                'bar_association' => $data['bar_association'],
                'specialization' => $data['specialization'],
                'license_issue_date' => $data['license_issue_date'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'id_number' => $data['id_number'],
                'nationality' => $data['nationality'],
                'cv_file' => $data['cv_file'],
                'added_by' => 1, // يمكن تعديلها لاحقًا
                'updated_by' => 1,
            ]);
        }
    }
}

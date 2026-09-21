<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $receptionist = User::create([
            'name' => 'Sara Receptionist',
            'email' => 'receptionist@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
            'is_active' => true,
        ]);

        $accountant = User::create([
            'name' => 'Omar Accountant',
            'email' => 'accountant@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'accountant',
            'is_active' => true,
        ]);

        // Departments
        $depts = [
            ['name' => 'Cardiology', 'name_ar' => 'أمراض القلب', 'location' => 'المبنى الرئيسي - الطابق 3', 'phone' => '011-1234567', 'capacity' => 30, 'description' => 'قسم أمراض القلب والقسطرة العظمى'],
            ['name' => 'Dermatology', 'name_ar' => 'الأمراض الجلدية', 'location' => 'المبنى الرئيسي - الطابق 2', 'phone' => '011-1234568', 'capacity' => 20, 'description' => 'قسم الأمراض الجلدية والتجميل'],
            ['name' => 'Emergency', 'name_ar' => 'الطوارئ', 'location' => 'الطابق الأرضي', 'phone' => '011-1234569', 'capacity' => 50, 'description' => 'قسم الطوارئ والاستقبال العاجل'],
            ['name' => 'General Surgery', 'name_ar' => 'الجراحة العامة', 'location' => 'المبنى الرئيسي - الطابق 4', 'phone' => '011-1234570', 'capacity' => 25, 'description' => 'قسم الجراحة العامة والمناظير'],
            ['name' => 'Internal Medicine', 'name_ar' => 'الباطنية', 'location' => 'المبنى الرئيسي - الطابق 2', 'phone' => '011-1234571', 'capacity' => 40, 'description' => 'قسم الطب الباطني العام'],
            ['name' => 'Orthopedics', 'name_ar' => 'جراحة العظام', 'location' => 'المبنى B - الطابق 1', 'phone' => '011-1234572', 'capacity' => 20, 'description' => 'قسم جراحة العظام والمفاصل'],
            ['name' => 'Pediatrics', 'name_ar' => 'طب الأطفال', 'location' => 'المبنى B - الطابق 2', 'phone' => '011-1234573', 'capacity' => 35, 'description' => 'قسم طب الأطفال وحديثي الولادة'],
            ['name' => 'Radiology', 'name_ar' => 'الأشعة', 'location' => 'الطابق الأرضي', 'phone' => '011-1234574', 'capacity' => 15, 'description' => 'قسم الأشعة والمقطعية والرنين المغناطيسي'],
        ];

        $departmentModels = [];
        foreach ($depts as $dept) {
            $departmentModels[] = Department::create($dept);
        }

        // Doctors
        $doctorUsers = [
            ['name' => 'Dr. Ahmed Ali', 'email' => 'ahmed@hospital.com'],
            ['name' => 'Dr. Fatima Hassan', 'email' => 'fatima@hospital.com'],
            ['name' => 'Dr. Mohammed Saeed', 'email' => 'mohammed@hospital.com'],
            ['name' => 'Dr. Noura Ibrahim', 'email' => 'noura@hospital.com'],
            ['name' => 'Dr. Khalid Omar', 'email' => 'khalid@hospital.com'],
        ];

        $specializations = [
            ['Cardiologist', 1], ['Dermatologist', 2], ['Surgeon', 4],
            ['Pediatrician', 7], ['Orthopedic Surgeon', 6],
        ];

        $doctorModels = [];
        foreach ($doctorUsers as $i => $d) {
            $user = User::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'is_active' => true,
            ]);

            $doctorModels[] = Doctor::create([
                'user_id' => $user->id,
                'department_id' => $specializations[$i][1],
                'first_name' => explode(' ', $d['name'])[1],
                'last_name' => explode(' ', $d['name'])[2],
                'specialization' => $specializations[$i][0],
                'license_number' => 'LIC' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'phone' => '+96650' . str_pad($i + 1000000, 7, '0', STR_PAD_LEFT),
                'email' => $d['email'],
                'consultation_fee' => [200, 150, 300, 180, 250][$i],
                'status' => 'active',
                'schedule' => 'الأحد - الخميس، 9:00 ص - 4:00 م',
            ]);
        }

        // Patients
        $patients = [
            ['first_name' => 'Ali', 'last_name' => 'Mohammed', 'gender' => 'male', 'dob' => '1990-05-15', 'blood' => 'A+', 'phone' => '+966551234567'],
            ['first_name' => 'Sara', 'last_name' => 'Ahmad', 'gender' => 'female', 'dob' => '1985-11-22', 'blood' => 'O-', 'phone' => '+966552345678'],
            ['first_name' => 'Omar', 'last_name' => 'Khalid', 'gender' => 'male', 'dob' => '1978-03-10', 'blood' => 'B+', 'phone' => '+966553456789'],
            ['first_name' => 'Layla', 'last_name' => 'Hassan', 'gender' => 'female', 'dob' => '2000-07-05', 'blood' => 'AB+', 'phone' => '+966554567890'],
            ['first_name' => 'Youssef', 'last_name' => 'Ali', 'gender' => 'male', 'dob' => '1955-01-28', 'blood' => 'O+', 'phone' => '+966555678901', 'status' => 'critical'],
            ['first_name' => 'Mona', 'last_name' => 'Saeed', 'gender' => 'female', 'dob' => '1992-09-14', 'blood' => 'A-', 'phone' => '+966556789012'],
            ['first_name' => 'Hassan', 'last_name' => 'Ibrahim', 'gender' => 'male', 'dob' => '1983-12-01', 'blood' => 'B-', 'phone' => '+966557890123'],
            ['first_name' => 'Aisha', 'last_name' => 'Omar', 'gender' => 'female', 'dob' => '1968-06-18', 'blood' => 'O+', 'phone' => '+966558901234'],
            ['first_name' => 'Karim', 'last_name' => 'Nasser', 'gender' => 'male', 'dob' => '1995-08-30', 'blood' => 'AB-', 'phone' => '+966559012345'],
            ['first_name' => 'Dina', 'last_name' => 'Farouk', 'gender' => 'female', 'dob' => '2002-02-20', 'blood' => 'A+', 'phone' => '+966560123456'],
        ];

        $patientModels = [];
        $counter = 1;
        foreach ($patients as $p) {
            $patientModels[] = Patient::create([
                'patient_number' => 'PAT' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'first_name' => $p['first_name'],
                'last_name' => $p['last_name'],
                'gender' => $p['gender'],
                'date_of_birth' => $p['dob'],
                'phone' => $p['phone'],
                'blood_type' => $p['blood'],
                'address' => 'الرياض، المملكة العربية السعودية',
                'city' => 'الرياض',
                'national_id' => '10' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                'status' => $p['status'] ?? 'active',
                'insurance_provider' => 'شركة التأمين التعاونية',
                'insurance_number' => 'INS' . str_pad($counter, 6, '0', STR_PAD_LEFT),
            ]);
        }

        // Rooms
        $roomTypes = ['ward', 'private', 'icu', 'emergency'];
        foreach ($departmentModels as $dept) {
            for ($i = 1; $i <= 4; $i++) {
                Room::create([
                    'room_number' => sprintf('%s-%02d', strtoupper(substr($dept->name, 0, 3)), $i),
                    'department_id' => $dept->id,
                    'type' => $roomTypes[$i - 1],
                    'capacity' => $i === 1 ? 4 : ($i === 2 ? 1 : ($i === 3 ? 1 : 2)),
                    'current_occupancy' => rand(0, 2),
                    'rate_per_day' => [100, 250, 500, 150][$i - 1],
                    'status' => 'available',
                ]);
            }
        }

        // Appointments
        $statuses = ['scheduled', 'confirmed', 'completed', 'cancelled'];
        $counter = 1;
        $appointmentModels = [];
        for ($i = 0; $i < 20; $i++) {
            $aptDate = now()->subDays(rand(0, 14))->format('Y-m-d');
            $aptTime = sprintf('%02d:00', rand(8, 16));
            $status = $statuses[array_rand($statuses)];

            $appointmentModels[] = \App\Models\Appointment::create([
                'appointment_number' => 'APT' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'patient_id' => $patientModels[array_rand($patientModels)]->id,
                'doctor_id' => $doctorModels[array_rand($doctorModels)]->id,
                'appointment_date' => $aptDate,
                'appointment_time' => $aptTime,
                'status' => $status,
                'priority' => ['low', 'normal', 'high', 'urgent'][array_rand([0, 1, 1, 2])],
                'reason' => 'استشافة عامة',
                'fee' => 200,
                'payment_status' => rand(0, 1) ? 'paid' : 'unpaid',
            ]);
        }

        // Medical Records
        $recordTypes = ['visit', 'emergency', 'surgery', 'follow_up', 'lab_result'];
        $recordCounter = 1;
        $recordModels = [];
        foreach ($appointmentModels as $apt) {
            if ($apt->status !== 'completed') {
                continue;
            }

            $recordModels[] = \App\Models\MedicalRecord::create([
                'record_number' => 'REC' . str_pad($recordCounter++, 6, '0', STR_PAD_LEFT),
                'patient_id' => $apt->patient_id,
                'doctor_id' => $apt->doctor_id,
                'appointment_id' => $apt->id,
                'type' => $recordTypes[array_rand($recordTypes)],
                'visit_date' => $apt->appointment_date,
                'chief_complaint' => 'ألم في الصدر وضيق تنفس',
                'diagnosis' => 'التهاب في الجزء العلوي من الجهاز التنفسي، وحالة متوسطة من القلق',
                'treatment_plan' => 'راحة تامة لمدة أسبوع، مضادات حيوية، والمتابعة بعد 7 أيام',
                'notes' => 'يُنصح بالتقليل من الكافيين والالتزام بالدواء الموصوف',
                'temperature' => rand(36, 39),
                'blood_pressure_systolic' => rand(110, 160),
                'blood_pressure_diastolic' => rand(70, 100),
                'heart_rate' => rand(60, 100),
                'weight' => rand(55, 95),
                'height' => rand(155, 185),
                'blood_sugar' => rand(80, 140),
            ]);
        }

        // Prescriptions
        $drugs = [
            ['Amoxicillin 500mg', 'كبسولة واحدة 3 مرات يومياً', 'بعد الأكل'],
            ['Paracetamol 500mg', 'قرص واحد عند اللزوم', 'بعد الأكل'],
            ['Ibuprofen 400mg', 'قرص واحد 3 مرات يومياً', 'بعد الأكل'],
            ['Omeprazole 20mg', 'كبسولة واحدة يومياً', 'قبل الأكل'],
            ['Metformin 500mg', 'قرص واحد مرتين يومياً', 'مع الأكل'],
            ['Lisinopril 10mg', 'قرص واحد يومياً', 'صباحاً'],
            ['Azithromycin 250mg', 'قرص واحد يومياً', 'مع الأكل'],
            ['Vitamin D3 5000 IU', 'كبسولة واحدة يومياً', 'مع الفطور'],
        ];

        $counter = 1;
        foreach ($recordModels as $i => $record) {
            $selectedDrugs = array_rand($drugs, min(3, count($drugs)));
            $selectedDrugs = is_array($selectedDrugs) ? $selectedDrugs : [$selectedDrugs];

            $prescription = \App\Models\Prescription::create([
                'prescription_number' => 'RX' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'patient_id' => $record->patient_id,
                'doctor_id' => $record->doctor_id,
                'medical_record_id' => $record->id,
                'prescription_date' => $record->visit_date,
                'valid_until' => now()->addDays(30),
                'status' => 'active',
                'notes' => 'كمراجعة، يجب إيقاف الدواء عند ظهور أي حساسية',
            ]);

            foreach ($selectedDrugs as $idx) {
                \App\Models\PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medication_name' => $drugs[$idx][0],
                    'dosage' => $drugs[$idx][1],
                    'frequency' => $drugs[$idx][1],
                    'duration' => rand(5, 14) . ' يوم',
                    'instructions' => $drugs[$idx][2],
                    'quantity' => rand(1, 4) * 10,
                ]);
            }
        }

        // Lab Tests
        $labTests = [
            ['CBC', 'تعداد الدم الكامل'], ['Blood Glucose', 'سكر الدم'],
            ['Lipid Profile', 'صورة الدهون'], ['Thyroid', 'وظائف الغدة الدرقية'],
            ['Urinalysis', 'تحليل البول'], ['Kidney Function', 'وظائف الكلى'],
            ['Liver Function', 'وظائف الكبد'], ['CRP', 'بروتين سي التفاعلي'],
        ];

        $counter = 1;
        foreach ($patientModels as $i => $patient) {
            $test = $labTests[$i % count($labTests)];
            $status = $i % 2 === 0 ? 'completed' : 'in_progress';

            \App\Models\LabTest::create([
                'test_number' => 'LAB' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'patient_id' => $patient->id,
                'doctor_id' => $doctorModels[$i % count($doctorModels)]->id,
                'test_type' => 'laboratory',
                'test_name' => $test[1],
                'description' => $test[0],
                'test_date' => now()->subDays(rand(0, 10)),
                'status' => $status,
                'urgency' => rand(0, 1) ? 'normal' : 'urgent',
                'results' => $status === 'completed' ? 'النتائج ضمن الحدود الطبيعية، لا توجد مؤشرات خطيرة.' : null,
                'result_date' => $status === 'completed' ? now() : null,
            ]);
        }

        // Invoices
        $invoiceItems = [
            ['استشارة طبية', 150], ['فحص دم شامل', 80], ['أشعة سينية', 120],
            ['علاج (أدوية)', 75], ['إقامة يومية', 200], ['عملية جراحية', 1500],
            ['تخطيط قلب', 250], ['أشعة صوتية', 180],
        ];

        $counter = 1;
        foreach ($patientModels as $i => $patient) {
            $item = $invoiceItems[$i % count($invoiceItems)];
            $quantity = rand(1, 3);
            $subtotal = $item[1] * $quantity;
            $tax = $subtotal * 0.05;
            $total = $subtotal + $tax;
            $status = $i % 3 === 0 ? 'pending' : 'paid';

            $invoice = \App\Models\Invoice::create([
                'invoice_number' => 'INV' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'patient_id' => $patient->id,
                'appointment_id' => $appointmentModels[$i % count($appointmentModels)]->id,
                'invoice_date' => now()->subDays(rand(0, 14)),
                'due_date' => now()->addDays(rand(7, 30)),
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'discount_amount' => 0,
                'total_amount' => $total,
                'paid_amount' => $status === 'paid' ? $total : 0,
                'status' => $status,
                'payment_method' => $status === 'paid' ? 'cash' : null,
                'created_by_user_id' => $admin->id,
                'notes' => null,
            ]);

            \App\Models\InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item[0],
                'quantity' => $quantity,
                'unit_price' => $item[1],
                'total' => $subtotal,
            ]);
        }

        // Inventory
        $inventoryItems = [
            ['Amoxicillin 500mg', 'أموكسيسيللين 500 ملغ', 'medication', 120, 'PharmaCare', '015-5550011'],
            ['Paracetamol 500mg', 'باراسيتامول 500 ملغ', 'medication', 300, 'PharmaCare', '015-5550011'],
            ['Insulin Glargine', 'أنسولين جالارجين', 'medication', 15, 'MedSupply Co', '015-5550022'],
            ['Surgical Gloves', 'قفازات جراحية', 'supplies', 8, 'MedSupply Co', '015-5550022'],
            ['Syringes 5ml', 'محاقن 5 مل', 'supplies', 75, 'MedSupply Co', '015-5550022'],
            ['Bandages', 'ضمادات طبية', 'consumable', 40, 'CarePlus', '015-5550033'],
            ['Stethoscope', 'سماعة طبيب', 'equipment', 25, 'MedEquip', '015-5550044'],
            ['Blood Pressure Monitor', 'جهاز قياس الضغط', 'equipment', 12, 'MedEquip', '015-5550044'],
        ];

        $inventoryModels = [];
        $counter = 1;
        foreach ($inventoryItems as $i => $inv) {
            $quantity = $inv[3];
            $minimum = rand(10, 30);
            $item = \App\Models\Inventory::create([
                'item_code' => 'INV' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'name' => $inv[0],
                'name_ar' => $inv[1],
                'category' => $inv[2],
                'quantity' => $quantity,
                'minimum_stock' => $minimum,
                'maximum_stock' => 500,
                'unit_price' => [12.5, 5, 450, 2.5, 1.75, 3.2, 180, 220][$i],
                'supplier' => $inv[4],
                'supplier_phone' => $inv[5],
                'location' => 'مخزن المستودع رقم ' . ($i + 1),
                'status' => 'in_stock',
            ]);
            $item->updateStatus();
            $inventoryModels[] = $item;

            \App\Models\InventoryTransaction::create([
                'inventory_id' => $item->id,
                'type' => 'in',
                'quantity' => $quantity,
                'unit_price' => $item->unit_price,
                'performed_by' => $admin->id,
                'notes' => 'مخزون افتتاحي',
            ]);
        }

        // Bed Admissions
        $bedAdmissionCounter = 1;
        foreach ($patientModels as $i => $patient) {
            if ($i % 3 !== 0) {
                continue;
            }

            $room = \App\Models\Room::inRandomOrder()->first();
            $admissionDate = now()->subDays(rand(1, 6));
            $status = $i % 6 === 0 ? 'discharged' : 'active';

            \App\Models\BedAdmission::create([
                'patient_id' => $patient->id,
                'room_id' => $room->id,
                'doctor_id' => $doctorModels[$i % count($doctorModels)]->id,
                'admission_date' => $admissionDate,
                'expected_discharge_date' => now()->addDays(rand(2, 10)),
                'actual_discharge_date' => $status === 'discharged' ? now()->subDay() : null,
                'reason' => 'مراقبة حالتهم الصحية بعد العملية الجراحية',
                'status' => $status,
            ]);

            if ($status === 'active') {
                $room->increment('current_occupancy');
                $room->updateStatus();
            }
        }

        // Notifications
        $notifications = [
            ['appointment', 'موعد جديد', 'لديك موعد جديد اليوم مع أحد المرضى، يرجى التأكد من الحضور'],
            ['patient', 'مريض جديد', 'تم تسجيل مريض جديد في النظام بحاجة لمتابعة'],
            ['inventory', 'مخزون منخفض', 'انخفض مخزون الأقنعة الطبية، يرجى إعادة الطلب'],
            ['warning', 'تنبيه أمني', 'هناك محاولة دخول فاشلة إلى النظام'],
            ['appointment', 'تذكير بموعد', 'لديك موعد مؤكد خلال ساعتين في عيادة الأسنان'],
        ];

        foreach ($notifications as $i => $n) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => $n[0],
                'title' => $n[1],
                'message' => $n[2],
                'is_read' => $i > 0,
            ]);
        }

        echo "✅ Database seeded successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 Login: admin@hospital.com\n";
        echo "🔑 Password: password\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}

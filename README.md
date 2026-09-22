# نظام إدارة المستشفيات (Hospital Management System)

نظام ويب متكامل لإدارة المستشفيات مبني بـ **Laravel 12**، بواجهة عربية (RTL) بتصميم طبي احترافي، يشمل إدارة المرضى والمواعيد والسجلات الطبية والوصفات والتحاليل والفواتير والغرف والأسرة والمخزون والمستخدمين والتقارير.

---

## المتطلبات

- PHP **8.2+** مع الـ extensions التالية: `pdo_sqlite`, `mbstring`, `xml`, `curl`, `fileinfo`, `openssl`
- Composer
- Node.js **20+** + npm

---

## التثبيت (Installation)

```bash
# 1) تثبيت مكتبات PHP
composer install

# 2) إنشاء ملف البيئة
copy .env.example .env          # في Windows
# cp .env.example .env          # في Linux / Mac

# 3) توليد مفتاح التطبيق
php artisan key:generate

# 4) إعداد قاعدة البيانات
#    - الملف: database/database.sqlite (أُنشئ تلقائيًا)
#    - الترحيلات + البيانات التجريبية:
php artisan migrate --seed

# 5) تثبيت وبناء ملفات الواجهات (CSS/JS)
npm install
npm run build
```

> **بديل أسرع:** أمر واحد يعمل كل ما سبق (نسخ `.env`، توليد المفتاح، الترحيل):
> ```bash
> composer setup
> ```

---

## التشغيل (Run)

افتح **نافذتين طرفية**:

**الأولى — خادم التطبيق:**
```bash
php artisan serve
```

**الثانية — خادم الواجهات (اختياري أثناء التطوير):**
```bash
npm run dev
```

بعد ذلك افتح المتصفح على: **http://127.0.0.1:8000**

### أمر تشغيل شامل (سيرفر + Queue + Logs + Vite)
```bash
composer dev
```

> ملاحظة: إذا عدّلت في `resources/js` أو `resources/css` بعد البناء، أعد `npm run build` ليُطبَّق التعديل.

---

## حسابات الدخول التجريبية

| الدور | البريد الإلكتروني | كلمة المرور |
|-------|-------------------|--------------|
| **مدير النظام** | `admin@hospital.com` | `password` |
| موظف الاستقبال | `receptionist@hospital.com` | `password` |
| المحاسب | `accountant@hospital.com` | `password` |

> صفحة الدخول تحتوي بطاقة «حسابات تجريبية» — اضغطها لتعبئة بيانات المدير تلقائيًا.

---

## بنية قاعدة البيانات

SQLite (`database/database.sqlite`) — أهم الجداول:

- `users` — المستخدمون والأدوار (admin, doctor, receptionist, accountant, lab_technician, pharmacist, nurse, staff)
- `patients` & `doctors` — المرضى والأطباء
- `departments` & `rooms` & `bed_admissions` — الأقسام والغرف والأسرة/المنومات
- `appointments` — المواعيد
- `medical_records` — السجلات الطبية
- `prescriptions` + `prescription_items` — الوصفات وأدويتها
- `lab_tests` — التحاليل ونتائجها
- `invoices` + `invoice_items` + `payments` — الفواتير والمدفوعات
- `inventory` + `inventory_transactions` — المخزون وحركاته
- `notifications` — الإشعارات الداخلية
- `audit_logs` — سجل العمليات (للمدير فقط)

للترحيل من الصفر: `php artisan migrate:fresh --seed`

---

## الدوال والوحدات (Routes)

| المسار | الوظيفة | الصلاحية |
|--------|---------|----------|
| `/login` `POST /login` `/logout` | تسجيل الدخول والخروج | Guest / Auth |
| `/dashboard` | لوحة التحكم الرئيسية | Auth |
| `/patients` | إدارة المرضى (CRUD) | Auth |
| `/doctors` | إدارة الأطباء (CRUD) | Auth |
| `/departments` | إدارة الأقسام (CRUD) | Auth |
| `/appointments` | المواعيد (بدون تعديل) | Auth |
| `/medical-records` | السجلات الطبية (CRUD) | Auth |
| `/prescriptions` | الوصفات (إنشاء/عرض/حذف) | Auth |
| `/lab-tests` + `POST .../results` | التحاليل وتسجيل النتائج | Auth |
| `/invoices` + `POST .../payment` | الفواتير وتسجيل الدفعات | Auth |
| `/rooms` | إدارة الغرف (CRUD) | Auth |
| `/beds` + `POST .../discharge` | الأسرة/الإقامات وخروج المريض | Auth |
| `/inventory` + `POST .../adjust` | المخزون وتعديل الكميات | Auth |
| `/users` | إدارة المستخدمين (CRUD) | Admin |
| `/audit-logs` | سجل العمليات | Admin |
| `/reports` | تقارير المرضى / المواعيد / الإيرادات | Auth |
| `/notifications` + `/profile` | الإشعارات والملف الشخصي | Auth |

---

## الواجهات والتصميم (Frontend)

- **التقنية:** Blade + Tailwind CSS v4 (عبر Vite) + الخط العربي **Tajawal**.
- **الهوية:** أزرق طبي (Primary/Dark/Light Blue) مع تدرجات، زوايا دائرية ناعمة.
- **الحركة (Animation):**
  - **AOS** (Animate On Scroll) — ظهور تدريجي للبطاقات والجداول والحقول بتتابع مؤجل (stagger).
  - **GSAP** — عدّادات الأرقام التصاعدية على لوحة التحكم والقوائم والتقارير، وحركات دخول خفيفة.
  - **CSS** — إخفاء تلقائي للتنبيهات، نبض شارة الإشعارات، مؤشر تحميل أثناء إرسال النماذج (POST)، انتقال لوني خفيف بين الصفحات، وشريط نبض قلب (ECG) متحرك أسفل صفحة الدخول.
- **إمكانية الوصول:** كل الحركات متوافقة مع `prefers-reduced-motion` (تُعطَّل تلقائيًا مع إعداد تقليل الحركة).
- **ملفات الواجهات:** `resources/js/app.js` و `resources/css/app.css` (مبنيان عبر Vite في `public/build`).

---

## هيكل المشروع (سريع)

```
app/
├── Http/Controllers/        # وحدات التحكم (Patient, Doctor, ...)
├── Models/                  # موديلات Eloquent
├── Roles/RoleMiddleware.php # فحص الصلاحيات (role:admin)
database/
├── migrations/              # جداول قاعدة البيانات
├── seeders/DatabaseSeeder.php
resources/
├── views/
│   ├── auth/login.blade.php     # صفحة تسجيل الدخول
│   ├── layouts/                 # القوالب (app, sidebar, header)
│   └── <module>/                # index, create, edit, show
├── css/app.css
└── js/app.js
routes/web.php               # كل المسارات
```

---

## أوامر مفيدة

| الأمر | الوظيفة |
|-------|---------|
| `php artisan serve` | تشغيل الخادم |
| `npm run dev` | واجهات أثناء التطوير |
| `npm run build` | بناء الواجهات للإنتاج |
| `php artisan migrate:fresh --seed` | إعادة تهيئة قاعدة البيانات بالبيانات التجريبية |
| `php artisan view:cache` | تجميع قوالب Blade (فحص صياغتها) |
| `php artisan route:list` | عرض كل المسارات |
| `php artisan tinker` | استكشاف الأخطاء عبر الطرفية |
| `composer test` | تشغيل الاختبارات |

---

## استكشاف الأخطاء

- **الصفحة فاضية / نص فقط:** شغّل `npm run build` ثم حدّث الصفحة.
- **خطأ قاعدة البيانات:** تأكد أن `database/database.sqlite` موجود و`php artisan migrate --seed`.
- **الخط العربي لا يظهر:** تأكد من اتصال الإنترنت (الخط محمّل من Google Fonts).
- **`APP_KEY` مفقود:** `php artisan key:generate`.

---

## ملاحظات

- قاعدة البيانات SQLite محليًا ولا تتطلب خادم DB خارجي.
- نظام عمل بالكامل بواجهة عربية RTL، صالح للعرض التجريبي والاستخدام الفعلي على الشبكة الداخلية.
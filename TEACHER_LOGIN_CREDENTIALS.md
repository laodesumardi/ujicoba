# Teacher Login Credentials

## 🔐 Login Information

### **Login URL:**
```
http://localhost:8000/teacher/login
```

### **Available Teachers:**

#### 1. Ahmad Susanto (Kepala Sekolah)
- **Email:** `ahmad.susanto@smpnamrole.sch.id`
- **Password:** `password123`
- **Role:** `teacher`
- **Position:** Kepala Sekolah

#### 2. Siti Nurhaliza (Wakil Kepala Sekolah)
- **Email:** `siti.nurhaliza@smpnamrole.sch.id`
- **Password:** `password123`
- **Role:** `teacher`
- **Position:** Wakil Kepala Sekolah

#### 3. Budi Santoso (Guru IPA)
- **Email:** `budi.santoso@smpnamrole.sch.id`
- **Password:** `password123`
- **Role:** `teacher`
- **Position:** Guru

#### 4. Rina Wulandari (Guru Bahasa Inggris)
- **Email:** `rina.wulandari@smpnamrole.sch.id`
- **Password:** `password123`
- **Role:** `teacher`
- **Position:** Guru

#### 5. Eko Prasetyo (Guru IPS)
- **Email:** `eko.prasetyo@smpnamrole.sch.id`
- **Password:** `password123`
- **Role:** `teacher`
- **Position:** Guru

#### 6. Test Teacher (Test Account)
- **Email:** `test.teacher@smpnamrole.sch.id`
- **Password:** `testpassword123`
- **Role:** `teacher`
- **Position:** Guru

## 🚀 How to Use

1. **Go to:** `http://localhost:8000/teacher/login`
2. **Enter any email and password from the list above**
3. **Click "Masuk"**
4. **You will be redirected to:** `http://localhost:8000/teacher/dashboard`

## 📝 Creating New Teachers

### **Via Admin Panel:**
1. Go to: `http://localhost:8000/admin/teachers/create`
2. Fill in all required fields including:
   - Email (will be used for login)
   - Password (min 8 characters)
   - Password Confirmation
3. Submit the form
4. The teacher can immediately login with the provided credentials

### **Via Database Seeder:**
```bash
php artisan db:seed --class=TeacherSeeder
```

## 🔧 Technical Details

- **Authentication Guard:** `teacher`
- **Model:** `App\Models\Teacher`
- **Password Hashing:** Automatic with Laravel Hash
- **Session Management:** Laravel Session
- **Middleware:** `auth:teacher`

## 🛠️ Troubleshooting

### **"These credentials do not match our records"**
1. Check if teacher exists in database
2. Verify email is correct
3. Check if teacher is active (`is_active = true`)
4. Verify password is hashed correctly

### **"Teacher not found"**
1. Run seeder: `php artisan db:seed --class=TeacherSeeder`
2. Check database connection
3. Verify migration has run: `php artisan migrate:status`





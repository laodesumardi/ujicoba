# Teacher Login Guide

## 🔐 **Login dengan Data Form Create Teacher**

### **Step-by-Step Guide:**

#### **1. Buat Guru Baru via Form:**
1. **Buka:** `http://localhost:8000/admin/teachers/create`
2. **Isi semua field yang required:**
   - NIP: `FORM123456789`
   - Nama: `Test Teacher`
   - Email: `test.teacher@smpnamrole.sch.id`
   - Password: `testpassword123`
   - Konfirmasi Password: `testpassword123`
   - Education: `S1 Test Education`
   - Type: `Teacher`
3. **Klik "Simpan"**

#### **2. Login dengan Data yang Dibuat:**
1. **Buka:** `http://localhost:8000/teacher/login`
2. **Email:** `test.teacher@smpnamrole.sch.id`
3. **Password:** `testpassword123`
4. **Klik "Masuk"**
5. **Akan redirect ke:** `/teacher/dashboard`

### **🔍 Troubleshooting:**

#### **"These credentials do not match our records"**
1. **Periksa email** - pastikan sama persis dengan yang diisi di form
2. **Periksa password** - pastikan sama persis dengan yang diisi di form
3. **Periksa database** - pastikan data tersimpan di database

#### **"Teacher not found"**
1. **Periksa form submission** - pastikan form berhasil disubmit
2. **Periksa validation** - pastikan tidak ada error validation
3. **Periksa database** - jalankan query untuk cek data

### **📋 Test Credentials yang Bekerja:**

| No | Email | Password | Status |
|----|-------|----------|--------|
| 1 | `user1@gmail.com` | `password123` | ✅ Working |
| 2 | `formtest1760731438@smpnamrole.sch.id` | `formtest123` | ✅ Working |

### **🛠️ Debug Commands:**

```bash
# Check total teachers
php artisan tinker --execute="echo App\Models\Teacher::count();"

# Check latest teacher
php artisan tinker --execute="App\Models\Teacher::latest()->first();"

# Test authentication
php artisan tinker --execute="
\$teacher = App\Models\Teacher::latest()->first();
\$credentials = ['email' => \$teacher->email, 'password' => 'your_password'];
echo \Illuminate\Support\Facades\Auth::guard('teacher')->attempt(\$credentials) ? 'SUCCESS' : 'FAILED';
"
```

### **✅ Form Create Teacher Features:**

- **Password validation** dengan confirmation
- **Real-time validation** di JavaScript
- **Automatic role assignment** sebagai 'teacher'
- **Password hashing** otomatis
- **All required fields** dengan validation

### **🎯 Expected Behavior:**

1. **Form submission** → Data tersimpan di database
2. **Password hashing** → Password di-hash dengan bcrypt
3. **Role assignment** → Role diset sebagai 'teacher'
4. **Login** → Bisa login dengan email dan password yang dibuat
5. **Dashboard** → Redirect ke teacher dashboard

**Data yang diisi dari form create teacher sekarang bisa langsung digunakan untuk login!** 🎉✨

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDBRegistration extends Model
{
    protected $table = 'ppdb_registrations';
    
    protected $fillable = [
        'registration_number',
        'student_name',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'address',
        'phone_number',
        'email',
        'parent_name',
        'parent_phone',
        'parent_occupation',
        'previous_school',
        'achievements',
        'motivation',
        'photo',
        'birth_certificate',
        'family_card',
        'report_card',
        'status',
        'notes',
        'student_username',
        'student_password'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Generate nomor pendaftaran otomatis
    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $lastRegistration = self::whereYear('created_at', $year)
                              ->orderBy('id', 'desc')
                              ->first();
        
        $number = $lastRegistration ? 
                  (int)substr($lastRegistration->registration_number, -4) + 1 : 1;
        
        return 'PPDB' . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Relationship dengan User (jika ada user yang terkait)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship dengan User berdasarkan email
    public function userByEmail()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}

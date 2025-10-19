<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'role',
        'student_id',
        'teacher_id',
        'class_level',
        'class_section',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'religion',
        'previous_school',
        'previous_school_address',
        'graduation_year',
        'transfer_reason',
        'blood_type',
        'allergies',
        'medical_conditions',
        'parent_name',
        'parent_phone',
        'parent_email',
        'is_active',
        // Teacher fields
        'subject',
        'position',
        'employment_status',
        'join_date',
        'education',
        'certification',
        'experience_years',
        'bio',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'join_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'student_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    public function forumPosts()
    {
        return $this->hasMany(Forum::class, 'author_id');
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }

    // Scopes
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getRoleLabelAttribute()
    {
        $roles = [
            'admin' => 'Administrator',
            'teacher' => 'Guru',
            'student' => 'Siswa'
        ];
        
        return $roles[$this->role] ?? ucfirst($this->role);
    }

    public function getIsStudentAttribute()
    {
        return $this->role === 'student';
    }

    public function getIsTeacherAttribute()
    {
        return $this->role === 'teacher';
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Check if it's a storage path with 'storage/' prefix
            if (strpos($this->photo, 'storage/') === 0) {
                return asset($this->photo);
            }
            // Check if it's a storage path without 'storage/' prefix
            if (strpos($this->photo, 'teachers/') === 0) {
                return asset('storage/' . $this->photo);
            }
            // Check if it's just a filename (old format)
            if (!strpos($this->photo, '/') && !strpos($this->photo, 'storage/')) {
                return asset('storage/teachers/' . $this->photo);
            }
            // If it's already a full URL or path
            return $this->photo;
        }
        
        // Return default teacher image
        return asset('images/default-teacher.png');
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }
}

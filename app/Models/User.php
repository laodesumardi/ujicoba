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
        // Cache-busting versi berdasarkan updated_at
        $version = $this->updated_at ? $this->updated_at->timestamp : time();

        // Fallback default berdasarkan role
        if (!$this->photo || trim($this->photo) === '') {
            if ($this->role === 'student') {
                return asset('images/default-student.png');
            } elseif ($this->role === 'teacher') {
                return asset('images/default-teacher.png');
            } else {
                return asset('images/default-user.png');
            }
        }
        
        // URL eksternal
        if (filter_var($this->photo, FILTER_VALIDATE_URL) ||
            str_starts_with($this->photo, 'http://') ||
            str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }
        
        // Normalisasi path
        $path = $this->photo;
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        $folder = '';
        $filename = '';
        
        // Folder yang diketahui
        if (str_starts_with($path, 'teachers/')) {
            $folder = 'teachers';
            $filename = basename($path);
        } elseif (str_starts_with($path, 'students/photos/')) {
            $folder = 'students/photos';
            $filename = basename($path);
        } else {
            // Split generik
            $filename = basename($path);
            $dir = trim(dirname($path), '.');
            $dir = str_replace('\\', '/', $dir);
            if ($dir && $dir !== '') {
                $folder = $dir;
            } else {
                $folder = $this->role === 'teacher' ? 'teachers' : ($this->role === 'student' ? 'students/photos' : 'users/photos');
            }
        }
        
        // Bangun route direct serve dengan cache-busting
        return route('image.serve', [
            'folder' => $folder,
            'filename' => $filename,
            'v' => $version,
        ]);
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }
}

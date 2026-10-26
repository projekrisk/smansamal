<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_type',
        'avatar',
        'bio',
        'nisn',
        'kelas',
        'nip',
        'mata_pelajaran',
        'tahun_lulus',
        'pekerjaan_kampus',
        'is_active',
        'activated_at',
        'email_verified_at',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->username) && ! empty($user->name)) {
                $base = Str::slug($user->name) ?: 'warga';
                $username = $base;
                $counter = 1;
                while (static::where('username', $username)->exists()) {
                    $username = "{$base}-{$counter}";
                    $counter++;
                }
                $user->username = $username;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function getProfileUrlAttribute(): string
    {
        return route('warga.profile', $this->username ?: $this->id);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'activated_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id')->withTimestamps();
    }

    public function isFollowedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }

            return asset('uploads/'.ltrim($this->avatar, '/'));
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=2A5C43&color=ffffff&size=160&bold=true';
    }

    public function getRoleBadgeAttribute(): array
    {
        return match ($this->role_type) {
            'siswa' => ['label' => 'Siswa Aktif', 'class' => 'bg-forest/10 text-forest'],
            'guru' => ['label' => 'Guru / Staf', 'class' => 'bg-stone-800 text-white'],
            'alumni' => ['label' => 'Alumni', 'class' => 'bg-terracotta/10 text-terracotta'],
            'admin' => ['label' => 'Admin Sekolah', 'class' => 'bg-forest text-white'],
            'super_admin' => ['label' => 'Super Admin', 'class' => 'bg-stone-900 text-white'],
            default => ['label' => 'Warga Sekolah', 'class' => 'bg-stone-200 text-stone-700'],
        };
    }

    public function getRoleDetailAttribute(): string
    {
        return match ($this->role_type) {
            'siswa' => $this->kelas ? "Kelas {$this->kelas}" : 'Siswa SMAN 1 Malingping',
            'guru' => $this->formatGuruStaffDetail(),
            'alumni' => $this->tahun_lulus ? "Alumni Angkatan {$this->tahun_lulus}" : 'Alumni SMAN 1 Malingping',
            'admin', 'super_admin' => 'Pengelola Portal',
            default => 'Warga SMAN 1 Malingping',
        };
    }

    protected function formatGuruStaffDetail(): string
    {
        if (empty($this->mata_pelajaran)) {
            return 'Guru / Staf Pegawai';
        }

        $val = trim($this->mata_pelajaran);

        if (preg_match('/^(guru|staf|staff|pegawai|tenaga|kepala|tata usaha|tu|laboran|pustakawan)/i', $val)) {
            return $val;
        }

        return "Guru {$val}";
    }

    public function getTotalLikesAttribute(): int
    {
        return (int) $this->articles()->published()->sum('likes_count');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['Admin', 'Super Admin']) || in_array($this->role_type, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin') || $this->role_type === 'super_admin';
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }
}

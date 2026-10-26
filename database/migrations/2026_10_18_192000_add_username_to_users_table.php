<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        $users = User::all();
        foreach ($users as $user) {
            if (empty($user->username)) {
                $base = Str::slug($user->name) ?: 'warga';
                $username = $base;
                $counter = 1;
                while (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $username = "{$base}-{$counter}";
                    $counter++;
                }
                $user->username = $username;
                $user->save();
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};

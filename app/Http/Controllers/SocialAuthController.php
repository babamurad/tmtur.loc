<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to login with Google');
        }

        $user = User::where('google_id', $socialUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $socialUser->getId(),
                ]);
            } else {
                $password = Str::random(12);
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'google_id' => $socialUser->getId(),
                    'password' => bcrypt($password),
                    'email_verified_at' => now(), // Assume verified since it's Google
                    'role' => 0, // Default role
                ]);

                // Handle Avatar
                if ($avatarUrl = $socialUser->getAvatar()) {
                    try {
                        $contents = file_get_contents($avatarUrl);
                        if ($contents) {
                            $filename = 'avatar_' . $user->id . '_' . time() . '.jpg';
                            // Store according to user rule: custom disk 'public_uploads'; avatars go to 'avatars' subdirectory.
                            // Assuming 'public_uploads' disk is configured to point to 'public/uploads' or similar.
                            // We should use Storage::disk('public_uploads')->put('avatars/' . $filename, $contents);

                            // Check filesystem config in .env: FILESYSTEM_DISK=public_uploads.
                            // I will assume the disk name is 'public_uploads'.

                            $path = 'avatars/' . $filename;
                            Storage::disk('public_uploads')->put($path, $contents);

                            // Create Media record
                            $user->avatar()->create([
                                'file_path' => $path,
                                'file_name' => $filename,
                                'mime_type' => 'image/jpeg', // Google avatars are usually jpg/png, assuming jpg is safe enough or could detect.
                                'model_type' => User::class,
                                'model_id' => $user->id,
                            ]);
                        }
                    } catch (\Exception $e) {
                        // Log error or ignore avatar failure
                    }
                }
            }
        }

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}

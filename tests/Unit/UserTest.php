<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Notifications\PasswordNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function send_email_to_register_password()
    {
        $user = factory(User::class)->create();
        $token = Str::random(64);
        Notification::fake();
        Notification::send($user, new PasswordNotification($token));
        Notification::assertSentTo($user, PasswordNotification::class);
    }
}

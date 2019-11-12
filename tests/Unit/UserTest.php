<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\Notifications\PasswordNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;
    /** @test */
    public function send_email_to_register_password()
    {
        $this->withoutExceptionHandling();
		$user = factory(User::class)->create();
		Notification::fake();
		Notification::send($user, new PasswordNotification('teste'));
		Notification::assertSentTo($user, PasswordNotification::class);
    }
}

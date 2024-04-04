<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Facades\DumperServiceFacade as Dumper;

/**
 * Controller for developers use only
 * To track execution time use $this-t()
 * To dump values use $this->d
 * Set up _authorize() to you needs
 * See example() as an example of usage
 *
 */
class DevController extends Controller
{
    use \App\Traits\DevTrait;

    private function test()
    {
        $d = [];

        $games = \App\Models\Game::all();

        foreach ($games as $game) {
            $game->update([
                'meta_title' => $game->name,
                'meta_description' => substr(strip_tags($game->description), 0, 135) . '...',
            ]);
        }

        dd($d);
    }

    private function example()
    {
        $this->enableQueryLog();

        $this->d('creating 1000 els array and collection...');

        $array = range(-500, 500);
        shuffle($array);

        $colleciton = collect($array);

        $this->d('starting sorting...');
        $this->setFullStart();

        sort($array);

        $this->t('array_sort');

        $colleciton->sort();

        $this->t('collection_sort');
        $this->d('sorting done.');

        return $array;
    }

    // dummy public method.
    // can be used to showcase some functionality to external user.
    private function public()
    {
        return "Hello from devs!";
    }

    // test emails
    private function emails()
    {
        $t = request()->type;
        $email = request()->email;

        if ($t == 'welcome') {
            $user = User::find(1);
            $mail = new \App\Mail\WelcomeMail($user);
        }
        if ($t == 'password-reset') {
            $url = url('');
            $mail = new \App\Mail\PasswordReset($url);
        }
        if ($t == 'verify') {
            $url = url('');
            $mail = new \App\Mail\TmpMail($url);
        };
        if ($t == 'mailer') {
            $posts = Post::inRandomOrder()->limit(4)->get();
            $mailer = \App\Models\Mailer::first();
            $mail = new \App\Mail\MailerPostFound($mailer, $posts);
        };
        if ($t == 'tba-non-reg') {
            $user = User::find(12);
            $post = Post::find(371);
            $mail = new \App\Mail\PostTbaForNonReg($post, $user, 'test message');
        };
        if ($t == 'sub-created') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $mail = new \App\Mail\Subscriptions\Created($cycle);
        };
        if ($t == 'sub-canceled-cause-new') {
            $sub = \App\Models\Subscription::find(13);
            $group = \App\Enums\NotificationGroup::SUB_CANCELED_TERMINATED_CAUSE_NEW;
            $group = \App\Enums\NotificationGroup::SUB_TERMINATED_CAUSE_NEW;
            $mail = new \App\Mail\Subscriptions\CanceledCauseNew($sub, $group);
        };
        if ($t == 'sub-extended') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $group = \App\Enums\NotificationGroup::SUB_EXTENDED;
            $group = \App\Enums\NotificationGroup::SUB_EXTENDED_INCOMPLETE;
            $mail = new \App\Mail\Subscriptions\Extended($cycle, $group);
        };
        if ($t == 'sub-extend-failed') {
            $sub = \App\Models\Subscription::find(13);
            $mail = new \App\Mail\Subscriptions\ExtentionFailed($sub);
        };
        if ($t == 'sub-canceled-expired') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $mail = new \App\Mail\Subscriptions\CanceledExpired($cycle);
        };
        if ($t == 'sub-incompleted-expired') {
            $sub = \App\Models\Subscription::find(13);
            $mail = new \App\Mail\Subscriptions\IncompletedExpired($sub);
        };
        if ($t == 'sub-incompleted-paid') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $mail = new \App\Mail\Subscriptions\IncompletedPaid($cycle);
        };
        if ($t == 'sub-canceled') {
            $sub = \App\Models\Subscription::find(13);
            $mail = new \App\Mail\Subscriptions\Canceled($sub);
        };
        if ($t == 'sub-end-in-7-days') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $group = \App\Enums\NotificationGroup::SUB_RENEW_NEXT_WEEK;
            $group = \App\Enums\NotificationGroup::SUB_END_NEXT_WEEK;
            $mail = new \App\Mail\Subscriptions\EndNextWeek($cycle, $group);
        };
        if ($t == 'sub-end-tomorrow') {
            $cycle = \App\Models\SubscriptionCycle::find(12);
            $group = \App\Enums\NotificationGroup::SUB_END_TOMORROW;
            $group = \App\Enums\NotificationGroup::SUB_RENEW_TOMORROW;
            $mail = new \App\Mail\Subscriptions\EndTomorrow($cycle, $group);
        };
        if ($t == 'daily-posts-views-for-non-reg') {
            $user = User::find(14);
            $count = 17;
            $posts = Post::whereIn('id', [527, 526])->get();
            $mail = new \App\Mail\DailyPostViewsForNonReg($user, $count, $posts);
        };
        if ($t == 'daily-contact-views-for-non-reg') {
            $user = User::find(14);
            $count = 17;
            $mail = new \App\Mail\DailyContactViewsForNonReg($user, $count);
        };
        if ($t == 'daily-profile-views-for-non-reg') {
            $user = User::find(14);
            $count = 17;
            $mail = new \App\Mail\DailyProfileViewsForNonReg($user, $count);
        };
        if ($t == 'weekly-posts-views-for-non-reg') {
            $user = User::find(14);
            $count = 42;
            $posts = Post::whereIn('id', [527, 526])->get();
            $mail = new \App\Mail\WeeklyPostViewsForNonReg($user, $count, $posts);
        };

        // other emails test here...

        if (!isset($mail)) {
            dd('ERROR: mail not found');
        }

        if ($email) {
            Mail::to($email)->send($mail);
        }

        return $mail;
    }

    // login to user by ID (login to admin by default)
    private function login()
    {
        $user = request()->user;

        if (!$user) {
            $user = User::whereIn('email', ['admin@mail.com', 'admin@admin.com'])->first();
            if (!$user) {
                // todo add belongsTo relation check
                $user = User::whereHas('roles', function ($q) {
                    $q->where('name', 'admin');
                })->first();
            }
            if (!$user) {
                dump('Admin user not found. Please provide user_id manualy');
                dd(User::all());
            }
        } else {
            $user = User::find($user);
        }

        auth()->login($user);

        return redirect('/');
    }

    // get phpinfo
    private function phpinfo()
    {
        phpinfo();
    }
}

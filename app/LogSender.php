<?php

namespace App;

use App\Mail\LogEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LogSender extends Model
{
    public function send(array $admins, array $options, string $operator, string $greeting, string $footer)
    {
        if ($admins['email'][0] == 'all') {
            $admins['email'] = Admin::all()->pluck('email');
        }

        collect($admins['email'])->each(function ($value, $key) use ($options, $operator, $greeting, $footer) {
            $admin = Admin::whereEmail($value)->first();
            if (!is_null($admin)) {
                if ($options['queue']) {
                    Log::info("Log email sent to {$admin->name} via queue");
                    Mail::to($admin)->queue(new LogEmail($admin, $operator, $greeting, $footer));
                } else {
                    Log::info("Log email sent to {$admin->name}");
                    Mail::to($admin)->send(new LogEmail($admin, $operator, $greeting, $footer));
                }
            }
        });
    }
}

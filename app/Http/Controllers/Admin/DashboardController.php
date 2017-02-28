<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Portfolio;
use App\Screenshot;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (Cache::has('admin_name')) {
            $admin = Cache::get('admin_name');
        } else {
            $admin = auth()->user()->name;
            $expiresAt = Carbon::now()->addMinutes(10); // or put number in minute
            Cache::put('admin_name', $admin, $expiresAt);
        }

        $user = new User();
        // store default to cache if stat_user does not exist for 5 minutes
        $users = Cache::remember('stat_user', 5, function () use ($user) {
            return $user->count();
        });
        // get default from Closure but do not store to cache
        $users_activated = Cache::get('stat_user_activated', function () use ($user) {
            $activated = $user->activated()->count();
            Cache::put('stat_user_activated', $activated, 5);
            return $activated;
        });

        $showcase = new Portfolio();
        $showcases = Cache::get('stat_showcase', function () use ($showcase) {
            return $showcase->count();
        });
        $showcases_view = Cache::get('stat_showcase_view', function () use ($showcase) {
            return $showcase->sum('view');
        });

        // store if not present
        Cache::add('stat_showcase', $showcases, 10);
        Cache::add('stat_showcase_view', $showcases_view, 10);

        $screenshot = new Screenshot();
        $screenshots = Cache::remember('stat_screenshot', 5, function () use ($screenshot) {
            return $screenshot->count();
        });
        $screenshots_size = Cache::remember('stat_screenshot_size', 5, function () use ($screenshot) {
            return $this->getScreenshotSize();
        });

        $companies = Cache::remember('stat_company', 5, function () use ($showcase) {
            return $showcase->select('company')->groupBy('company')->get()->count();
        });

        $category = new Category();
        $categories = Cache::remember('stat_category', 5, function () use ($category) {
            return $category->count();
        });

        $tag = new Tag();
        $tags = Cache::remember('stat_tag', 5, function () use ($tag) {
            return $tag->count();
        });

        $portfolios_deleted = Cache::remember('stat_trash', 5, function () use ($showcase) {
            return $showcase->onlyTrashed()->count();
        });

        $log_lines = Cache::remember('stat_log', 5, function () {
            $file = storage_path('logs/laravel.log');
            $log_lines = 0;
            $handle = fopen($file, "r");
            while (!feof($handle)) {
                // $line = fgets($handle);
                $log_lines++;
                if ($log_lines == 10000) {
                    break;
                }
            }
            fclose($handle);
            return $log_lines;
        });

        return view('admin.dashboard.index', compact('admin', 'users', 'users_activated', 'showcases',
            'showcases_view', 'screenshots', 'screenshots_size', 'companies',
            'categories', 'tags', 'log_lines', 'portfolios_deleted'));
    }

    public function getScreenshotSize()
    {
        $files_with_size = array();
        $files = Storage::disk('local')->files('public/screenshots');

        foreach ($files as $key => $file) {
            $files_with_size[$key]['name'] = $file;
            $files_with_size[$key]['size'] = Storage::disk('local')->size($file);
        }

        $total = array_sum(array_map(function ($item) {
            return $item['size'];
        }, $files_with_size));

        return number_format($total / 1048576, 2);
    }

}

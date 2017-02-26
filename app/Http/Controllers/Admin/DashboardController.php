<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Portfolio;
use App\Screenshot;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = new User();
        $users = $user->count();
        $users_activated = $user->activated()->count();

        $showcase = new Portfolio();
        $showcases = $showcase->count();
        $showcases_view = $showcase->sum('view');

        $screenshot = new Screenshot();
        $screenshots = $screenshot->count();
        $screenshots_size = $this->getScreenshotSize();

        $companies = $showcase->select('company')->groupBy('company')->get()->count();

        $category = new Category();
        $categories = $category->count();

        $tag = new Tag();
        $tags = $tag->count();

        $portfolios_deleted = $showcase->onlyTrashed()->count();

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

        return view('admin.dashboard.index', compact('users', 'users_activated', 'showcases',
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

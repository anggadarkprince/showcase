<?php

namespace App\Http\Controllers;

use App\Screenshot;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class ScreenshotController extends Controller
{
    public function deleteScreenshot(User $user, Screenshot $screenshot)
    {
        return DB::transaction(function() use($user, $screenshot){
            $errorMessage = 'Delete image record failed';

            try{
                $deleteRecord = $screenshot->delete();

                $deleteFile = Storage::delete("public/screenshots/{$screenshot->source}");

                if(!$deleteFile){
                    $errorMessage = 'Delete image file failed';
                }

                if(!$deleteFile || !$deleteRecord){
                    return redirect()->back()->withErrors([
                        'error' => $errorMessage
                    ]);
                }

                return redirect()->back()->with([
                    'action' => 'success',
                    'message' => "{$screenshot->source} was successfully deleted"
                ]);
            }
            catch (Exception $e){
                if(!$deleteFile || !$deleteRecord){
                    return redirect()->back()->withErrors([
                        'error' => $errorMessage
                    ]);
                }
            }
        });
    }
}

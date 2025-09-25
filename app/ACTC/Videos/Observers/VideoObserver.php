<?php

declare(strict_types=1);

namespace ACTC\Videos\Observers;

use ACTC\Videos\Video;
use Illuminate\Support\Facades\Storage;

class VideoObserver
{
    public function forceDeleted(Video $video): void
    {
        // delete the file when the video has been deleted
        if (Storage::disk('local')->exists($video->thumbnail)) {
            Storage::disk('local')->delete($video->thumbnail);
        }
    }
}

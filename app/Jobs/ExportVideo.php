<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ExportVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $extension;
    private $width;
    private $height;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, string $extension)
    {
        $this->extension = $extension;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $video = FFMpeg::open('public/tempVideos/'.$this->url.'.'.$this->extension);
        $lowBitrate = (new X264)->setKiloBitrate(1500);
        $medBitrate = (new X264)->setKiloBitrate(2000);
        $highBitrate = (new X264)->setKiloBitrate(2500);

        $video
        ->exportForHLS()
        ->addFormat($lowBitrate, function($media){
            $media->addFilter('scale=-2:480');
        })
        ->addFormat($medBitrate, function($media){
            $media->addFilter('scale=-2:720');
        })
        ->addFormat($highBitrate, function($media){
            $media->addFilter('scale=-2:1080');
        })
        ->save('public/videos/'.$this->url.'/'.$this->url.'.m3u8');

        $video = FFMpeg::open('public/tempVideos/'.$this->url.'.'.$this->extension);
        $duration = $video->getDurationInSeconds();
        $video->getFrameFromSeconds((int)($duration/2))
        ->export()
        ->save('public/thumbnails/'.$this->url.'/'.$this->url.'_original.png');
        
        File::delete(storage_path().'\\app\\public\\tempVideos\\'.$this->url.'.'.$this->extension);
    }
}
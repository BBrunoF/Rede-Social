<?php

namespace App\Http\Livewire\Posts;

use App\Models\Media;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;

class Create extends Component
{
    use WithFileUploads;

    public $postId;

    public $title;

    public $body;

    public $file;

    public $path;

    public $latitude;

    public $longitude;

    public $proceed;

    public $location;

    public $imageFormats = ['jpg', 'png', 'gif', 'jpeg'];

    public $videoFormats = ['mp4', '3gp'];

    public function mount()
    {
        $ipAddress = $this->getIp();
        $position = Location::get($ipAddress);

        if ($position) {
            $this->location = $position->cityName . '/' . $position->regionCode;
        } else {
            $this->location = null;
        }
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'mimes:' . implode(',', array_merge($this->imageFormats, $this->videoFormats)) . '|max:20000',
        ]);
    }

    public function submit()
    {   
        if(auth()->user()->role_id!==3){
        $data = $this->validate([
            'title' => 'required|max:50',
            'location' => 'nullable|string|max:60',
            'body' => 'required|max:1000',
            'file' => 'nullable|mimes:' . implode(',', array_merge($this->imageFormats, $this->videoFormats)) . '|max:20000',
        ]);
        if($this->file){
        $this->path = $this->file->store('post-photos', 'public');

        $imageLocation = $this->get_image_location("storage/".$this->path);
        }
        if($this->proceed==1 && ($this->latitude!=0 || $this->longitude!=0)){
            $locationImageExtracted = $this->latitude.",".$this->longitude;
            $post = Post::create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'location' => $locationImageExtracted,
                'body' => $data['body'],
            ]);

            
        } else {
            $post = Post::create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'location' => $data['location'],
                'body' => $data['body'],
            ]);

    }

        $this->storeFiles($post);

        session()->flash('success', 'Post created successfully');

        return redirect('home');
    } else {
        session()->flash('error', 'You are banned');

        return redirect('home');
    }

    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.posts.create');
    }

    /**
     * @param $post
     * @return bool|void
     */
    private function storeFiles($post)
    {
        if (empty($this->file)) {
            return true;
        }
        

        $isImage = preg_match('/^.*\.(png|jpg|gif)$/i', $this->path );

        Media::create([
            'post_id' => $post->id,
            'path' => $this->path ,
            'is_image' => $isImage,
        ]);
    }

    private function gps2Num($coordPart)
        {
            $parts = explode('/', $coordPart);
            if (count($parts) <= 0)
                return 0;
            if (count($parts) == 1)
                return $parts[0];
            if(floatval($parts[1])!=0){
            return floatval($parts[0]) / floatval($parts[1]);
            }
        }

    private function get_image_location($image)
        {
            $exif = exif_read_data($image);
            if ($exif && isset($exif['GPSLatitude'])) {
                $GPSLatitudeRef = $exif['GPSLatitudeRef'];
                $GPSLatitude = $exif['GPSLatitude'];
                $GPSLongitudeRef = $exif['GPSLongitudeRef'];
                $GPSLongitude = $exif['GPSLongitude'];

                $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
                $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
                $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;

                $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
                $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
                $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;

                $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
                $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

                $this->latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
                $this->longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));
                $this->proceed = 1;
                
            } else {
                $this->proceed = 0;
            }
        }

    private function getIp(): ?string
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}

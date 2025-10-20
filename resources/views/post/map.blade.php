<?php
    $coords=explode(",", $post->location);
    $latitude = $coords[0];
    $longitude = $coords[1];
    
?>
<livewire:map-component latitude="{{ $latitude }}" longitude="{{ $longitude }}" />

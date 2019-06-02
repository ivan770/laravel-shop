<?php

namespace App\Http\Resources;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $storage = app(FilesystemManager::class);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'image' => $this->image ? $storage->disk('public')->url($this->image) : null,
        ];
    }
}

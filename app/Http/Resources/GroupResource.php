<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner' => $this->user->name,
            'name' => $this->name,
            'description' => $this->description ?? 'No description provided...',
            'date_created' => $this->created_at->format('jS F, Y'),
            'last_updated' => $this->updated_at->format('jS F, Y'),
        ];
    }
}

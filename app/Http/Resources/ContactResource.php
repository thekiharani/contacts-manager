<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'date_created' => $this->created_at->format('jS M, Y'),
            'last_updated' => $this->updated_at->format('jS M, Y'),
        ];
    }
}

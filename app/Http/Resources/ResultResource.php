<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'correct_answer' => $this->correct_answer,
            'wrong_answer' => $this->wrong_answer,
            'user_attempts' => $this->user_attempts,
            'paper_id' =>  $this->whenLoaded('paper', function () {
                return $this->paper->id;
            }),
            'paper_name' =>  $this->whenLoaded('paper', function () {
                return $this->paper->name;
            }),
            'subject_name' =>  $this->whenLoaded('subject', function () {
                return $this->subject->name;
            })

        ];
    }
}

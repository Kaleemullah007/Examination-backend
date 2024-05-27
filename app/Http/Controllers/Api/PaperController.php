<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubjectIdRequest;
use App\Http\Resources\PaperResource;
use App\Models\Paper;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectIdRequest $request)
    {
        $papers =    Paper::withCount('question')->where('subject_id', $request->subject_id)->paginate($this->per_page);

        return  PaperResource::collection($papers);
    }
}

<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Http\Requests\StoreFolderRequest;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FileResource;

class FileController extends Controller
{
    public function myFiles()
    {
        $folder = $this->getRoot();

        $files = File::query()
        ->where('parent_id', $folder->id)
        ->where('created_by', Auth::id())
        ->orderBy('is_Folder', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $files = FileResource::collection($files);
        return Inertia::render('MyFiles', compact('files'));
    }

    public function createFolder(StoreFolderRequest $request)
    {
       
        $data = $request->validated();
        $parent = $request->parent;
        

        if (!$parent) {
            $parent = $this->getRoot();
        }

        \Log::info('Creating folder', ['data' => $data, 'parent_id' => $parent->id]);
        $file = new File();
        $file->is_folder = 1;
        $file->name = $data['name'];

        $parent->appendNode($file);
        \Log::info('Parent ID in controller:', ['parent_id' => $request->input('parent_id')]);
    }

    private function getRoot()
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::id())->firstOrFail();
    }

}


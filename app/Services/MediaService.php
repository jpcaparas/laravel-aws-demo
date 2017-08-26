<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class Media
 *
 * @package App\Services
 */
class MediaService
{
    /**
     * @param Request $request
     *
     * @return Media
     *
     * @throws \Throwable
     * @throws \RuntimeException
     */
    public function create(Request $request)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');
        $path = $file->store('uploads/videos');

        if (empty($path) === true) {
            throw new \RuntimeException('Failed to upload file.');
        }

        // Save Media to DB
        $media = new Media();
        $media->name = $request->input('name');
        $media->path = $path;
        $media->mime_type = $file->getMimeType();
        $media->size = $file->getSize();

        $media->saveOrFail();

        return $media;
    }

    /**
     * @param Media $media
     *
     * @return bool
     */
    public function delete(Media $media)
    {
        $path = $media->path;
        $result = $media->delete();

        if ($result === false) {
            return $result;
        }

        Storage::delete($path);

        return true;
    }
}

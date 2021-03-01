<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Storage;
use Image;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $type
 * @property string $upload_title
 * @property string $server_title
 * @property string $path
 * @property int $download
 * @property int $size
 * @property int|null $width
 * @property int|null $height
 * @property string $extension
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDownload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereServerTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUploadTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withoutTrashed()
 * @mixin \Eloquent
 */
class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'upload_title',
        'server_title',
        'path',
        'download',
        'size',
        'width',
        'height',
        'extension',
    ];

    protected $hidden = [

    ];


    public function posts()
    {
        return $this->morphedByMany('App\Models\File', 'fileable');
    }

    public function users()
    {
        return $this->morphedByMany('App\Models\File', 'fileable');
    }

    public static function getStorageDisk()
    {
        return Storage::disk(\App::environment('local') ? 'public' : 's3');
    }

    public static function createCover($fileData, $folder = 'cover', $type = 'main_cover')
    {
        try {
            if ($path = File::data64($fileData)) {
                $fileData = $path;
            }
        } catch (\Exception $e) {
        }

        try {
            // 이미지 변환  (16 : 9)
            // recommend (1280 * 720)
            // large     (640 * 360)
            // middle    (320 * 180)
            // small     (160 * 90)
            $resolutions = [
                'recommend' => ['width' => 1280, 'height' => 720],
                'large'     => ['width' => 640, 'height' => 360],
                'middle'    => ['width' => 320, 'height' => 180],
                'small'     => ['width' => 160, 'height' => 90]
            ];

            if (gettype($fileData) == 'string') {
                $url = $fileData;
                $orignalNme  = explode('/', $url);
                $orignalNme  = end($orignalNme);

                $extension  = explode('.', $url);
                $extension  = end($extension);
            } else {
                $orignalNme = $fileData->getClientOriginalName();


                $extension  = explode('.', $orignalNme);
                $extension  = end($extension);
            }

            $orignalImg = Image::make($fileData);

            $files = [];
            foreach ($resolutions as $key => $value) {

                $name = $key;
                $file = File::imageResize($orignalImg, $value['width'], $value['height'], $folder, $name, $extension);

                $files[] = File::create([
                    'type'          => $type,
                    'upload_title'  => $orignalNme,
                    'server_title'  => $file['name'],
                    'path'          => $file['path'],
                    'size'          => $orignalImg->filesize(),
                    'width'         => $orignalImg->width(),
                    'height'        => $orignalImg->height(),
                    'extension'     => $extension
                ]);
            }

            return $files;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function data64($data)
    {
        try {
            $type = '';
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    throw new \Exception('invalid image type');
                }

                $data = base64_decode($data);

                if ($data === false) {
                    throw new \Exception('base64_decode failed');
                }
            } else {
                throw new \Exception('did not match data URI with image data');
            }
        } catch (\Exception $e) {
            return null;
        }

        $path = "/tmp/img.{$type}";
        file_put_contents($path, $data);

        return $path;
    }

    public static function createFile($fileData, $folder, $type, $name, $width = null, $height = null)
    {
        if ($path = File::data64($fileData)) {
            $fileData = $path;
        }

        if (gettype($fileData) == 'string') {
            $url = $fileData;
            $orignalNme  = explode('/', $url);
            $orignalNme  = end($orignalNme);

            $extension  = explode('.', $url);
            $extension  = end($extension);
        } else {
            $orignalNme = $fileData->getClientOriginalName();

            $extension  = explode('.', $orignalNme);
            $extension  = end($extension);
        }

        try {
            $orignalImg = Image::make($fileData);

            if (!isset($width)) {
                $width = $orignalImg->width();
            }

            if (!isset($height)) {
                $height = $orignalImg->height();
            }

        } catch (\Exception $e) {
            throw new \Exception(['code' => $e->getCode(), 'msg' => $e->getMessage()], 1);
        }


        $radio = 16/9;

        if ($folder == 'profile') {
            $radio = 1/1;
        }

        $file = File::imageResize($orignalImg, $width, $height, $folder, $name, $extension, $radio);

        try {
            $files = File::create([
                'type'          => $type,
                'upload_title'  => $orignalNme,
                'server_title'  => $file['name'],
                'path'          => $file['path'],
                'size'          => $orignalImg->filesize(),
                'width'         => $orignalImg->width(),
                'height'        => $orignalImg->height(),
                'extension'     => $extension,
            ]);
        } catch (\Exception $e) {
            throw new \Exception(['code' => $e->getCode(), 'msg' => $e->getMessage()], 2);
        }

        return $files;
    }

    // 비율로 자르기
    public static function imageResize($image, $width, $height, $folder, $name, $extension, $ratio = 16/9)
    {
        $folderPath = File::folderPath($folder);
        $fileName   = File::fileName($name, $extension);
        $fullPath   = File::fullPath($folderPath, $fileName);

        try {
            if (intval(($image->width() / $ratio) > $image->height())) {

                if ($width > $image->width()) {
                    $height = $image->height();
                }

                $image->fit(intval($height * $ratio), $height);

            } else {

                if ($height > $image->height()) {
                    $width = $image->width();
                }

                $image->fit($width, intval($width / $ratio));
            }

            \Storage::disk('s3')->put($fullPath, $image->stream()->__toString());
        } catch (\Exception $e) {
            throw new \Exception(['code' => $e->getCode(), 'msg' => $e->getMessage()], 3);
        }

        return [
            'name' => $fileName,
            'path' => $fullPath
        ];
    }


    public static function folderPath($folder)
    {
        $now = \Carbon\Carbon::today()->format('Y/mobile/d');
        return $folder.'/'.$now;
    }

    public static function fileName($name, $extension)
    {
        $code = sha1(time());
        return $name.'_'.$code.'.'.$extension;
    }

    public static function fullPath($folder_path, $file_name)
    {
        return $folder_path.'/'.$file_name;
    }

    public static function cover($model, $cover, $content)
    {
        try {
            // 표지 등록 (mobile, tablet, pc순으로 이미지를 가공한다)
            // - 사용자
            // -- 본문에서 첫번째의 이미지가 표지가 된다
            //
            // - 관리자
            // -- 표지를 입력할 수 있는 폼을 제공한다
            $files = [];
            if ($cover) {
                $files = File::createCover($cover);
            } else {
                $cover = File::firstPhoto($content);

                if ($cover == 'iframe') {
                    $cover_url = File::mainIframe($content);
                } else if ($cover == 'image') {
                    $cover_url = File::mainPhoto($content);
                } else {
                    $cover_url = null;
                }

                if ($cover_url) {
                    $files = File::createCover($cover_url);
                }
            }

            // 연관 관계 등록
            if ($files) {
                foreach ($files as $file) {
                    $model->files()->save($file);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception(\Lang::get('article.alert.upload_file_error'), 1001001);
        }
    }

    public static function firstPhoto($content)
    {
        $matches = [];
        preg_match( '@src="([^"]+)"@' , $content, $matches );

        if ($matches) {
            $urls = $matches[1];

            if ( preg_match( '/youtube/', $urls ) ) {
                return 'iframe';
            } else if ( preg_match( '/vimeo/', $urls ) ) {
                return 'iframe';
            } else if (preg_match("/^.*\.(jpg|jpeg|png|gif)$/i", $urls)) {
                return 'image';
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function mainPhoto($content)
    {
//       // img 태그 전체 추출하기
//       print_r($matches[0]);
//       print_r($matches[1]);
        $matches = [];
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

        $urls = $matches[1];
        if (!empty($urls)) {
            return $urls[0];
        }

        return null;
    }

    public static function mainIframe($content)
    {
        $first_url = null;

        $matches = [];
        preg_match_all("/<iframe.*src=\"(.*)\".*><\/iframe>/isU", $content, $matches);
        $urls = $matches[1];
        if (!empty($urls)) {
            $first_url = $urls[0];
        }

        $video_thumb = null;

        if ( preg_match( '/youtube/', $first_url ) ) {
            // YouTube - get the video code if this is an embed code (old embed)
            preg_match( '/youtube\.com\/v\/([\w\-]+)/', $first_url, $match);

            // YouTube - if old embed returned an empty ID, try capuring the ID from the new iframe embed
            if( !isset($match[1]) )
                preg_match( '/youtube\.com\/embed\/([\w\-]+)/', $first_url, $match);

            // YouTube - if it is not an embed code, get the video code from the youtube URL
            if( !isset($match[1]) )
                preg_match( '/v\=(.+)&/',$first_url ,$match);

            // YouTube - get the corresponding thumbnail images
            if( isset($match[1]) )
                $video_thumb = "http://img.youtube.com/vi/".$match[1]."/0.jpg";

        } else if ( preg_match( '/vimeo/', $first_url ) ) {

            dd('vimeo');
            // Vimeo - get the video thumbnail
            preg_match( '#http://player.vimeo.com/video/([0-9]+)#s', $first_url, $match );

            if ( isset($match[1]) ) {

                $video_id = $match[1];

                // Try to get a thumbnail from Vimeo
                $get_vimeo_thumb = unserialize(file_get_contents_curl('http://vimeo.com/api/v2/video/'. $video_id .'.php'));

                $video_thumb = $get_vimeo_thumb[0]['thumbnail_large'];

            }
        }

        return $video_thumb;
    }

    public static function detachAndDeleteFiles($model)
    {
        // model과 연결 된 파일 목록 가져오기
        $files = $model->files()->get();
        if ($files) {
            foreach ($files as $file) {
                // 파일 강제 삭제
                $model->files()->findOrFail($file->id)->forceDelete();
            }

            // 파일과 연결 된 관계 해제
            $model->files()->detach();
        }
    }

}
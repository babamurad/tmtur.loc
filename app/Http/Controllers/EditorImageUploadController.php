<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
//use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager as Image;


class EditorImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image uploaded'], 422);
        }


        $file = $request->file('image');


        if (!$file->isValid()) {
            return response()->json(['error' => 'Upload error'], 422);
        }


// Сделаем уникальное имя
        $ext = strtolower($file->getClientOriginalExtension());
        $name = Str::random(20) . '.' . $ext;


        $destinationPath = public_path('uploads/tours/editor');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }


// Создаём изображение через Intervention (v3)
        $img = Image::make($file->getRealPath());


// Сжать до ширины 1600 (если ширина больше), сохранить аспект
        $img->resize(1600, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });


// Вставка watermark (текст в правом нижнем углу)
        $fontPath = public_path('fonts/Roboto-Regular.ttf'); // положи шрифт сюда
        $text = 'tmtourism.com';


// Параметры: size 18, white with alpha ~0.35
        $img->text($text, $img->width() - 10, $img->height() - 10, function ($font) use ($fontPath) {
            if (file_exists($fontPath)) {
                $font->file($fontPath);
            }
            $font->size(18);
// rgba color with alpha ~0.35 (Intervention поддерживает rgba в color)
            $font->color('rgba(255,255,255,0.35)');
            $font->align('right');
            $font->valign('bottom');
            $font->angle(0);
        });


// Сохраняем в JPEG/PNG в зависимости от расширения, с качеством ~78
        $savePath = $destinationPath . DIRECTORY_SEPARATOR . $name;


// Если png, сохраним png (без качества параметра), иначе jpeg с quality
        if (in_array($ext, ['png'])) {
            $img->save($savePath);
        } else {
            $img->save($savePath, 78); // качество 78 (~75-80%)
        }


// Вернём относительный URL (для вставки в HTML)
        $url = '/uploads/tours/editor/' . $name;


        return response()->json(['success' => true, 'url' => $url], 200);
    }
}

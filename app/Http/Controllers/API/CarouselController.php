<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as AlterImage;



class CarouselController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Carousel::query();

        if ($request->get('per_page')) {
            $per_page = $request->get('per_page');
        } else {
            $per_page = 20;
        }

        if ($request->get('sort')) {
            $sort = $request->get('sort');
        } else {
            $sort = "desc";
        }



        $carousels = $query
            ->with('images')
            // ->filter($request->get('filter'))
            // ->status($request->get('status'))
            // ->whereIn('status_id', [1,3])
            ->orderBy('id', $sort)
            ->paginate($per_page);



        return $this->sendResponse($carousels->toArray(), 'Courses retrieved successfully');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        $carousel = new Carousel;
        $carousel->name = $request->name;
        $carousel->platform = $request->platform;
        $carousel->status = $request->status;
        $carousel->save();
        $id = $carousel->id;


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->validate($request, [

                    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'

                ]);
                // return $originalPath;
                // $path_larg = Storage::disk('public')->put('images/carousels/larg',  $image);
                $url = 'images/carousels/';
                $original_name = $image->getClientOriginalName();
                $ext = "." . pathinfo($original_name, PATHINFO_EXTENSION);
                $imageNewName = $carousel->id . '-' . time() . $ext;

                $path_larg = $url . 'larg/' . $imageNewName;
                $path_medium = $url . 'medium/' . $imageNewName;
                $path_small = $url . 'small/' . $imageNewName;
                $larg_img = $this->transformImage($image, 1280, 1000, $path_larg);
                $medium_img = $this->transformImage($image, 600, 500, $path_medium);
                $small_img = $this->transformImage($image, 150, 120, $path_small);

                // return [$larg_img , $medium_img , $small_img] ;
                if ($larg_img && $medium_img && $small_img) {
                    $image = new Image;
                    $image->fill(
                        [
                            'url' => asset('storage/' . $path_larg),
                            'url_small' => asset('storage/' . $path_small),
                            'url_medium' => asset('storage/' . $path_medium)
                        ]
                    )->save();
                    $image->carousels()->sync($carousel->id);

                } else {
                    return "error al subir imagenes";
                }
            }
            $carousel = Carousel::with('images')->find($id);
            return $this->sendResponse($carousel->toArray(), 'Carousel saved successfully');
        }

        return $this->sendResponse($carousel->toArray(), 'Carousel saved successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);
        return $this->sendResponse($carousel->toArray(), 'Carousel show successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);
        if($request->name)$carousel->name = $request->name;
        if($request->platform)$carousel->platform = $request->platform;
        if($request->status){
            Carousel::where('status','!=',null)
                ->where('id','!=',$id)
                ->where('platform', $carousel->platform)
                ->update(['status'=>null]);

            $carousel->status = $request->status;
        }

        $carousel->save();
        $id = $carousel->id;


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->validate($request, [

                    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'

                ]);
                // return $originalPath;
                // $path_larg = Storage::disk('public')->put('images/carousels/larg',  $image);
                $url = 'images/carousels/';
                $original_name = $image->getClientOriginalName();
                $ext = "." . pathinfo($original_name, PATHINFO_EXTENSION);
                $imageNewName = $carousel->id . '-' . time() . $ext;

                $path_larg = $url . 'larg/' . $imageNewName;
                $path_medium = $url . 'medium/' . $imageNewName;
                $path_small = $url . 'small/' . $imageNewName;
                $larg_img = $this->transformImage($image, 1280, 1000, $path_larg);
                $medium_img = $this->transformImage($image, 600, 500, $path_medium);
                $small_img = $this->transformImage($image, 150, 120, $path_small);

                // return [$larg_img , $medium_img , $small_img] ;
                if ($larg_img && $medium_img && $small_img) {
                    $image = new Image;
                    $image->fill(
                        [
                            'url' => asset('storage/' . $path_larg),
                            'url_small' => asset('storage/' . $path_small),
                            'url_medium' => asset('storage/' . $path_medium)
                        ]
                    )->save();
                    $image->carousels()->sync($carousel->id);

                } else {
                    return "error al subir imagenes";
                }
            }
            $carousel = Carousel::with('images')->find($id);
            return $this->sendResponse($carousel->toArray(), 'Carousel saved successfully');
        }

        return $this->sendResponse($carousel->toArray(), 'Carousel saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);

        if($request->image_id){
            foreach ($carousel->images as $image) {
                if($image->id == $request->image_id){
                    $img = Image::find($image->id);
                    $imgName = explode("/", $image->url);
                    // return $imgName;


                    if($img->delete()){
                        Storage::disk('public')->delete('images/carousels/larg/'.$imgName[7]);
                        Storage::disk('public')->delete('images/carousels/medium/'.$imgName[7]);
                        Storage::disk('public')->delete('images/carousels/small/'.$imgName[7]);
                        $carousel = Carousel::with('images')->findOrFail($id);
                        return $this->sendResponse($carousel->toArray(), 'Image deleted successfully');
                    }

                    // return response()->json($carousel, 200);


                }
            }
        }else{

            foreach ($carousel->images as $image) {
                $img = Image::find($image->id);
                $imgName = explode("/", $image->url);
                Storage::disk('public')->delete('images/carousels/larg/'.$imgName[7]);
                Storage::disk('public')->delete('images/carousels/medium/'.$imgName[7]);
                Storage::disk('public')->delete('images/carousels/small/'.$imgName[7]);
                $img->delete();

            }
            $carousel->delete();
            return $this->sendSuccess('Carousel deleted successfully');
        }

    }


    public function active(Request $request)
    {
        $platform = $request->platform;
        $active_carousel = Carousel::with('images')
                                ->where('platform',$platform)
                                ->where('status','!=', null)
                                ->where('status','!=', 0)
                                ->first();

        return response()->json($active_carousel->images, 200);
    }


    private function transformImage($image, $width, $height, $path)
    {
        $result_image = AlterImage::make($image);
        $result_image->resize($width, null, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        } );
        // $larg_image->crop(1280,800);
        $store = Storage::disk('public')->put( $path, $result_image->stream());
        return $store;

    }
}


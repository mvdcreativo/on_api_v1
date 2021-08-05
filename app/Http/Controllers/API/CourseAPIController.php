<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseAPIRequest;
use App\Http\Requests\API\UpdateCourseAPIRequest;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as AlterImage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductFacebookExport;
use App\Models\Image;
use Response;

/**
 * Class CourseController
 * @package App\Http\Controllers\API
 */

class CourseAPIController extends AppBaseController
{
    /**
     * Display a listing of the Course.
     * GET|HEAD /courses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

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



        $courses = $query
            ->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'images')
            ->filter($request->get('filter'))
            ->status($request->get('status'))
            // ->whereIn('status_id', [1,3])
            ->orderBy('id', $sort)
            ->paginate($per_page);



        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
    }

    /**
     * Store a newly created Course in storage.
     * POST /courses
     *
     * @param CreateCourseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseAPIRequest $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->title);
        /** @var Course $course */
        $course = Course::create($input);
        $id = $course->id;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->validate($request, [

                    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'

                ]);
                // return $originalPath;
                // $path_larg = Storage::disk('public')->put('images/courses/larg',  $image);
                $url = 'images/courses/';
                $original_name = $image->getClientOriginalName();
                $ext = "." . pathinfo($original_name, PATHINFO_EXTENSION);
                $imageNewName = $course->id . Str::random(4) .'-' . time() . $ext;

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
                    $image->courses()->sync($course->id);

                } else {
                    return "error al subir imagenes";
                }
            }
            $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'schedules', 'images')->find($id);
            return $this->sendResponse($course->toArray(), 'Course saved successfully');
        }
        if ($request->categories) {
            $categories = json_decode($request->categories);
            // foreach ($categories as $categoria) {
            // }
            $course->categories()->sync($categories, true);
        }

        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'schedules', 'images')->find($id);

        return $this->sendResponse($course->toArray(), 'Course saved successfully');
    }

    /**
     * Display the specified Course.
     * GET|HEAD /courses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Course $course */
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'schedules', 'images')
            ->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }





    /**
     * Update the specified Course in storage.
     * PUT/PATCH /courses/{id}
     *
     * @param int $id
     * @param UpdateCourseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseAPIRequest $request)
    {
        /** @var Course $course */
        $course = Course::find($id);
        // return $request->all();
        // return $request->all();
        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->fill($request->all());

        $course->slug = isset($request->title) ? Str::slug($request->title) :  $course->slug;
        $course->save();


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->validate($request, [

                    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'

                ]);
                // return $originalPath;
                // $path_larg = Storage::disk('public')->put('images/courses/larg',  $image);
                $url = 'images/courses/';
                $original_name = $image->getClientOriginalName();
                $ext = "." . pathinfo($original_name, PATHINFO_EXTENSION);
                $imageNewName = $course->id . Str::random(4) . '-' . time() . $ext;

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
                    $image->courses()->sync($course->id);
                } else {
                    return "error al subir imagenes";
                }
            }
            $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'schedules', 'images')->find($id);
            return $this->sendResponse($course->toArray(), 'Course saved successfully');
        }

        if ($request->categories) {
            $categories = json_decode($request->categories);
            $course->categories()->sync($categories, true);
        }
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'schedules', 'images')->find($id);

        return $this->sendResponse($course->toArray(), 'Course updated successfully');
    }



    /**
     * Remove the specified Course from storage.
     * DELETE /courses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {

        $course = Course::with('images')->findOrFail($id);

        if($request->image_id){
            foreach ($course->images as $image) {
                if($image->id == $request->image_id){
                    $img = Image::find($image->id);
                    $imgName = explode("/", $image->url);
                    // return $imgName;


                    if($img->delete()){
                        Storage::disk('public')->delete('images/courses/larg/'.$imgName[7]);
                        Storage::disk('public')->delete('images/courses/medium/'.$imgName[7]);
                        Storage::disk('public')->delete('images/courses/small/'.$imgName[7]);
                        $course = Course::with('images')->findOrFail($id);
                        return $this->sendResponse($course->toArray(), 'Image deleted successfully');
                    }

                    // return response()->json($course, 200);


                }
            }
        }else{

            foreach ($course->images as $image) {
                $img = Image::find($image->id);
                $imgName = explode("/", $image->url);
                Storage::disk('public')->delete('images/courses/larg/'.$imgName[7]);
                Storage::disk('public')->delete('images/courses/medium/'.$imgName[7]);
                Storage::disk('public')->delete('images/courses/small/'.$imgName[7]);
                $img->delete();

            }
            $course->delete();
            return $this->sendSuccess('Course deleted successfully');
        }
    }


    public function clone(Request $request)
    {
        $request->validate(['id' => 'required']);

        $course = Course::find($request->id);


        $title = $course->title;
        $course->title = "COPIA-" . $title;
        $course->slug = Str::slug("COPIA-" . $title);
        $course->status_id = 2;
        $course->group = $course->group + 1;
        $course->cupos_confirmed = 0;
        if (!isset($course->original_id)) $course->original_id = $course->id;


        $duplicatedModel = $course->saveAsDuplicate();

        return $this->sendResponse($duplicatedModel->toArray(), 'Course saved successfully');
    }


    /**
     * Display the specified Course.
     * GET|HEAD /course/{slug}
     *
     * @param string $slug
     *
     * @return Response
     */
    public function showBySlug($slug)
    {
        /** @var Course $course */
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills', 'level', 'schedules', 'images')
            ->where('slug', $slug)
            ->whereIn('status_id', [1, 3])
            ->first();

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }



    /**
     * Display a listing of the Course by slug Category
     * GET|HEAD courses-category/{slug}
     *
     * @param String $slug
     * @return Response
     */
    public function getByCategorySlug($slug)
    {
        $category = Category::select(['id', 'slug', 'color', 'name'])
            ->with('courses', 'courses.courseSections', 'courses.lengthUnit', 'courses.categories', 'courses.currency', 'courses.user_instructor', 'courses.schedules')
            ->filter_status()
            ->where('slug', $slug)
            // ->whereIn('status_id', [1,3])
            ->firstOrFail();

        $courses = $category;

        // $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        // ->where('category_id',$category_id)->get();

        if (empty($courses)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($courses->toArray(), 'Course retrieved successfully');
    }


    /**
     * Display a listing of the Course destac
     * GET|HEAD courses-destac/
     *
     * @param String $slug
     * @return Response
     */
    public function getCoursesDestac(Request $request)
    {
        $query = Course::query();

        $courses = $query->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'images')
            ->where('status_id', 3)
            ->get();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
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

    public function exportFaceboock()
    {
        // Storage::disk('public')->put('images/productos',  $img);
        // return Excel::download(new ProductFacebookExport, 'da_catalog_commerce_commented_template.csv');//'da_catalog_commerce_commented_template.csv'

        return Excel::store(new ProductFacebookExport, 'exports/facebook/da_catalog_commerce_commented_template.csv', 'public'); //'da_catalog_commerce_commented_template.csv'

    }
}

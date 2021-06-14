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
        }else{
            $per_page = 20;
        }
        
        if ($request->get('sort')) {
            $sort = $request->get('sort');
        }else{
            $sort = "desc";
        }



        $courses = $query
            ->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
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

        if($request->hasFile('image')){
            $image = $request->file('image');
            $this->validate($request, [

                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048000'
    
            ]);

            $url = 'images/courses/';
            $imageNewName = $course->id.'-'.time().'.jpg';

            $path_larg = $url.'larg/'.$imageNewName;
            $thumbnail = $url.'thumbnail/'.$imageNewName;
            $larg_img = $this->transformImage($image, 730, 500, $path_larg);
            $thumbnail_img = $this->transformImage($image, 150, 100, $thumbnail);

            // return [$larg_img , $medium_img , $small_img] ;
            if ($larg_img && $thumbnail_img) {
                
                $course->fill(
                    [
                        'image' => asset('storage/'.$path_larg),
                        'thumbnail' => asset('storage/'.$thumbnail),
                    ])->save();
            }else{
                return "error al subir imagenes";
            }
        }
        if($request->categories){
            $categories = json_decode($request->categories);
            // foreach ($categories as $categoria) {
            // }
            $course->categories()->sync($categories,true);
        }

        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency','adquiredSkills','schedules')->find($id);

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
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency','adquiredSkills','schedules')
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
        $course->slug = Str::slug($request->title);
        $course->save();

        

        if($request->hasFile('image')){
            $image = $request->file('image');
            $this->validate($request, [

                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048000'
    
            ]);

            $url = 'images/courses/';
            $imageNewName = $course->id.'-'.time().'.jpg';

            $path_larg = $url.'larg/'.$imageNewName;
            $thumbnail = $url.'thumbnail/'.$imageNewName;
            $larg_img = $this->transformImage($image, 730, 500, $path_larg);
            $thumbnail_img = $this->transformImage($image, 150, 100, $thumbnail);

            // return [$larg_img , $medium_img , $small_img] ;
            if ($larg_img && $thumbnail_img) {
                
                $course->fill(
                    [
                        'image' => asset('storage/'.$path_larg),
                        'thumbnail' => asset('storage/'.$thumbnail),
                    ])->save();
            }else{
                return "error al subir imagenes";
            }
        }
        if($request->categories){
            $categories = json_decode($request->categories);
            $course->categories()->sync($categories,true);
        }
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency', 'adquiredSkills','schedules')->find($id);

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
    public function destroy($id)
    {
        /** @var Course $course */
        $course = Course::find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->delete();

        return $this->sendSuccess('Course deleted successfully');
    }


    public function clone(Request $request){
        $request->validate(['id' => 'required']);

        $course = Course::find($request->id);


        $title = $course->title;
        $course->title = "COPIA-".$title;
        $course->slug = Str::slug("COPIA-".$title);
        $course->status_id = 2;
        $course->group = $course->group +1;
        $course->cupos_confirmed = 0;
        if(!isset($course->original_id)) $course->original_id = $course->id;
        

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
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency','adquiredSkills', 'level', 'schedules')
                ->where('slug',$slug)
                ->whereIn('status_id', [1,3])
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
        $category = Category::select(['id','slug','color','name'])
        ->with('courses','courses.courseSections', 'courses.lengthUnit','courses.categories', 'courses.currency', 'courses.user_instructor', 'courses.schedules')
        ->filter_status()
        ->where('slug',$slug)
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

        $courses = $query->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        ->where('status_id', 3)
        ->get();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');     
    }


    
    private function transformImage($image, $width, $height, $path)
    {
        $result_image = AlterImage::make($image)->encode('jpg',75);
        $result_image->resize($width, $height, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        } );
        // $larg_image->crop(1280,800);
        $store = Storage::disk('public')->put( $path, $result_image->stream());
        return $store;
        
    }

    public function exportFaceboock(){
        // Storage::disk('public')->put('images/productos',  $img);
        // return Excel::download(new ProductFacebookExport, 'da_catalog_commerce_commented_template.csv');//'da_catalog_commerce_commented_template.csv'

        return Excel::store(new ProductFacebookExport, 'exports/facebook/da_catalog_commerce_commented_template.csv', 'public');//'da_catalog_commerce_commented_template.csv'

    }

}

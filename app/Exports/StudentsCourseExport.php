<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;




class StudentsCourseExport implements FromQuery , WithMapping, WithHeadings
{


    use Exportable;

    public function __construct(int $course_id)
    {
        $this->course_id = $course_id;
    }


    public function query()
    {
        $course_id = $this->course_id;
        $listStudents = Order::query()->with('user')->whereHas('courses', function (Builder $q) use ($course_id){
            $q->where('course_id', $course_id);
        });
        
        return $listStudents;
    }
 
    public function map($list): array
    {


        return [
            $list->id,
            trim($list->user->name),
            trim($list->user->last_name), 
            $list->user->email, 
            trim($list->user->account->type_doc_iden." ".$list->user->account->n_doc_iden), 
            trim($list->user->account->phone_one." ".$list->user->account->phone_two),
            Carbon::parse($list->user->account->birth)->format('d/m/Y'),
        ];
    }


    // Headers columnas
    public function headings(): array
    {
        return [
            'ID',
            'Nombre', 
            'Apellido', 
            'Email', 
            'Documento', 
            'Teléfonos',
            'F.Nac.'
        ];
    }





}

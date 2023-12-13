<?php

namespace App\Exports;


use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyReportExport implements FromCollection, WithHeadings
{
    protected $data;

    //to receives data that will be used for export and stores it in the $data property.
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() //
    {
        return collect($this->data)->map(function ($item) {

            $dateStart = new DateTime($item->date_start);// date start function
            $dateEnd = new DateTime($item->date_end);// date end function

            // Calculate the difference between dates
            $dateDiff = $dateStart->diff($dateEnd);

            // Calculate the total days
            $totalDays = $dateDiff->days + 1;

            // Calculate the total price based on your logic
            $totalPrice = $item->total_participants * $item->price;

            if (Auth()->user()->position === 'admin')//when position is admin
            {
                return [
                    $item->code,
                    $item->title,
                    $item->staff_id,
                    $item->user_category, // user category
                    $item->service,
                    $item->division,
                    $item->user_name,
                    $item->date_start,
                    $item->date_end,
                    $item->category, // training category
                    $item->total_participants,
                    $totalDays,
                    $item->price,
                    $totalPrice,
                    $item->training_hrs,
                    $item->total_training_hrs, // Include total_training_hrs
                ];
            } else //when the position others than admin
            {
                return [
                    $item->staff_id,
                    $item->user_name,
                    $item->code,
                    $item->title,
                    $item->date_start,
                    $totalDays,
                    $item->duration,
                    $item->category,
                    $item->location,
                    $item->organizer,
                    $item->price,
                ];
            }
        });
    }

    public function headings(): array //heading use to provides the column headings for the Excel file.
    {
        if (Auth()->user()->position === 'admin') {
            return [
                'Training Code',
                'Training Title',
                'Staff ID',
                'Position/Category',
                'Service',
                'Division',
                'Training Category',
                'Staff Name',
                'Date Start',
                'Date End',
                'Total Participants',
                'Total Days',
                'Price',
                'Total Price',
                'Training Hours',
                'Total Training Hours',
            ];
        } else {

            return [
                'Staff Id',
                'Staff Name',
                'Training Code',
                'Training Title',
                'Date Start',
                'Total Days',
                'Training Hours',
                'Category',
                'Venue',
                'Organizer',
                'Fee',
            ];
        }
    }
}

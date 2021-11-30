<?php

namespace App\Imports;

use App\Models\Trainer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Validation\Rule;
use Throwable;

class TrainersImport implements ToModel,WithHeadingRow,SkipsOnError,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable, SkipsErrors;
    public function model(array $row)
    {
        return new Trainer([
            'name'     => $row['name'],
            'email'     => $row['email'],
            'phone'     => $row['phone'],
        ]);
    }
    public function rules(): array
    {
        return [
            '*.email' => ['email','unique:trainers,email']
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBundleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bundle_no'      => ['required', 'string', 'max:50', 'unique:production_bundles,bundle_no'],
            'buyer_id'       => ['required', 'exists:buyers,id'],
            'style_id'       => ['required', 'exists:styles,id'],
            'color'          => ['nullable', 'string', 'max:100'],
            'size'           => ['nullable', 'string', 'max:50'],
            'line_id'        => ['required', 'exists:sewing_lines,id'],
            'quantity'       => ['required', 'integer', 'min:1'],
            'completed_qty'  => ['required', 'integer', 'min:0', 'lte:quantity'],
            'rejected_qty'   => ['required', 'integer', 'min:0', 'lte:quantity'],
            'operator_name'  => ['nullable', 'string', 'max:150'],
            'production_date'=> ['required', 'date', 'before_or_equal:today'],
            'remarks'        => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            $qty       = (int) ($data['quantity']      ?? 0);
            $completed = (int) ($data['completed_qty'] ?? 0);
            $rejected  = (int) ($data['rejected_qty']  ?? 0);

            if (($completed + $rejected) > $qty) {
                $validator->errors()->add('completed_qty', 'Completed + Rejected cannot exceed Quantity.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'bundle_no.unique'            => 'This Bundle Number already exists.',
            'quantity.min'                => 'Quantity must be greater than zero.',
            'completed_qty.lte'           => 'Completed Quantity cannot exceed Quantity.',
            'rejected_qty.lte'            => 'Rejected Quantity cannot exceed Quantity.',
            'production_date.before_or_equal' => 'Production Date cannot be a future date.',
        ];
    }
}

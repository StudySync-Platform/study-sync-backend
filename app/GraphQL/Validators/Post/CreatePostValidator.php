<?php

namespace App\GraphQL\Validators\Post;

use App\Enums\Visibility;
use Nuwave\Lighthouse\Validation\Validator;

class CreatePostValidator extends Validator
{
    public function rules(): array
    {
        $visibilityValues = collect(Visibility::cases())->pluck('value')->join(',');

        return [
            'input.content'        => ['required', 'string', 'max:20000'],
            'input.room_id'        => ['nullable', 'integer', 'exists:rooms,id'],
            'input.media_urls'     => ['nullable', 'array', 'max:10'],
            'input.media_urls.*'   => ['url', 'max:2048'],
            'input.visibility'     => ['required', "in:$visibilityValues"],
            'input.type'           => ['required', 'string', 'in:text,image,poll,video,link'],
        ];
    }

    public function messages(): array
    {
        return [
            'input.visibility.in' => 'Visibility must be one of: '.collect(Visibility::cases())->pluck('value')->join(', '),
        ];
    }
}

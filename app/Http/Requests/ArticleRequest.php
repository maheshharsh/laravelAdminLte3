<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the article ID if this is an update request (from route binding)
        $articleId = $this->route('article')?->id;

        return [
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['required', 'string', 'max:255', 'unique:articles,slug' . ($articleId ? ',' . $articleId : '')],
            'sub_content'      => ['nullable', 'string'],
            'content'          => ['nullable', 'string'],
            'featured_image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'gallery_images'   => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'user_id'          => ['nullable', 'integer', 'exists:users,id'],
            'published_at'     => ['nullable', 'date', 'before_or_equal:now'],
            'is_featured'      => ['nullable', 'boolean'],
            'is_published'     => ['nullable', 'boolean'],
            'is_carousel'      => ['nullable', 'boolean'],
        ];
    }
}


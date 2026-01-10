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
            'video_file'       => ['nullable', 'file', 'mimes:mp4,avi,mov,wmv,flv,webm,mkv', 'max:51200'], // 50MB max
            'video_thumbnail'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'video_description'=> ['nullable', 'string', 'max:1000'],
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'user_id'          => ['nullable', 'integer', 'exists:users,id'],
            'published_at'     => ['nullable', 'date'],
            'is_featured'      => ['nullable', 'boolean'],
            'is_published'     => ['nullable', 'boolean'],
            'is_carousel'      => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'video_file.max' => 'Video file size must be less than 50MB.',
            'video_file.mimes' => 'Video file must be in MP4, AVI, MOV, WMV, FLV, WebM, or MKV format.',
            'video_thumbnail.max' => 'Video thumbnail must be less than 2MB.',
            'video_thumbnail.image' => 'Video thumbnail must be an image file.',
            'video_description.max' => 'Video description cannot exceed 1000 characters.',
            'featured_image.max' => 'Featured image must be less than 2MB.',
            'gallery_images.*.max' => 'Each gallery image must be less than 2MB.',
        ];
    }
}


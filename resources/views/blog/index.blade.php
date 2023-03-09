{{$blog[0]->title}}
{{$blog[1]->title}}

@foreach ($blog[0]->tags as $tag)
    {{$tag->name}}
@endforeach
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            {{ $category->name }}
            @if ($category->active)<span class="label label-success pull-right">active</span>@else <span class="label label-danger pull-right">inactive</span> @endif
        </h4>
    </div>
    <ul class="list-group">
        <li class="list-group-item"><strong>{{ Lang::get('forms.updated') }}:</strong><br>{{ $category->updated_at }}</li>
        <li class="list-group-item"><strong>{{ Lang::get('forms.parent_category') }}:</strong><br>@if($category->category_id > 0){{ $category->parentCategory->name }}@else{{ "None" }}@endif</li>
        <li class="list-group-item"><strong>{{ Lang::get('forms.priority_order') }}:</strong><br>{{ $category->order }}</li>
        <li class="list-group-item"><strong>{{ Lang::get('forms.summary') }}:</strong><br>{{ $category->short_description }}</li>
        <li class="list-group-item"><strong>{{ Lang::get('forms.description') }}:</strong><br>{!! $category->long_description !!}</li>
        @if($category->images()->count() > 0)
        <li class="list-group-item">
            @foreach( $category->images as $image )
            {!! HTML::image($imagine->getUrl($image->path), $category->name, array('class' => 'img-thumbnail', 'alt' => $image->path)) !!}
            @endforeach
        </li>
        @endif
    </ul>
    <div class="panel-footer text-right">
        <a href="{{ URL::to('admin/categories/edit/' . $category->id) }}" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i>{{ Lang::get('buttons.edit') }}</a>
        <a href="{{ URL::to('admin/categories/delete/' . $category->id) }}" class="btn btn-danger btn-confirm"><i class="glyphicon glyphicon-remove"></i>{{ Lang::get('buttons.delete') }}</a>
    </div>
</div>

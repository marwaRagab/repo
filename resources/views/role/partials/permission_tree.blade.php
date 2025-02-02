<li>
    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->name }}
    @if ($permission->children->isNotEmpty())
        <ul>
            @foreach ($permission->children as $child)
                @include('role.partials.permission_tree', ['permission' => $child])
            @endforeach
        </ul>
    @endif
</li>

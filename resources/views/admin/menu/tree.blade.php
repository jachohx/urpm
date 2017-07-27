<li class="dd-item" data-id="<?php echo $branch['id'] ?>">
    <div class="dd-handle">
        <strong><i class="fa {{ $branch['icon'] }}"></i>  {{ $branch['title'] }}</strong>
        @if(!isset($branch['children']))
        <a href="{{ $branch['uri'] }}" class="dd-nodrag">{{ $branch['uri'] }}</a>
        @endif
        <span class="pull-right action dd-nodrag" data-field-name="_edit">
            {{-- 权限 --}}
            @if (isset($branch['perms']) && !empty($branch['perms']) )
            @foreach ($branch['perms'] as $perm)
            <span class="label label-info">{{ $perm['display_name'] }}</span>
            @endforeach
            @endif
            {{-- 角色 --}}
            @if (isset($branch['roles']) && !empty($branch['roles']) )
            @foreach ($branch['roles'] as $role)
            <span class="label label-primary">{{ $role['display_name'] }}</span>
            @endforeach
            @endif
            <a href="{{ $base_url }}/menu/{{ $branch['id'] }}/edit"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-url="{{ $base_url }}/menu/{{ $branch['id'] }}" class="_delete_"><i class="fa fa-trash"></i></a>
        </span>
    </div>
    @if(isset($branch['children']))
    <ol class="dd-list">
        @foreach ($branch['children'] as $branch)
            @include('admin.menu.tree')
        @endforeach
    </ol>
    @endif
</li>

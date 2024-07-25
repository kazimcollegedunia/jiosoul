
<li class="list-group-item">
    <span class="toggle-children"><h4>{{ $user['user_name'] }} {!! empty($user['children']) ? '<i class="bi bi-node-minus"></i>' : '<i class="bi bi-node-plus icons"></i>' !!}</h4></span>
    @if(!empty($user['children']) && count($user['children']) > 0)
        <ul class="child-nodes list-group">
            @foreach($user['children'] as $child)
                @include('layout.recursive_node', ['user' => $child])
            @endforeach
        </ul>
    @endif
</li>


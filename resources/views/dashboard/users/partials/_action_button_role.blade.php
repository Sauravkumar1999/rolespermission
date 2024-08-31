<div class="d-inline-block text-nowrap">
    @can('role.permission.show')
        <button onclick="" class="btn btn-sm btn-icon editor-permission" data-id="{{ $data->id }}">
            <i class="ri-spy-fill text-secondary ri-lg"></i></button>
    @endcan
    @can('role.edit')
        <button class="btn btn-sm btn-icon editor-edit"><i class="ri-edit-box-fill text-warning ri-lg"></i></button>
    @endcan
    @can('role.delete')
        <button class="btn btn-sm btn-icon editor-delete"><i class="ri-delete-bin-6-fill text-danger ri-lg"></i></button>
    @endcan
</div>

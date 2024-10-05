<div class="d-inline-block text-nowrap">
    @can('user.premission.show')
        <button onclick="" class="btn btn-sm btn-icon editor-permission" data-id="{{ $data->id }}">
            <i class="ri-spy-fill text-secondary ri-xl"></i></button>
    @endcan
    @can('user.edit')
        <button class="btn btn-sm btn-icon editor-edit"><i class="ri-edit-box-fill text-warning ri-xl"></i></button>
    @endcan
    @can('user.delete')
        <button class="btn btn-sm btn-icon editor-delete"><i class="ri-delete-bin-5-line text-danger ri-xl"></i></button>
    @endcan
</div>
